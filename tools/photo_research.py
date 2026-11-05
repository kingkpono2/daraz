#!/usr/bin/env python3
"""Audit authentic Daraz photos on the live storefront; never scrape third-party sites."""
from pathlib import Path
from PIL import Image, ImageDraw, ImageFont
import io, json, requests, time, os

SOURCES = {
 "ambassador": "2024/01/AMBASSADOR.png",
 "slide-couple-1": "2024/01/294799034_5696098660402172_2739760369760199759_n-1.jpg",
 "slide-couple-2": "2024/01/299185583_5760656110613093_2125773177836433656_n.jpg",
 "slide-possible-3": "2024/01/406201635_936988071199897_5211724824284611170_n.jpg",
 "portfolio-1": "2024/01/398096977_919493339616037_748291655437071803_n.jpg",
 "portfolio-2": "2024/01/405773936_934089611489743_1822998598057115461_n.jpg",
 "portfolio-3": "2024/01/312052273_646840026881371_7092131721886346824_n.jpg",
 "portfolio-4": "2024/01/164092594_4191736967505023_438576523255274221_n.jpg",
 "portfolio-5": "2024/01/240398046_4647449398600442_8940295447355290036_n.jpg",
 "portfolio-6": "2024/01/292289779_5652644278080944_327347964136925153_n.jpg",
 "portfolio-7": "2024/01/291160640_5639939866018052_3286490947940083635_n.jpg",
 "portfolio-8": "2024/01/273722120_5241242655887777_2937942625791540309_n.jpg",
 "product-dutch": "2024/01/IMG-20240122-WA0065.jpg",
 "product-premium-laurel": "2024/01/IMG-20240122-WA0064.jpg",
}
OUT=Path("photo-research");OUT.mkdir(exist_ok=True)
s=requests.Session(); s.headers.update({"User-Agent":"Mozilla/5.0 (compatible; DarazLawShopThemeAssetAudit/1.0)", "Referer":"https://www.darazlawshop.com/"})
tiles=[];report=[]
for name,source in SOURCES.items():
 url="https://www.darazlawshop.com/wp-content/uploads/"+source
 try:
  r=s.get(url,timeout=18);r.raise_for_status()
  im=Image.open(io.BytesIO(r.content));im.load()
  if im.width<350 or im.height<350:raise ValueError("too small")
  im.convert("RGB").save(OUT/(name+".jpg"), quality=91, optimize=True)
  tile=Image.new("RGB",(360,360),"#eeeeee")
  thumb=im.convert("RGB"); thumb.thumbnail((356,290))
  tile.paste(thumb,((360-thumb.width)//2,(300-thumb.height)//2))
  d=ImageDraw.Draw(tile);d.text((9,306),name,fill="#101010");d.text((9,326),f"{im.width}x{im.height}  {len(r.content)//1024}kB",fill="#444444")
  tiles.append(tile)
  report.append({"name":name,"url":url,"width":im.width,"height":im.height,"bytes":len(r.content),"status":"OK"})
  print("OK",name,im.size,flush=True)
 except Exception as e:
  report.append({"name":name,"url":url,"error":str(e),"status":"FAILED"})
  print("FAIL",name,str(e)[:130],flush=True)
 time.sleep(.1)
if not tiles:raise SystemExit("No photos downloadable")
cols=4;rows=(len(tiles)+cols-1)//cols
sheet=Image.new("RGB",(cols*360,rows*360),"#faf9f6")
for i,tile in enumerate(tiles):sheet.paste(tile,((i%cols)*360,(i//cols)*360))
sheet.save(OUT/"contact-sheet.jpg",quality=85)
(OUT/"manifest.json").write_text(json.dumps(report,indent=2))
