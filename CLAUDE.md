# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

The Laravel app lives in `anchoi/` — all commands below run from there, not the repo root.

## Commands

```bash
cd anchoi
composer install && npm install        # first-time setup
php artisan serve                      # dev server (http://localhost:8000)
npm run dev                            # Vite (Tailwind) asset watcher
npm run build                          # production assets
php artisan migrate                    # run migrations
php artisan test                       # full PHPUnit suite
php artisan test --filter=TestName     # single test / method
./vendor/bin/pint                      # format (Laravel Pint)
```

Custom data-import commands (see the `*_README.md` files in `anchoi/` for details):
- `php artisan import:locations-json` / `import:locations-google-maps` — seed entertainment spots
- `php artisan import:province-ward` — seed provinces (`tinh`) and wards (`xa_phuong`)
- `php artisan google:oauth`, `php artisan test:api-connection`, `php artisan list:wards`

## Architecture

SEO-focused directory of Vietnamese entertainment/dining spots ("ăn chơi"). Laravel 11 + **Laravel Nova 4** admin panel. Public-facing pages are server-rendered Blade; the admin edits content through Nova.

**Domain tables use Vietnamese names** (set via `$table` on each model): `diem_vui_choi` (EntertainmentSpot), `loai_hinh` (EntertainmentType), `tinh` (Province), `xa_phuong` (Ward), plus `comments`, `blog`, `category`. Geography is Province → Ward → Spot (district was removed — see commit `3268f29`; `district_*` keys in responses now alias the ward).

**Controllers serve dual output.** Most action pairs: a JSON method (e.g. `urlApiSearch`, `findNearestEntertainmentSpots`) and a `*Render` wrapper that calls it, unwraps `->getData()`, and returns a Blade view. When changing response shape, update both the JSON method and every `*Render` consumer.

**Slug-based URL parsing is the core routing trick.** Catch-all routes `/{params}` and `/{params}/{id}` (registered *last* in `routes/web.php`) feed `urlApiSearchRender` / `urlApiSearchDetailRender`. These decode the path and substring-match it against all `slug`s pulled from `EntertainmentType`, then `Province`, then `Ward` (via `findMatchInList`) to reconstruct the filter. A no-match renders `404.blade.php`. Because these are catch-alls, any new literal route must be declared before them.

**`EntertainmentSpot::boot()` does work on every save:** regenerates `slug` (Vietnamese-diacritic-stripping `slugify`, appends `-{id}`), recomputes `average_rating` from non-reply comments, and geocodes `full_address` via **Nominatim/OpenStreetMap** (`getCoordinatesFromAddress`) only when lat/long are empty. Nearest-spot search loads all approved spots and sorts by in-PHP Haversine distance (`calculateHaversineDistance`) — no spatial index.

**`transformEntertainmentSpot()`** is the single response shaper; it also builds the embedded Schema.org JSON-LD (`header`) with reviews/aggregateRating/openingHours. Add new spot fields here, not ad hoc.

Only spots with `status = 'approved'` appear publicly. Images are base64 data-URIs decoded and written to `storage/app/public/images` via Intervention Image (Imagick driver).

## Config

Third-party keys live in `config/services.php` → `.env`: `GOOGLE_MAPS_API_KEY`, `GOOGLE_CLIENT_ID/SECRET/REDIRECT_URI` (OAuth, see `GOOGLE_OAUTH_SETUP.md`), `OPENAI_API_KEY`. The location-import pipeline (Google Places → ChatGPT description → DB) is documented in `workflow-add-location.md`.
