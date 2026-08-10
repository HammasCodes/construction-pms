# Deploying to Railway

This app ships with a `Dockerfile` so Railway builds it deterministically
(Node compiles the Tailwind/Vite assets, PHP 8.3 runs Laravel and serves the
app). On boot it runs migrations and seeds demo data, then serves on `$PORT`.

## One-time setup

1. Go to **https://railway.app** → sign in with GitHub.
2. **New Project → Deploy from GitHub repo** → pick `HammasCodes/construction-pms`.
   Railway detects the `Dockerfile` automatically.
3. Open the service → **Variables** → add the environment variables below.
4. **Settings → Networking → Generate Domain** to get a public `https://…up.railway.app` URL.
5. Set `APP_URL` to that domain (add/update the variable), then redeploy.

Share the generated URL with your CEO. Login: `test@example.com` / `password`.

## Environment variables

| Key | Value |
| --- | --- |
| `APP_NAME` | `ConstructPMS` |
| `APP_ENV` | `production` |
| `APP_KEY` | `base64:jRNusc1whu/FSS2y09VtJlCd3GaLq15adX82KXQdSBs=` |
| `APP_DEBUG` | `false` |
| `APP_URL` | your Railway domain (set after step 4) |
| `LOG_CHANNEL` | `stderr` |
| `SESSION_DRIVER` | `file` |
| `CACHE_STORE` | `file` |
| `QUEUE_CONNECTION` | `sync` |
| `DB_CONNECTION` | `sqlite` |

> Generate a new `APP_KEY` any time with `php artisan key:generate --show`.

## Data persistence (optional)

The SQLite database is recreated and reseeded on each deploy, so the demo
always opens with 3 sample projects. To keep data the CEO enters between
redeploys, add a **Railway Volume** mounted at `/var/www/html/database`.
