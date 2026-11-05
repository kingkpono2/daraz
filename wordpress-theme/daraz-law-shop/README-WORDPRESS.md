# Daraz Law Shop — native WordPress / WooCommerce theme

This is a **real WordPress theme**, converted from the HTML/CSS/JavaScript Daraz Law Shop prototype in this repository. It preserves the editorial look while replacing client-side demo cart, hardcoded products, simulated payments, and mock orders with WordPress pages and WooCommerce.

## Install

1. Download the repository or use the installation ZIP generated from the \`wordpress-theme/daraz-law-shop/\` directory. Zip **the daraz-law-shop folder itself** so the ZIP root contains \`daraz-law-shop/style.css\` and \`daraz-law-shop/functions.php\`.
2. WordPress dashboard → Appearance → Themes → Add New → Upload Theme → activate **Daraz Law Shop**.
3. Install and activate **WooCommerce**. Let its guided setup create Shop, Cart, Checkout, and My Account pages. Set your store's Nigerian address, currency (NGN), shipping zones, taxes where applicable, and customer emails.
4. Configure a **live, verified payment gateway** via a maintained WooCommerce integration (e.g. Paystack for WooCommerce) under WooCommerce → Settings → Payments. The theme does not process card data or claim payments are live before this step.
5. Add real products: WooCommerce → Products. Set names, prices, inventory, variable sizes, product photos, descriptions and category images. Mark key products as Featured using WooCommerce's standard Featured control.
6. Appearance → Customize → **Daraz homepage**: edit headline, intro, story and hero photo. In **Daraz contact details**, set the real phone, WhatsApp number, email and social links. Set your logo under **Site Identity**.
7. Create a page called Home and set it as the static front page under Settings → Reading. Create a Posts page for your blog (e.g. Journal).
8. To add standard pages in one click, open **Appearance → Daraz Setup → Create missing pages**. This creates Home, Journal, About, Contact, FAQ, Size Guide, Delivery & Returns and Track Order (published), plus Privacy Policy and Terms & Conditions (drafts until approved). It never overwrites existing pages. Alternatively, create standard pages with these URL slugs, edit their copy in WordPress and publish when accurate: \`about\`, \`contact\`, \`faq\`, \`size-guide\`, \`delivery-returns\`, \`track-order\`, \`privacy-policy\`, \`terms-and-conditions\`. Their specialized templates are picked up automatically by WordPress. The legal pages must be reviewed and filled out by the merchant.
9. Appearance → Menus: assign a menu to **Main navigation** and another to **Footer navigation**. Optionally add native WooCommerce filter widgets in Appearance → Widgets → **Shop filters**.
10. Settings → Permalinks → Post name (recommended); save once to flush routes. Test on mobile and desktop.

## Included page templates

- \`front-page.php\`: editorial homepage with WooCommerce categories and featured products from the database
- \`index.php\`, \`archive.php\`, \`single.php\`: journal, taxonomies/archives, and articles
- \`page.php\`: content, service pages and WordPress block editor content
- \`search.php\`, \`searchform.php\`: product and post searching
- \`404.php\`: branded missing page
- \`comments.php\`: native WordPress comments
- \`page-about.php\`, \`page-contact.php\`, \`page-faq.php\`, \`page-size-guide.php\`, \`page-delivery-returns.php\`, \`page-privacy-policy.php\`, \`page-terms-and-conditions.php\`, \`page-track-order.php\`: relevant store information and legal pages.
- WooCommerce's own maintained single-product, variable-product, product-category, shop, cart, checkout, customer account and order templates are styled by the theme without overriding WooCommerce's commerce logic.

## What is not mocked

No sample orders, fake transactions, fake availability, preset cart items, or JavaScript payment success flags. The underlying catalogue, stock, customer accounts, checkout/order records and tax/shipping rules must come from WooCommerce. The theme intentionally does **not** invent delivery or returns terms, privacy notices, warranties or clothing measurements.

## Existing prototype

The original Node.js prototype remains untouched in \`public/\` and can still be run separately. The production WordPress theme lives **only** in \`wordpress-theme/daraz-law-shop/\`. This preserves history and allows an independent migration.

## Launch checklist

- Replace editorial reference image cuts with approved high-resolution product photography.
- Verify published delivery, returns, terms and privacy copy with the merchant.
- Complete WooCommerce store address, order emails, shipping/tax rules, and gateway webhooks.
- Verify variable product sizes, sale prices, inventory behavior, shopping cart, real sandbox gateway, failed payments, verified callbacks, order emails, refunds, and password reset.
- Run accessibility and mobile checks, PageSpeed, schema/SEO plugin checks, and backup/staging tests.
- Use a full-site backup and a staging site before replacing any existing live WordPress theme.
