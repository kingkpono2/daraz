# Daraz Law Shop proof of concept

Responsive HTML/CSS/JavaScript storefront using hardcoded products and original design concepts. Includes home, catalogue, cart, checkout and confirmation; category/size/price filters; persistent cart; product size selection; cart drawer; fly-to-cart animation; demo success/failure payment flows and receipt download.

## Run

Requires Node.js 22 or later. No dependencies to install.

```sh
npm start
```

Open http://localhost:3000. The first visit seeds the reference bag with a gown and court bands. Use Reset demo bag in the footer to restore it.

## Deploy on Railway

Connect this repository to a Railway service. The Dockerfile is detected automatically. Generate a public domain in Networking. The server uses Railway's PORT environment variable and /health is the health check.

## Prototype boundaries

No real Paystack integration, orders, emails, inventory or shipping. Payment outcomes are explicitly simulated. Cart is browser-local; demo order and supplied sample details are stored only in session storage. Do not enter real personal or payment information.

Images are generated design references reused through CSS image windows. Production needs approved product photos, merchant content, final sizing and policy information, plus server-side payment verification.
