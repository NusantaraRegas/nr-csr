# NR-CSR (Corporate Social Responsibility)

Laravel 6 (PHP ^7.2) monolith for CSR proposal intake, evaluation/survey workflow, budgeting (Anggaran/Proker), payments, and reporting dashboards.

> This repository previously contained the default Laravel README; it has been replaced with project-specific documentation and charts.

## Tech Stack

- **Backend**: Laravel Framework `^6.0`
- **DB**: PostgreSQL (Docker local) / Oracle (legacy via `yajra/laravel-oci8`)
- **UI**: Blade views + `webpack.mix.js` (Laravel Mix)
- **Reporting / Export**: `maatwebsite/excel` + `yajra/laravel-datatables-oracle`
- **Captcha**: `anhskohbo/no-captcha`

## Business / Domain Map

The main business modules are derived from route prefixes and controller responsibilities.

```mermaid
flowchart TB
  %% Users
  Admin([Admin])
  User([Internal User])
  Finance([Finance])
  Report([Report Monitoring])
  Legal([Legal])
  Vendor([Vendor])
  Subsidiary([Subsidiary User])

  %% Modules
  Auth[Authentication and OTP]
  Master[Master Data]
  Proposal[Proposal Intake]
  Evaluasi[Evaluation]
  Survei[Survey]
  LegalDocs[Legal Documents]
  Budget[Budgeting and Programs]
  Payment[Payment Execution]
  Dashboard[Dashboards]
  Reporting[Reporting and Exports]
  VendorReg[Vendor Registration and Docs]
  Subs[Subsidiary Flows]
  Tasklist[Tasklists and Approvals]

  %% Details (kept simple to avoid Mermaid parsing issues on GitHub)
  AuthDetail[LoginController]
  MasterDetail[Role User Anggota Hirarki Sektor Kebijakan SDG Pilar Perusahaan Exception]
  ProposalDetail[Kelayakan SubProposal Lembaga Lampiran]
  BudgetDetail[Anggaran Proker Relokasi Alokasi]
  PaymentDetail[PembayaranController Popay]
  ReportingDetail[LaporanController ReportController APIController]

  %% Relationships (high-level)
  Admin --> Auth
  User --> Auth
  Finance --> Auth
  Report --> Auth
  Legal --> Auth
  Vendor --> Auth
  Subsidiary --> Auth

  Admin --> Master
  Master --> MasterDetail
  User --> Proposal
  Proposal --> ProposalDetail
  User --> Evaluasi
  User --> Survei
  Report --> Reporting
  Reporting --> ReportingDetail
  Finance --> Budget
  Budget --> BudgetDetail
  Finance --> Payment
  Payment --> PaymentDetail
  Legal --> LegalDocs
  Vendor --> VendorReg
  Subsidiary --> Subs
  Report --> Tasklist
  Legal --> Tasklist
  User --> Dashboard
  Finance --> Dashboard
  Subsidiary --> Dashboard

  Admin --> Auth
  User --> Auth
  Finance --> Auth
  Report --> Auth
  Legal --> Auth
  Vendor --> Auth
  Subsidiary --> Auth
  Auth --> AuthDetail
```

## Architecture Overview

This codebase follows a classic Laravel monolith pattern: Routes → Middleware → Controllers → Eloquent Models/DB, with Blade views for HTML responses and some endpoints serving JSON for dashboards.

```mermaid
flowchart LR
  Browser[Browser User Agent]
  VendorPortal[Vendor Portal]
  SubsPortal[Subsidiary Portal]
  Artisan[Artisan CLI]

  subgraph LaravelApp[Laravel Application]
    Routes[routes web and routes api]
    MW[Middleware web cred login timeout role guards]
    Controllers[Controllers app Http Controllers]
    Views[Blade Views resources views]
    Models[Eloquent Models app Models and View models]
    Exports[Excel Exports app Exports]
    Imports[Excel Imports app Imports]
    Helpers[Helpers app Helper via HelperServiceProvider]
  end

  DB[Oracle Database]
  FileStore[Storage public uploads]
  External[External Services recaptcha and possible payment]

  Browser --> Routes
  VendorPortal --> Routes
  SubsPortal --> Routes
  Routes --> MW --> Controllers
  Controllers --> Views
  Controllers --> Models --> DB
  Controllers --> Exports
  Imports --> Models
  Controllers --> FileStore
  Controllers --> External
  Artisan --> LaravelApp
```

