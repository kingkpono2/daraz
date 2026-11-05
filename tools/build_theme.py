#!/usr/bin/env python3
"""Produce an installable WordPress ZIP with optimized editorial art.

Original design-reference PNGs remain intact in the Git history/source.
The shipping theme contains one WebP reference sheet and a resized preview.
"""
from __future__ import annotations

import argparse
from io import BytesIO
from pathlib import Path
from zipfile import ZipFile, ZIP_DEFLATED
from PIL import Image

SKIP = {
    "assets/images/editorial-home.png",
    "assets/images/editorial-catalogue.png",
    "assets/images/editorial-cart.png",
    "assets/images/editorial-checkout.png",
    "assets/images/editorial-confirmation.png",
    "screenshot.png",
}


def package(theme: Path, output: Path) -> None:
    theme = theme.resolve()
    if not (theme / "style.css").exists() or not (theme / "functions.php").exists():
        raise ValueError(f"Missing required theme files in {theme}")
    output.parent.mkdir(parents=True, exist_ok=True)
    with ZipFile(output, "w", ZIP_DEFLATED, compresslevel=9) as archive:
        for filepath in sorted(theme.rglob("*")):
            if not filepath.is_file():
                continue
            relative = filepath.relative_to(theme).as_posix()
            if relative in SKIP:
                continue
            archive.write(filepath, f"daraz-law-shop/{relative}")

        # SVG crops use the same 1024x1536 source coordinate system.
        home = Image.open(theme / "assets/images/editorial-home.png").convert("RGB")
        webp = BytesIO()
        home.save(webp, format="WEBP", quality=82, method=6)
        archive.writestr("daraz-law-shop/assets/images/editorial-home.webp", webp.getvalue())

        # WordPress theme screenshot shows the overall aesthetic (1200 x 900),
        # not a substitute for live-browser screenshots or product photographs.
        screenshot = Image.open(theme / "screenshot.png").convert("RGB")
        screenshot.thumbnail((1200, 900), Image.Resampling.LANCZOS)
        sw, sh = screenshot.size
        if (sw, sh) != (1200, 900):
            canvas = Image.new("RGB", (1200, 900), "#f9f8f5")
            canvas.paste(screenshot, ((1200 - sw) // 2, (900 - sh) // 2))
            screenshot = canvas
        png = BytesIO()
        screenshot.quantize(colors=192, method=Image.Quantize.MEDIANCUT).save(png, format="PNG", optimize=True)
        archive.writestr("daraz-law-shop/screenshot.png", png.getvalue())
    print(f"{output}: {output.stat().st_size:,} bytes")


if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument("--theme", type=Path, default=Path("wordpress-theme/daraz-law-shop"))
    parser.add_argument("--output", type=Path, default=Path("daraz-law-shop.zip"))
    args = parser.parse_args()
    package(args.theme, args.output)
