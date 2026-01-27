# NR-CSR (Corporate Social Responsibility)

Laravel 6 (PHP ^7.2) monolith for CSR proposal intake, evaluation/survey workflow, budgeting (Anggaran/Proker), payments, and reporting dashboards.

> This repository previously contained the default Laravel README; it has been replaced with project-specific documentation and charts.

## Table of Contents

- [Tech Stack](#tech-stack)
- [Business / Domain Map](#business--domain-map)
- [Architecture Overview](#architecture-overview)
- [Key Middleware / Authorization](#key-middleware--authorization)
- [Initialization / Boot Flow](#initialization--boot-flow)
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Local Setup (Standard)](#local-setup-standard)
  - [Docker Setup (PostgreSQL)](#docker-setup-postgresql)
- [Main Route Areas](#main-route-areas-quick-map)
- [Project Maintenance](#project-maintenance)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [Notes](#notes)

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

## Getting Started

### Prerequisites

- **PHP**: ^7.2 (PHP 7.4 recommended)
- **Composer**: Latest version
- **Node.js**: v12+ and npm
- **Database**: PostgreSQL 12+ (Docker) or Oracle 12c+ (legacy)
- **Web Server**: Apache/Nginx or use `php artisan serve`

### Local Setup (Standard)

> Exact environment variables are in `.env` (not committed). The steps below describe the typical Laravel 6 + Oracle setup.

1. **Clone the repository**
   ```bash
   git clone https://github.com/NusantaraRegas/nr-csr.git
   cd nr-csr
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Create environment file**
   ```bash
   # Windows
   copy .env.example .env
   
   # Linux/macOS
   cp .env.example .env
   ```
   
   Configure at minimum:
   - `APP_NAME`, `APP_ENV`, `APP_KEY`, `APP_URL`
   - **Oracle** connection settings (see `config/database.php` and `config/oracle.php`)

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Build frontend assets**
   ```bash
   # Development
   npm run dev
   
   # Production
   npm run prod
   ```

6. **Run database migrations**
   ```bash
   php artisan migrate
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```
   
   Access the application at `http://localhost:8000`

8. **(Optional) Run tests**
   ```bash
   vendor/bin/phpunit
   ```

### Docker Setup (PostgreSQL)

This repo can be run fully via Docker using PostgreSQL.

#### Database Schema Source

The repository includes an Oracle → PostgreSQL converted schema dump:

- `tools/NR_CSR.sql`

From that dump we generate Laravel migrations (Postgres) under `database/migrations/2026_01_12_*`.

> **Note**: Some views in the original Oracle schema reference objects under `NR_PAYMENT.*`. In this repo we keep those as **stubs/TODO** so migrations can run in a standalone `NR_CSR` database.

#### Step-by-Step Docker Setup

1. **Bring up containers**
   ```bash
   docker compose up -d --build
   ```

2. **Create `.env` file**
   ```bash
   # Windows
   copy .env.docker.example .env
   
   # Linux/macOS
   cp .env.docker.example .env
   ```
   
   Generate app key:
   ```bash
   docker compose exec -T app php artisan key:generate --force
   ```

3. **Install PHP dependencies**
   
   This project includes packages that require extensions used by Oracle (oci8) and Excel exports (gd). If running Postgres-only locally, install dependencies while ignoring platform requirements:
   
   ```bash
   docker compose exec -T app composer install --no-interaction --ignore-platform-req=ext-gd --ignore-platform-req=ext-oci8
   ```

4. **Run migrations**
   ```bash
   docker compose exec -T app php artisan migrate --force
   ```
   
   To rebuild schema from scratch:
   ```bash
   docker compose exec -T app php artisan migrate:fresh --force
   ```

5. **(Optional) Verify schema**
   
   List tables created in the NR_CSR schema:
   ```bash
   docker compose exec -T db psql -U nr_csr -d nr_csr -c "SELECT schemaname, tablename FROM pg_tables WHERE schemaname IN ('NR_CSR') ORDER BY tablename;"
   ```

6. **Access the application**
   
   Nginx is exposed on:
   ```
   http://localhost:8080
   ```

#### Docker Commands Reference

```bash
# Start containers
docker compose up -d

# Stop containers
docker compose down

# View logs
docker compose logs -f app

# Access application container shell
docker compose exec app bash

# Access database
docker compose exec db psql -U nr_csr -d nr_csr

# Rebuild containers
docker compose up -d --build --force-recreate
```

## Main Route Areas (Quick Map)

| Route Prefix | Description |
|--------------|-------------|
| `/auth/*` | Login, forgot/reset password, OTP |
| `/dashboard/*` | Dashboards for different user roles |
| `/master/*` | Admin master data management |
| `/proposal/*` | Proposal intake & supporting entities |
| `/anggaran/*` | Budgeting and program (Proker) management |
| `/report/*` | Reporting, exports, monitoring |
| `/DokumenLegal/*` | BAST/SPK legal documents |
| `/subsidiary/*` | Subsidiary dashboards, budgeting, realization, reporting |

## Project Maintenance

### Git Ignore Configuration

The project includes comprehensive `.gitignore` files to prevent committing unnecessary files:

**Root `.gitignore`:**
- Laravel/PHP: vendor dependencies, IDE helpers, test coverage, Homestead configs
- Node/Frontend: node_modules, build artifacts, npm/yarn cache and logs
- IDEs: .idea/, .vscode/, editor swap and backup files
- Operating Systems: macOS (.DS_Store), Windows (Thumbs.db), Linux (.directory)
- Docker: local volumes, docker-compose overrides
- Process files: PIDs, lock files

**`public/template/assets/.gitignore`:**
- Node dependencies (node_modules/, bower_components/)
- Build output (dist/, build/, minified files)
- Cache and log files
- OS and editor-specific files

These configurations ensure clean repositories by excluding auto-generated files, local configurations, and build artifacts.

### Maintenance Commands

```bash
# Clear application cache
php artisan cache:clear

# Clear configuration cache
php artisan config:clear

# Clear route cache
php artisan route:clear

# Clear view cache
php artisan view:clear

# Optimize application for production
php artisan optimize

# Regenerate autoload files
composer dump-autoload
```

## Troubleshooting

### Common Issues

#### 1. Migration Errors

**Problem**: Migration fails with foreign key constraints

**Solution**: 
```bash
# Drop all tables and re-run migrations
php artisan migrate:fresh

# Or for Docker
docker compose exec -T app php artisan migrate:fresh --force
```

#### 2. Permission Errors (Linux/macOS)

**Problem**: `storage` or `bootstrap/cache` permission denied

**Solution**:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### 3. Oracle Connection Issues

**Problem**: `ORA-12154: TNS:could not resolve the connect identifier`

**Solution**:
- Verify Oracle connection settings in `.env`
- Ensure Oracle client is properly installed
- Check `TNS_ADMIN` environment variable

#### 4. Composer Install Fails

**Problem**: Extensions missing (oci8, gd, etc.)

**Solution**:
```bash
# For local development with PostgreSQL, ignore platform requirements
composer install --ignore-platform-req=ext-gd --ignore-platform-req=ext-oci8
```

#### 5. Frontend Assets Not Loading

**Problem**: CSS/JS not loading after pulling changes

**Solution**:
```bash
# Reinstall node modules
rm -rf node_modules package-lock.json
npm install

# Rebuild assets
npm run dev
```

#### 6. Docker Container Issues

**Problem**: Containers won't start or database connection fails

**Solution**:
```bash
# Rebuild containers from scratch
docker compose down -v
docker compose up -d --build --force-recreate

# Check container logs
docker compose logs -f
```

## Contributing

1. **Fork the repository**
2. **Create a feature branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```
3. **Make your changes**
4. **Commit with descriptive messages**
   ```bash
   git commit -m "Add: description of your changes"
   ```
5. **Push to your fork**
   ```bash
   git push origin feature/your-feature-name
   ```
6. **Create a Pull Request**

### Commit Message Conventions

- `Add:` for new features
- `Fix:` for bug fixes
- `Update:` for updates to existing features
- `Refactor:` for code refactoring
- `Docs:` for documentation changes
- `Test:` for adding or updating tests

## Notes

- This README uses Mermaid diagrams. GitHub renders Mermaid automatically; for other renderers ensure Mermaid is enabled.
- For production deployments, ensure all environment variables are properly configured.
- Regular backups of the database are recommended.
- Keep dependencies up to date for security patches.

---

**License**: Check with Nusantara Regas for licensing information.

**Support**: For issues or questions, please contact the development team or create an issue in the repository.
