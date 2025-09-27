# Tour Management System

## Stack: Laravel 12 · Livewire (Volt) · Tailwind · Alpine.js Navigate · Pest Tests

Modern dashboard + booking analytics platform for managing destinations, packages, schedules, accommodations and traveler bookings.

---

## ✨ Features

- Authentication (email + password) with role-based redirect (admin → dashboard, user → welcome)
- Daily Booking Analytics (last 7 days) with interactive 3D gradient bar chart (today / weekend / peak day highlighting + average line)
- KPI Metrics: Total Bookings, Pending Bookings, Unique Travelers, Estimated Revenue
- Upcoming Schedules panel with relative countdown badges
- Top Destinations usage distribution with animated progress gradients
- Latest Bookings table with status badges & contextual icons
- Accommodation / Room Choice & Hotel relations loaded for detail expansion (future)
- Alpine.js SPA-like navigation via `wire:navigate` + Navigate plugin fallback
- Tailwind utility-first responsive UI (enhanced dashboard glass + gradient style)
- Rate limiting & login throttling (5 attempts) using Laravel RateLimiter
- Centralized Eloquent relationships for analytics
- Pest testing scaffold ready

---

## 🧱 Tech Stack

| Layer            | Technology |
|------------------|------------|
| Framework        | Laravel 12 |
| Realtime UI      | Livewire + Volt anonymous components |
| Styling          | Tailwind (browser CDN build) |
| Interactivity    | Alpine.js + @alpinejs/navigate plugin |
| Database         | SQLite (default) / configurable via `.env` |
| Testing          | Pest + PHPUnit |
| Charts (custom)  | Hand-crafted Tailwind + Blade (no external chart lib) |

---

## 📂 Domain Models (core)

| Model            | Purpose |
|------------------|---------|
| `User`           | Travelers & admins (role column) |
| `Destination`    | Travel locations |
| `TouristPackage` | Package grouping destination + pricing |
| `Schedule`       | Dated travel window for a package |
| `Booking`        | User reservation referencing schedule |
| `Accommodation`  | Lodging offerings linked to hotels |
| `Hotel`          | Parent entity for rooms/accommodations |
| `Room`           | Physical room inventory |
| `RoomChoice`     | Chosen room(s) per booking |
| `Guide`          | (Future) tour guide assignments |

---

## 🖥 Dashboard Highlights

The dashboard (`/dashboard`) uses a single-action controller (`DashboardController::__invoke`) to gather:

- Daily bookings (Carbon date loop ensures missing days = zero)
- Peak detection (max count in window)
- Weekend & today flagging
- Average calculation displayed as a glowing dashed line
- Aggregated KPI counts + derived revenue approximation

Bar styling logic (simplified pseudo):
```
if today → emerald gradient
else if peak → amber gradient
else if weekend → purple gradient
else if value > 0 → blue gradient
else → gray muted
```

---

## 🚀 Getting Started

### 1. Clone & Install
```bash
git clone <repo-url>
cd tour-management-system
composer install
```

### 2. Environment
```bash
cp .env.example .env
php artisan key:generate
```

Configure (optional) database in `.env`:
```
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```
Create the SQLite file if missing:
```bash
touch database/database.sqlite
```

### 3. Run Migrations & Seeders
```bash
php artisan migrate --seed
```
`TourManagementSeeder` will populate sample destinations, packages, schedules, and bookings (if implemented). Adjust as needed.

### 4. Start Dev Server
```bash
php artisan serve
```
Visit: http://127.0.0.1:8000

### 5. Login
Use a seeded user (check `database/seeders/` or create one):
```bash
php artisan tinker
>>> \App\Models\User::factory()->create(['email' => 'admin@example.com','role' => 'admin']);
```
Set a password via factory defaults (usually `password`).

---

## 🔐 Authentication Flow

