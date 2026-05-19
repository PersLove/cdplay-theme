# CDPLAY 2.0 Project Context

## What CDPLAY 2.0 Is

CDPLAY 2.0 is a premium gaming lifestyle WordPress theme for a store and local gaming platform. The homepage should feel like a place where a person can calmly return to games, choose a platform by mood and life scenario, and understand what to play without being pushed into a dry catalog.

The site can support commerce later, but the homepage is not a product grid. It is a platform-first, emotion-first experience.

## Philosophy

CDPLAY is not only about consoles, games, accessories, or services. It is about the evening when gaming finally feels easy again.

The user should feel:

- "I know what kind of gaming mood I want."
- "I do not need to understand every spec."
- "Someone can help me choose calmly."
- "I can just switch the console on and start playing."

## UX Principles

- Start from emotion and scenario, not from technical comparison.
- Prefer platform and lifestyle navigation over catalog navigation.
- Write in a calm, human tone.
- Keep cards large, readable, and easy to scan.
- Use clear section headers: eyebrow, h2, supporting text.
- Make every section useful on mobile first.
- Avoid forcing a buying decision too early.
- Keep CTAs helpful, not aggressive.

## Visual Direction

- Premium, clean, gaming lifestyle.
- Spacious layouts with strong vertical rhythm.
- Calm atmospheric gradients, never RGB/cyberpunk.
- Soft borders and subtle depth.
- Large cinematic cards with future-ready image slots.
- Light and dark mode through CSS variables.
- No heavy shadows, loud glow effects, or noisy decoration.

## What Not To Do

- Do not turn the homepage into a dry WooCommerce catalog.
- Do not add prices, add-to-cart buttons, or product-card UI to lifestyle sections.
- Do not use aggressive gradients, RGB strips, cyberpunk neon, or acid gaming colors.
- Do not write corporate advantage blocks like "best prices", "since 2011", or "official warranty".
- Do not add carousels, heavy JavaScript, or complex animations for the first version.
- Do not add real images until the visual direction is ready for them.
- Do not make sections feel like SEO filler or a generic marketplace.

## Current Theme Architecture

- `front-page.php` assembles the homepage from section template parts.
- Section templates live in `template-parts/sections/`.
- Layout template parts live in `template-parts/layout/`.
- Main styling lives in `assets/css/main.css`.
- Main JavaScript lives in `assets/js/main.js` and should stay lightweight.

Current homepage flow:

1. Hero
2. Platform Hubs
3. Find Your Console
4. What To Play
5. Ready To Play
6. Services
7. CDPLAY Experience
8. Guides

## Development Rules

- Keep changes scoped.
- Prefer existing CSS variables and spacing tokens.
- Add new tokens only when they make repeated patterns easier to maintain.
- Keep PHP templates semantic and translation-ready.
- Escape output with `esc_html()`, `esc_attr()`, and `esc_url()` where appropriate.
- Keep sections future-ready for images, icons, links, and WordPress loops without wiring those features too early.
- Run PHP lint when PHP files change.
- Run `git diff --check` before handing work back.

## Git Workflow

- Work in small, readable diffs.
- Do not revert unrelated changes.
- Do not rewrite history unless explicitly asked.
- Keep commits focused around one feature or cleanup pass.
- Before a commit, check:
  - `git status --short`
  - `git diff --check`
  - PHP lint for changed PHP files

## Mobile-First Approach

- Mobile layout is the source of truth.
- Desktop enhances spacing, columns, and cinematic scale.
- Bottom navigation must never cover meaningful content.
- Horizontal rails are allowed only with CSS grid/flex and without carousel JavaScript.
- Tap targets should feel comfortable, especially header actions, bottom nav, cards, and CTAs.

## Light/Dark Mode

The theme uses CSS variables under `:root` and `@media (prefers-color-scheme: dark)`.

When adding visual styles:

- Use existing color tokens first.
- Use `color-mix()` for subtle atmospheric variants.
- Avoid hard-coded one-off colors unless a platform accent is required.
- Make sure borders, surfaces, text, and shadows remain readable in both modes.

## Homepage North Star

The homepage must feel like a gaming lifestyle platform, not a shop shelf.

It should guide the user from emotion to platform, from platform to game mood, from game mood to ready setups, and only then to helpful services and guides. Commerce can appear later, but the first impression should be calm, premium, human, and game-first.
