# Running Parc Commune with Docker

The stack runs 4 containers:

| Service      | Container         | What it does                      | URL / Port                     |
|--------------|-------------------|-----------------------------------|--------------------------------|
| `app`        | `parc_app`        | PHP 8.2-FPM + Composer (Laravel)  | internal (port 9000)           |
| `nginx`      | `parc_nginx`      | Web server                        | http://localhost:8000          |
| `mysql`      | `parc_mysql`      | MySQL 8.0 database                | `localhost:3307` from your PC  |
| `phpmyadmin` | `parc_phpmyadmin` | Database admin UI                 | http://localhost:8080          |

There is also a `node` helper (not started by default) used only to build the CSS/JS assets.

---

## 1. Prerequisites

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) installed and running.
- Ports `8000`, `8080` and `3307` free (you can change them in `.env`, see below).

## 2. Create the `.env` file

```bash
cp .env.example .env
```

Then edit `.env` and set the database section like this:

```dotenv
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=mysql          # the name of the MySQL service, NOT 127.0.0.1
DB_PORT=3306           # port inside the Docker network
DB_DATABASE=parc_commune
DB_USERNAME=parc       # do NOT use "root" here, the MySQL image refuses it
DB_PASSWORD=secret
DB_ROOT_PASSWORD=root
```

Optional overrides (defaults shown):

```dotenv
APP_PORT=8000          # nginx port on your PC
PMA_PORT=8080          # phpMyAdmin port on your PC
DB_FORWARD_PORT=3307   # MySQL port on your PC
```

> On Linux, also add `UID=` and `GID=` with the output of `id -u` / `id -g` so files created by the container belong to you.

## 3. Start the containers

```bash
docker compose up -d --build
```

The first build takes a few minutes. Check that everything is up:

```bash
docker compose ps
```

`parc_mysql` should show `healthy` before you continue.

## 4. Install and initialise the app (first time only)

Run these commands **in this order**:

```bash
# 1. PHP dependencies
docker compose exec app composer install

# 2. Application key
docker compose exec app php artisan key:generate

# 3. Create the tables + run the required seeders
docker compose exec app php artisan migrate --seed

# 4. Make uploaded files (logo, vehicle images, attachments) public
docker compose exec app php artisan storage:link

# 5. Build the front-end assets (Tailwind / Vite)
docker compose run --rm node sh -c "npm install && npm run build"
```

Open http://localhost:8000 and log in.

## 5. Seeders

### Required — run automatically by `php artisan migrate --seed`

These are listed in `database/seeders/DatabaseSeeder.php` and run in this order. All seeders are safe to run again: existing rows are kept and nothing is duplicated.

| # | Seeder                 | What it creates                                                     | Why it's needed                              |
|---|------------------------|---------------------------------------------------------------------|----------------------------------------------|
| 1 | `RoleSeeder`           | Roles: Administrateur, Gestionnaire, Service Technique, Utilisateur | Users need a role                            |
| 2 | `UserSeeder`           | Admin account (`admin` / `password`)                                | So you can log in                            |
| 3 | `SettingSeeder`        | Default settings row (logo, colors; commune name empty → uses .env) | The login page and layouts crash without it  |
| 4 | `CategoriePermiSeeder` | Driving licence categories A, B, C, D, E                            | Needed for vehicles and drivers              |
| 5 | `UnitieSeeder`         | Stock units: Litre, Kilogramme, Pièce, Mètre, Boîte                 | Needed to create stock items                 |

### Optional — demo data

Set `SEED_DEMO=true` to also create demo vehicles, drivers, maintenance, stock, missions and payment vouchers:

```bash
docker compose exec -e SEED_DEMO=true app php artisan db:seed
```

This runs, in order: `VehiculeSeeder` (18 vehicles), `DriverSeeder` (5 drivers), `DriverHasPermiSeeder`, `VidangeSeeder`, `PneuSeeder`, `TimingChaineSeeder`, `StockSeeder`, `StockHistoriqueSeeder`, `MissionOrderSeeder`, `PaymentVoucherSeeder`. Missions, stock history and vouchers are only created when their table is empty.

### PDF header

Every line of the official header on PDFs (Royaume, Ministère, Wilaya, Région, Province, Pachalik, Commune, city, logo) is set in `.env` with the `PDF_*` keys (see `.env.example`). Each value is the full printed line; leave one empty to hide it. The commune line uses the name saved on the **Paramètres** page first, then `PDF_COMMUNE_FR` / `PDF_COMMUNE_AR`.

After changing `.env`, clear the config cache:

```bash
docker compose exec app php artisan config:clear
```

Reports and permanent mission orders can be downloaded in French or Arabic (buttons "PDF (FR)" / "PDF (AR)" and "Imprimer (AR)").

### Reset the database

Drops every table, re-runs all migrations and the required seeders:

```bash
docker compose exec app php artisan migrate:fresh --seed
```

## 6. Access

| What        | URL                    | Login                                                     |
|-------------|------------------------|-----------------------------------------------------------|
| Application | http://localhost:8000  | username `admin` (or `admin@jamaycom.ma`) / `password`    |
| phpMyAdmin  | http://localhost:8080  | `parc` / `secret` (or `root` / `root`)                    |
| MySQL (GUI client like TablePlus / DBeaver) | `127.0.0.1:3307` | `parc` / `secret`             |

**Change the admin password after the first login.**

Then go to the settings page to set the commune name (FR / AR), logo and colors.

## 7. Everyday commands

```bash
docker compose up -d                      # start
docker compose stop                       # stop (keeps data)
docker compose down                       # stop and remove containers (keeps data)
docker compose down -v                    # ⚠ also deletes the database volume

docker compose logs -f app nginx          # follow logs
docker compose exec app bash              # shell inside the PHP container
docker compose exec app php artisan ...   # any artisan command
docker compose exec app php artisan optimize:clear   # clear all caches

# Rebuild assets after changing CSS/JS/Blade classes
docker compose run --rm node npm run build
```

## 8. Troubleshooting

| Problem | Fix |
|---------|-----|
| `SQLSTATE[HY000] [2002] Connection refused` | `DB_HOST` must be `mysql`, and wait until `parc_mysql` is `healthy` (`docker compose ps`). After changing `.env` run `docker compose exec app php artisan config:clear`. |
| MySQL container keeps restarting | `DB_USERNAME` is set to `root`. Use another name (e.g. `parc`), then `docker compose down -v && docker compose up -d`. |
| Changed DB name/user/password but it still uses the old ones | MySQL only reads them on first start. Run `docker compose down -v` (deletes data) and start again. |
| `Vite manifest not found` | Build the assets: `docker compose run --rm node sh -c "npm install && npm run build"`. |
| `Permission denied` on `storage/` or `bootstrap/cache` | `docker compose exec -u root app chown -R www-data:www-data storage bootstrap/cache` |
| Uploaded images / logo don't show | Run `docker compose exec app php artisan storage:link` and check `APP_URL=http://localhost:8000`. |
| `Port is already allocated` | Change `APP_PORT`, `PMA_PORT` or `DB_FORWARD_PORT` in `.env`, then `docker compose up -d`. |
| `Unable to locate a class or view for component [admin.app]` | Files must be named `App.php` (capital A) in `app/View/Components/Admin/` and `app/View/Components/serviceTechnique/`. Then `docker compose exec app composer dump-autoload`. |