- Login component: `resources/views/livewire/auth/login.blade.php` (Volt anonymous class)
- Rate limit: 5 failed attempts triggers lockout (throws validation error with backoff seconds)
- Post-auth redirect logic:
  - Admin → `dashboard`
  - Traveler → `welcome`

---

## 🧠 Architecture Notes

- **Single-Action Controller Pattern:** `DashboardController` uses `__invoke()` to keep route definitions concise.
- **Base Controller:** Currently minimal. Can be extended with shared middleware & traits (authorization / validation helpers).
- **Volt Components:** Inline class + template simplifies small, self-contained screens (login/register) without separate PHP class files.
- **Analytics Loop:** Uses backward iteration (6 → 0 days) ensuring chronological left→right chart alignment.
- **Front-End Performance:** No heavy JS chart libs; purely utility CSS + Blade loops.

---

## 🛠 Common Tasks

| Task | Command |
|------|---------|
| Clear caches | `php artisan optimize:clear` |
| Fresh migrate + seed | `php artisan migrate:fresh --seed` |
| Tinker | `php artisan tinker` |
| List routes | `php artisan route:list` |

---

## 🧪 Testing (Pest)

Scaffold is present (see `tests/`). Add a sample test:
```bash
php artisan make:test BookingTest
```
Run all tests:
```bash
./vendor/bin/pest
```

---

## 🧩 Adding a New Feature (Example Workflow)

1. Create migration + model (e.g. `php artisan make:model Guide -m`)
2. Define relationships
3. Add factory & seeder data
4. Expose metrics in `DashboardController`
5. Render new widget in `resources/views/dashboard.blade.php`

---

## 🛡 Security & Validation

- Login form uses Livewire validation attributes (`#[Validate(...)]`)
- You can enable policies: add traits in base controller and run `php artisan make:policy`
- Add CSRF: Already provided by Blade + `@csrf` in forms

---

## 🌐 SPA-Like Navigation

The project uses: 
```html
<a href="..." wire:navigate>
```
Backed by `@alpinejs/navigate`. A fallback assigns `Alpine.navigate = (url) => window.location.href = url;` if plugin fails to load.

---

## 🧵 Styling Conventions

- Use Tailwind utility classes (no compiled pipeline needed with CDN mode currently)
- Prefer semantic grouping + gradient accents for analytics widgets
- Keep chart logic server-driven, presentation purely Blade

If you later move to a build pipeline (Vite/`@vite`):
1. Install Tailwind via npm
2. Add config + compile assets

---

## 🚧 Roadmap Ideas

- [ ] Role/permission system (Laravel Permission package)
- [ ] Export bookings (CSV / Excel)
- [ ] Replace custom chart with dynamic Livewire component w/ tooltips powered by Alpine state
- [ ] Real-time updates (Echo + broadcasting)
- [ ] Advanced revenue analytics w/ grouping by destination
- [ ] Notification center for schedule changes

---

## 🐛 Troubleshooting

| Issue | Possible Fix |
|-------|--------------|
| Login POST 405 Method Not Allowed | Ensure form has `wire:submit.prevent`, Livewire scripts loaded, Alpine navigate plugin present |
| Chart empty | Check `Booking` timestamps within last 7 days; timezone mismatch? |
| Seed data missing | Run `php artisan migrate:fresh --seed` |
| Styling not applied | Tailwind CDN blocked? Inspect network panel; consider installing locally |

---

## 📜 License

Add license of your choice (e.g. MIT) or keep private.

---

## 🙌 Contributions / Customization

PRs & feature suggestions welcome. Fork and adapt for tour agencies, travel startups, or internal operations dashboards.

---

### Quick Glance

```text
app/Http/Controllers/DashboardController.php  → Aggregates analytics
resources/views/dashboard.blade.php           → Dashboard UI (cards, chart, panels, table)
resources/views/livewire/auth/login.blade.php → Volt login component
database/migrations/*                         → Schema
database/seeders/*                            → Seed data
```

Enjoy building on top of this foundation! ✈️

