#!/usr/bin/env python3
"""Create real-photo, face-safe compact-hero imagery from Daraz's own site.

This is an explicit, one-off creative asset build. Resulting self-hosted WebP
assets are committed in the theme, so live pages never depend on remote image
hotlinks. Source originals are not redistributed in the theme ZIP.
"""
from __future__ import annotations

from io import BytesIO
from pathlib import Path
import json
import requests
from PIL import Image, ImageOps, ImageEnhance, ImageFilter, ImageDraw

HOST = "https://www.darazlawshop.com/wp-content/uploads/2024/01/"
ASSETS = Path("wordpress-theme/daraz-law-shop/assets/images/hero")
SIZE = (1440, 1200)
VARIANTS = (
    {
        "id": "hero-legalwear",
        "source": "406201635_936988071199897_5211724824284611170_n.jpg",
        "layout": "cover",
        "focus": (0.5, 0.48),
        "caption": "Three Nigerian legal professionals in Daraz courtwear",
    },
    {
        "id": "hero-professional",
        "source": "405773936_934089611489743_1822998598057115461_n.jpg",
        "layout": "studio-blend",
        "pad": 5,
        "caption": "Legal professional in gown and neck bands beside a traditional wig",
    },
    {
        "id": "hero-community",
        "source": "294799034_5696098660402172_2739760369760199759_n-1.jpg",
        "layout": "studio-blend",
        "pad": 50,
        "caption": "Two legal professionals displaying Daraz branded shopping bags",
    },
)


def contain_with_soft_edges(image: Image.Image, pad: int) -> Image.Image:
    """Background extension, not a hard crop; keeps faces, wigs and bags visible."""
    W, H = SIZE
    background = ImageOps.fit(image, SIZE, method=Image.Resampling.LANCZOS)
    background = background.filter(ImageFilter.GaussianBlur(72))
    background = Image.blend(background, Image.new("RGB", SIZE, (11, 23, 19)), .18)

    scale = min((W - 2 * pad) / image.width, (H - 2 * pad) / image.height)
    width, height = round(image.width * scale), round(image.height * scale)
    fg = image.resize((width, height), Image.Resampling.LANCZOS)
    left, top = (W - width) // 2, (H - height) // 2

    # Soft feather avoids abrupt horizontal bars and preserves every subject.
    feather = 80
    mask = Image.new("L", (width, height), 255)
    pixels = mask.load()
    for y in range(height):
        y_distance = min(y, height - 1 - y)
        for x in range(width):
            x_distance = min(x, width - 1 - x)
            fraction = min(1.0, x_distance / feather, y_distance / feather)
            pixels[x, y] = round(255 * fraction * fraction * (3 - 2 * fraction))

    background.paste(fg, (left, top), mask)
    return background


def main() -> None:
    ASSETS.mkdir(parents=True, exist_ok=True)
    session = requests.Session()
    session.headers.update({
        "User-Agent": "Mozilla/5.0 (compatible; DarazLawShopTheme/1.3; media optimization)",
        "Referer": "https://www.darazlawshop.com/",
    })

    manifest = []
    for entry in VARIANTS:
        url = HOST + entry["source"]
        response = session.get(url, timeout=35)
        response.raise_for_status()
        if len(response.content) > 9_000_000:
            raise ValueError(f"Unexpectedly large source {url}")
        original = Image.open(BytesIO(response.content)).convert("RGB")
        if original.width < 640 or original.height < 650:
            raise ValueError(f"Source too small: {entry['id']} / {original.size}")

        if entry["layout"] == "cover":
            photo = ImageOps.fit(original, SIZE, Image.Resampling.LANCZOS, centering=entry["focus"])
        else:
            photo = contain_with_soft_edges(original, entry["pad"])
        photo = ImageEnhance.Contrast(photo).enhance(1.025)

        output = ASSETS / (entry["id"] + ".webp")
        photo.save(output, "WEBP", quality=86, method=6)
        mobile = ASSETS / (entry["id"] + "-mobile.webp")
        photo.resize((720, 600), Image.Resampling.LANCZOS).save(
            mobile, "WEBP", quality=84, method=6
        )
        manifest.append({
            "filename": output.name,
            "mobile_filename": mobile.name,
            "source_url": url,
            "source_pixels": list(original.size),
            "output_pixels": list(SIZE),
            "method": entry["layout"],
            "alt_text": entry["caption"],
        })
        print(f"CREATED {output} ({output.stat().st_size} bytes), "
              f"{mobile} ({mobile.stat().st_size} bytes)")

    (ASSETS / "sources.json").write_text(
        json.dumps(manifest, indent=2) + "\n", encoding="utf-8"
    )
    print("All sources are photographs from Daraz's existing public website.")


if __name__ == "__main__":
    main()
