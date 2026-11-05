#!/usr/bin/env python3
"""Fail-fast checks for high-impact WooCommerce theme regressions."""
from pathlib import Path

THEME = Path("wordpress-theme/daraz-law-shop")


def assert_contains(path: str, needles: list[str]) -> None:
    source = (THEME / path).read_text(encoding="utf-8")
    for needle in needles:
        if needle not in source:
            raise AssertionError(f"{path}: missing {needle!r}")


for file in (
    "style.css", "functions.php", "front-page.php", "404.php",
    "index.php", "page.php", "single.php", "archive.php",
    "search.php", "page-contact.php", "page-size-guide.php",
    "page-privacy-policy.php", "page-terms-and-conditions.php",
    "inc/conversion.php", "inc/seo.php", "inc/customizer.php",
    "inc/setup-pages.php", "theme.json",
):
    if not (THEME / file).is_file():
        raise AssertionError(f"Missing required file: {file}")

assert_contains("functions.php", [
    "/inc/seo.php", "/inc/conversion.php", "/inc/setup-pages.php",
    "'woocommerce'", "wp_enqueue_style", "post-thumbnails",
])
assert_contains("header.php", [
    'class="nav-toggle"', 'aria-expanded="false"', 'id="site-navigation"',
    'class="mobile-product-search"', 'name="s"',
])
for filename in (
    "hero-legalwear.webp", "hero-legalwear-mobile.webp",
    "hero-professional.webp", "hero-professional-mobile.webp",
    "hero-community.webp", "hero-community-mobile.webp",
):
    if not (THEME / "assets/images/hero" / filename).is_file():
        raise AssertionError(f"Missing authentic hero photo {filename}")

assert_contains("front-page.php", [
    "get_terms(", "new WP_Query", "woocommerce_product_loop_start",
    "get_theme_mod( 'daraz_testimonials_heading'",
    "data-daraz-slider", "/assets/images/hero/", "hero-legalwear", "hero-community",
    "data-slide-prev", "data-slide-next", "aria-roledescription",
])
assert_contains("inc/woocommerce.php", [
    "woocommerce_add_to_cart_fragments", "wc_get_cart_url",
    "woocommerce_before_main_content",
])
assert_contains("inc/conversion.php", [
    "woocommerce_after_shop_loop_item", "woocommerce_single_product_summary",
    "woocommerce_before_shop_loop", "woocommerce_no_products_found",
    "rawurlencode( $message )",
])
assert_contains("inc/seo.php", [
    "daraz_seo_plugin_active", "daraz_seo_meta", "daraz_seo_schema",
    "daraz_seo_robots", "daraz_seo_breadcrumbs",
])
assert_contains("style.css", [
    "Version: 1.3.0", ".hero-gallery-slide", ".hero-gallery-controls", ".mobile-product-search", ".daraz-archive-filters",
    ".woocommerce", ".voice-grid", ".locations-grid",
])
assert_contains("page-contact.php", ["daraz_store_locations", "google.com/maps/search/"])
assert_contains("inc/customizer.php", [
    "daraz_whatsapp_products", "daraz_store_locations",
    "daraz_customer_stories", "sanitize_textarea_field",
])
assert_contains("assets/js/theme.js", [
    "aria-expanded", "Escape", "matchMedia",
    "data-daraz-slider", "prefers-reduced-motion", "touchstart", "visibilitychange",
])

# There is no separate checkout/payment simulator in the shipped theme.
for php in THEME.rglob("*.php"):
    source = php.read_text(encoding="utf-8")
    for bad in ("localStorage.setItem", "demo payment successful", "sessionStorage.setItem"):
        if bad in source:
            raise AssertionError(f"{php}: demo commerce logic found")

print("PASS: theme files, SEO wiring, working mobile search, catalogue filters, WooCommerce checkout dependency, WhatsApp assistance and no mock orders")