### Key Middleware / Authorization

Route groups use role-based middleware defined in `app/Http/Kernel.php`:

- `isAdmin`, `isUser`, `isFinance`, `isReport`, `isLegal`, `isSubsidiary`
- Session control: `cred.login`, `timeOut`

## Initialization / Boot Flow

Laravel boot sequence (simplified) for this repository:

```mermaid
sequenceDiagram
  autonumber
  participant Web as public/index.php
  participant Bootstrap as bootstrap/app.php
  participant Kernel as App\\Http\\Kernel
  participant Providers as Service Providers (config/app.php)
  participant Routes as RouteServiceProvider (routes/web.php)
  participant MW as Middleware
  participant Ctrl as Controllers
  participant DB as Oracle (yajra/oci8)

  Web->>Bootstrap: require bootstrap/app.php
  Bootstrap-->>Web: returns Application container
  Web->>Kernel: resolve Http Kernel + handle(Request)
  Kernel->>Providers: bootstraps framework + loads providers
  Providers->>Providers: HelperServiceProvider.register() (require app/Helper/*.php)
  Providers->>Routes: RouteServiceProvider.mapWebRoutes()
  Routes->>Routes: loads routes/web.php
  Web->>MW: run global + route middleware
  MW->>Ctrl: dispatch controller action
  Ctrl->>DB: query/update via Models
  Ctrl-->>Web: Response (View/JSON/Redirect)
```

## Local Setup (Initialization Steps)

> Exact environment variables are in `.env` (not committed). The steps below describe the typical Laravel 6 + Oracle setup.

1. Install dependencies
   - `composer install`
   - `npm install`
2. Create environment file
   - copy `.env.example` → `.env`
   - set at minimum: `APP_NAME`, `APP_ENV`, `APP_KEY`, `APP_URL`
   - configure **Oracle** connection in `.env` (see `config/database.php` and `config/oracle.php`)
3. Generate app key
   - `php artisan key:generate`
4. Build frontend assets (if needed)
   - `npm run dev` (or `npm run prod`)
5. Run the application
   - `php artisan serve`
6. (Optional) Run tests
   - `vendor/bin/phpunit`

## Main Route Areas (Quick Map)

- `/auth/*` - login, forgot/reset password, OTP
- `/dashboard/*` - dashboards
- `/master/*` - admin master data
- `/proposal/*` - proposal intake & supporting entities
- `/anggaran/*` - budgeting and program (Proker) management
- `/report/*` - reporting, exports, monitoring
- `/DokumenLegal/*` - BAST/SPK documents
- `/subsidiary/*` - subsidiary dashboards, budgeting, realization, reporting

## Notes

- This README uses Mermaid diagrams. GitHub renders Mermaid automatically; for other renderers ensure Mermaid is enabled.

## Docker (PostgreSQL) Local Setup

This repo can be run fully via Docker using PostgreSQL.

### Database schema source

The repository includes an Oracle → PostgreSQL converted schema dump:

- `NR_CSR.sql`

From that dump we generate Laravel migrations (Postgres) under `database/migrations/2026_01_12_*`.

> Note: Some views in the original Oracle schema reference objects under `NR_PAYMENT.*`. In this repo we keep those as **stubs/TODO** so migrations can run in a standalone `NR_CSR` database.

### 1) Bring up containers

```bash
docker compose up -d --build
```

### 2) Create `.env`

```bash
copy .env.docker.example .env
```

Then generate app key:

```bash
docker compose exec -T app php artisan key:generate --force
```

### 3) Install PHP dependencies

This project includes packages that require extensions used by Oracle (oci8) and Excel exports (gd). If you are running Postgres-only locally, you can install dependencies while ignoring those platform requirements:

```bash
docker compose exec -T app composer install --no-interaction --ignore-platform-req=ext-gd --ignore-platform-req=ext-oci8
```

### 4) Run migrations

```bash
docker compose exec -T app php artisan migrate --force
```

If you want to rebuild schema from scratch:

```bash
docker compose exec -T app php artisan migrate:fresh --force
```

### Schema verification (optional)

List tables created in the NR_CSR schema:

```bash
docker compose exec -T db psql -U nr_csr -d nr_csr -c "SELECT schemaname, tablename FROM pg_tables WHERE schemaname IN ('NR_CSR') ORDER BY tablename;"
```

### 5) Open the app

Nginx is exposed on:

```
http://localhost:8080
```
