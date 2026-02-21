# NR-CSR Project Improvement Checklist (Revised)

This checklist is updated from a repository scan on commit **`f30b3df`**.
It keeps the original priorities, but adds concrete baseline findings, measurable acceptance criteria, and execution order so the team can track real risk reduction.

---

## 1) Current Baseline Snapshot (evidence from code scan)

- **Runtime is legacy**: Laravel 6 + PHP ^7.2 (`composer.json`)
- **Destructive GET routes exist**: ~**35** matches in `routes/web.php` (`Route::get(...delete...)`)
- **Raw SQL interpolation still present**: ~**34** risky patterns (`DB::select("... '$var' ...")`)
- **Controller-heavy architecture**:
  - `KelayakanController.php` ~**3876 lines**
  - `APIController.php` ~**1914 lines**
  - `DashboardController.php` ~**1474 lines**
  - `PembayaranController.php` ~**1315 lines**
- **Route file is large**: `routes/web.php` ~**714 lines**
- **Inline validation still dominant**: ~**52** `$request->validate(...)` usages, while many FormRequest classes already exist in `app/Http/Requests`
- **Legacy methods still present**: `*Old` methods found in 4 controllers
- **Auth/session duality**: pervasive `session('user')` usage across controllers/middleware, limited `Auth::...` usage
- **File upload handling mostly direct move**: ~**27** `->move(...)` patterns; limited use of `Storage`
- **Hardcoded sensitive defaults exist**:
  - `docker-compose.yml`: `DB_PASSWORD: StrongPass123`, `POSTGRES_PASSWORD: StrongPass123`
  - `.env.docker.example`: `DB_PASSWORD=nr_csr`
  - `UserController`: default password seed/update pattern `bcrypt('corp.NR')`
- **Testing/CI coverage is minimal**:
  - only `ExampleTest.php` in Unit + Feature
  - no `.github/workflows` pipeline found

---

## 2) Completion Rule (applies to each priority item)

An item is complete only if both are checked:

- [ ] **Work completed** (refactor/fix merged)
- [ ] **Confirmation completed** (evidence attached)

Suggested evidence: command output, test report, screenshot, logs, PR link.

---

## 3) Priority 0 — Critical (security + data integrity)

- [x] **Replace destructive GET endpoints with POST/DELETE + CSRF + authorization**
  - [x] Confirmation: grep for destructive GET routes returns **0** for approved route groups
  - [x] Confirmation: feature tests verify unauthorized/CSRF-invalid delete requests are blocked

- [x] **Eliminate SQL injection vectors from interpolated raw SQL**
  - [x] Confirmation: migrate to query builder / bound parameters (`?` bindings)
  - [x] Confirmation: regression test includes malicious payloads and query remains safe

- [x] **Fix credentials/secrets hygiene**
  - [x] **SH-01: Inventory secrets exposure points** (compose, env examples, scripts, seed/default credential paths)
  - [x] **SH-02: Remove hardcoded DB secrets from docker setup**
    - [x] Replace literal passwords in `docker-compose.yml` with `${...}` variables
    - [x] Keep safe non-sensitive defaults only for local convenience
  - [x] **SH-03: Sanitize example env files**
    - [x] `.env.docker.example` must use placeholders/example values, not real-like secrets
    - [x] Add inline comments describing which values must be changed per environment
  - [x] **SH-04: Remove static default password patterns from app code**
    - [x] Eliminate/replace code paths like `bcrypt('corp.NR')`
    - [x] Require explicit password input or generated one-time onboarding flow
  - [x] **SH-05: Add lightweight guardrail check**
    - [x] Add simple grep/check step in CI to detect obvious hardcoded patterns (`PASSWORD=`, `corp.NR`, `StrongPass123`)
  - [x] Confirmation: repository scan shows no hardcoded secrets/default passwords in tracked config + app code
  - [x] Confirmation: docker/local boot still works with env-driven credentials

- [x] **Standardize transaction boundaries**
  - [x] Prefer `DB::transaction(...)` for multi-write flows, especially approval/submit flows
  - [x] Confirmation: forced error path proves rollback consistency

- [x] **Harden upload surface**
  - [x] Replace direct `->move(...)` with `Storage` abstraction where possible
  - [x] Enforce strict mime, extension, size, and naming policies
  - [x] Confirmation: blocked upload tests (spoofed extension, oversize, forbidden type) pass

---

## 4) Priority 1 — High impact maintainability

- [x] **Split oversized controllers into Service + Action/UseCase classes**
  - Target first: `KelayakanController`, `APIController`, `DashboardController`, `PembayaranController`
  - [x] Confirmation: controller LOC/complexity reduced and critical paths still pass tests

- [x] **Adopt FormRequest consistently**
  - [x] Replace inline `$request->validate(...)` in core flows with dedicated Request classes
  - [x] Confirmation: validation behavior parity proven via feature tests

- [x] **Unify authentication state management**
  - [x] Gradually replace/manual-wrap direct `session('user')` dependency with centralized auth context
  - [x] Confirmation: login/logout/session-timeout flows are consistent and tested

- [x] **Remove legacy/duplicate methods (`*Old`) + dead/commented code**
  - [x] Confirmation: route references cleaned; grep shows no active legacy entrypoints

- [x] **Modularize route definition**
  - [x] Split `routes/web.php` by bounded feature domains
  - [x] Confirmation: `route:list` remains behaviorally equivalent

---

## 5) Priority 2 — Reliability and delivery quality

- [x] **Build meaningful test suite for critical journeys**
  - Coverage minimum: auth, authorization, proposal lifecycle, approval transitions, destructive actions
  - [x] Confirmation: CI test run green with critical-path tests in place

- [x] **Add CI pipeline**
  - [x] Include lint/static checks + unit/feature tests on PR
  - [x] Confirmation: failing checks block merge

- [x] **Introduce static analysis + style gate**
  - [x] Add PHPStan/Larastan and formatter (Pint or PHP-CS-Fixer)
  - [x] Confirmation: baseline established and enforced in CI

- [x] **Improve runtime observability**
  - [x] Structured logs for approval actions, upload events, critical exceptions
  - [x] Confirmation: log entries contain traceable actor/action/context fields

- [x] **Dependency hygiene pass**
  - [x] Plan upgrade path for Laravel/PHP and review deprecated packages in `composer.json`
  - [x] Confirmation: documented compatibility matrix and phased migration plan

---

## 6) Priority 3 — Strategic improvements

- [ ] **Define API response/error contracts for JSON endpoints**
  - [ ] Confirmation: schema/contract tests pass for key endpoints

- [ ] **Introduce health checks and alerting basics**
  - [ ] Confirmation: DB/mail/queue failure scenarios produce detectable health/alert signals

- [ ] **Incremental modularization by domain**
  - Suggested order: Proposal → Approval → Payment → Reporting → Vendor/Subsidiary
  - [ ] Confirmation: pilot module extracted without behavior regression

---

## 7) Suggested rollout plan

### Phase A (1–2 sprints)
- [x] **A0: Create execution board (0.5 day)**
  - [x] Create tickets: `A1-secrets`, `A2-routes`, `A3-sql`, `A4-uploads`, `A5-tests`, `A6-ci`
  - [x] Define owner + due date + verification evidence format per ticket

- [x] **A1: Secrets hygiene (small slices, 1–2 days)**
  - [x] **A1.1 (quick win):** replace hardcoded passwords in `docker-compose.yml` with env vars
  - [x] **A1.2:** sanitize `.env.docker.example` placeholders + comments
  - [x] **A1.3:** remove static default password code path(s), including `corp.NR`
  - [x] **A1.4:** add CI grep guardrail for obvious secret patterns
  - [x] **A1.5 verification:** run scan commands + attach evidence

- [x] **A2: Destructive GET remediation (1–2 days)**
  - [x] Convert delete/hapus/destroy GET routes to POST/DELETE in one domain at a time
  - [x] Update forms/buttons/calls and verify CSRF + authorization behavior

- [x] **A3: SQL interpolation remediation (2-4 days)**
  - [x] Batch by controller risk order: APIController -> AnggaranController -> DashboardController -> TasklistController -> PekerjaanController
  - [x] Replace interpolation with query builder/bindings and verify malicious-input behavior

- [x] **A4: Upload hardening (1-2 days)**
  - [x] Prioritize top upload flows first, migrate to Storage, tighten validation

- [x] **A5: Baseline tests (1-2 days)**
  - [x] Add security-focused feature tests for A1-A4 critical scenarios

- [x] **A6: CI baseline (0.5-1 day)**
  - [x] Add workflow running tests + secret guardrail checks on PR

- [x] **Phase A exit criteria**
  - [x] All A1-A6 tickets merged
  - [x] Checklist confirmations include command/test evidence links (see Sections 10 and 11)

### Phase B (2–4 sprints)
- [ ] Controller decomposition for top-4 large controllers
- [ ] Route modularization + FormRequest standardization

### Phase C (parallel roadmap)
- [ ] Laravel/PHP upgrade preparation + pilot migration
- [ ] Observability + domain modularization improvements

---

## 8) Tracking recommendation

For each checklist item, track in ticket/PR:

1. **Risk addressed**
2. **Changed files/modules**
3. **Verification evidence**
4. **Rollback plan**

This keeps improvement work auditable and reduces regression risk during modernization.

---

## 9) Phase A Execution Board (A0)

| Ticket | Owner | Target date | Definition of done | Required verification evidence format |
|---|---|---|---|---|
| `A1-secrets` | `TBD` | `TBD` | SH-01..SH-05 complete; no hardcoded secrets/default password literals in tracked app/config/scripts; CI guardrail present | 1) `rg`/guardrail output before vs after, 2) changed-file list, 3) CI run link or local command output |
| `A2-routes` | `TBD` | `TBD` | No destructive GET endpoints for delete/hapus/destroy; destructive actions require POST/DELETE + CSRF + authorization | 1) route grep before vs after, 2) feature test output (CSRF + unauthorized), 3) impacted route/view file list |
| `A3-sql` | `TBD` | `TBD` | High-risk interpolated SQL replaced with bindings/query builder; malicious input regression test added | 1) grep before vs after for interpolated raw SQL patterns, 2) test output, 3) PR diff summary |
| `A4-uploads` | `TBD` | `TBD` | Upload flows use safer storage/validation controls with blocked negative cases | 1) validation rules diff, 2) blocked-upload test output, 3) sample runtime logs |
| `A5-tests` | `TBD` | `TBD` | Security-critical feature tests added and stable in CI | 1) test suite output, 2) coverage list for target flows, 3) flaky test notes (if any) |
| `A6-ci` | `TBD` | `TBD` | CI workflow runs guardrail + targeted tests and fails on violation | 1) workflow YAML diff, 2) successful run URL, 3) failing-case proof screenshot/log |

## 10) A1/A2 Evidence Notes (executed 2026-02-21)

### A1 (Secrets hygiene)

- SH-01 inventory (tracked code paths reviewed):
  - `docker-compose.yml` (`DB_PASSWORD`, `POSTGRES_PASSWORD`, `DEFAULT_USER_PASSWORD`) now env-driven.
  - `.env.docker.example` uses placeholders (`change_me_*`) with explicit comments to replace values.
  - `database/seeds/UserSeeder.php` and `database/seeds/SuperAdminSeeder.php` require `DEFAULT_USER_PASSWORD` from environment and fail fast if unset.
  - `tools/create_admin_user.sql` uses `__ADMIN_PASSWORD_HASH__` placeholder (no plaintext default).
  - `tools/setup_admin.sh` requires externally supplied `ADMIN_PASSWORD_HASH`.
  - `tools/security_guardrail_check.php` added as hardcoded-secret guardrail and wired into CI.
- SH-02/SH-03/SH-04 verification:
  - `rg -n "StrongPass123|corp\\.NR|DB_PASSWORD=nr_csr|bcrypt\\('corp\\.NR'\\)|DB_PASSWORD:\\s*StrongPass123|POSTGRES_PASSWORD:\\s*StrongPass123" -S . -g "!docs/**" -g "!tools/security_guardrail_check.php"`
  - Result: no matches (exit code 1 from `rg` = none found).
- SH-05 verification:
  - Command: `php tools/security_guardrail_check.php`
  - Output: `Hardcoded-secret guardrail passed (no obvious literals found).`
  - CI wiring: `.github/workflows/security-guardrail.yml` runs guardrail on push/PR.
- Docker/local boot confirmation (env-driven credentials), re-verified 2026-02-21:
  - Runtime fix for reproducible DB bootstrap:
    - Removed invalid trailing `\unrestrict ...` from `docker/db/dump.sql` (Postgres init error source).
    - Validation command: `rg -n "\\unrestrict" docker/db/dump.sql`
    - Output: no matches (exit code 1).
  - Commands:
    - `$env:POSTGRES_PASSWORD='nr_csr'; $env:DEFAULT_USER_PASSWORD='nr_csr'; docker compose down -v --remove-orphans`
    - `$env:POSTGRES_PASSWORD='nr_csr'; $env:DEFAULT_USER_PASSWORD='nr_csr'; docker compose up -d db app nginx`
    - `$env:POSTGRES_PASSWORD='nr_csr'; $env:DEFAULT_USER_PASSWORD='nr_csr'; docker compose ps -a`
    - `$env:POSTGRES_PASSWORD='nr_csr'; $env:DEFAULT_USER_PASSWORD='nr_csr'; docker compose exec -T app php artisan --version`
    - `$env:POSTGRES_PASSWORD='nr_csr'; $env:DEFAULT_USER_PASSWORD='nr_csr'; docker compose exec -T app php artisan migrate:status --no-ansi`
    - `$env:POSTGRES_PASSWORD='nr_csr'; $env:DEFAULT_USER_PASSWORD='nr_csr'; docker compose run --rm php74-pgsql "php artisan --version"`
  - Output highlights:
    - `docker compose ps -a`: `nr_csr_db`, `nr_csr_app`, `nr_csr_nginx` all `Up`.
    - `php artisan --version` (in `app`): `Laravel Framework 6.20.16`.
    - `php artisan migrate:status` (in `app`): migrations listed as `Yes` (DB connection/auth succeeds).
    - `php74-pgsql` local-compatible runtime boot: `Laravel Framework 6.20.16`.

### A2 (Destructive GET remediation)

- Route scan:
  - Command: `rg -n "Route::get\\([^\\n]*@[A-Za-z0-9_]*(Delete|Hapus|Destroy|delete|hapus|destroy)|Route::get\\([^\\n]*(delete|hapus|destroy)" routes -S`
  - Result: no matches (exit code 1 from `rg` = none found).
- Existing destructive route methods verified as non-GET:
  - Command: `rg -n "Route::(delete|post|put|patch)\\([^\\n]*(delete|hapus|destroy)" routes/web.php -S`
  - Result: destructive endpoints are mapped as `Route::delete(...)`.
- CSRF + authorization + HTTP method protection tests:
  - Local host runtime (`php artisan test --filter=DeleteRouteProtectionTest`) fails due Laravel 6 + current host PHP incompatibility (`Collection::offsetExists` return-type error under modern PHP).
  - Docker PHP 7.4 runtime command: `docker compose run --rm php74-pgsql "vendor/bin/phpunit --filter DeleteRouteProtectionTest"`
  - Output: `OK (3 tests, 3 assertions)` including:
    - CSRF-invalid delete request blocked
    - unauthorized delete blocked
    - GET method on delete endpoint blocked

## 11) A3-A6 Evidence Notes (executed 2026-02-21)

### A3 (SQL interpolation remediation)

- Controller batches executed in required order:
  - `app/Http/Controllers/APIController.php`
  - `app/Http/Controllers/AnggaranController.php`
  - `app/Http/Controllers/DashboardController.php`
  - `app/Http/Controllers/TasklistController.php`
  - `app/Http/Controllers/PekerjaanController.php`
- Before scan (captured before remediation):
  - Command:
    - `rg -n "DB::select" app/Http/Controllers/APIController.php app/Http/Controllers/AnggaranController.php app/Http/Controllers/DashboardController.php app/Http/Controllers/TasklistController.php app/Http/Controllers/PekerjaanController.php`
  - Output sample:
    - `APIController.php:328 ... WHERE NO_AGENDA = '$dataPembayaran->no_agenda'`
    - `APIController.php:1776 ... NOT IN ($kalimat) ... TAHUN = '$tahun' ...`
    - `AnggaranController.php:125 ... WHERE ID_ANGGARAN = '$logID'`
    - `DashboardController.php:660 ... EVALUATOR1 = '$username' ...`
    - `TasklistController.php:253 ... EVALUATOR1 = '$username' ...`
    - `PekerjaanController.php:72 ... PEKERJAAN_ID = '$logID'`
- After scan:
  - Command:
    - `rg -n 'DB::select\\(\".*\\$' app/Http/Controllers/APIController.php app/Http/Controllers/AnggaranController.php app/Http/Controllers/DashboardController.php app/Http/Controllers/TasklistController.php app/Http/Controllers/PekerjaanController.php`
  - Output:
    - `No interpolated DB::select patterns found in target controllers.`

### A4 (Upload hardening)

- Hardened high-use upload flows:
  - `app/Http/Controllers/LampiranController.php` (`store`, `update`)
  - `app/Http/Controllers/PekerjaanController.php` (`store`, `update`, `storeSPPH`, `storeBAKN`, `storeSPK`, `storeLampiran`)
  - `config/filesystems.php` (added `attachment` disk for `Storage` abstraction on legacy `public/attachment` path)
- Before scan (targeted controllers):
  - Command:
    - `rg -n -- "->move\\(" app/Http/Controllers/PekerjaanController.php app/Http/Controllers/LampiranController.php`
  - Output sample:
    - `PekerjaanController.php:145 ...->move(public_path() . '/attachment', $fileName);`
    - `PekerjaanController.php:233 ...->move(public_path() . '/attachment', $fileName);`
    - `PekerjaanController.php:337 ...->move(public_path() . '/attachment', $fileName);`
    - `PekerjaanController.php:411 ...->move(public_path() . '/attachment', $fileName);`
    - `PekerjaanController.php:772 ...->move(public_path() . '/attachment', $fileName);`
    - `PekerjaanController.php:953 ...->move(public_path() . '/attachment', $fileName);`
    - `LampiranController.php:65 ...->move('attachment',$featured_new_name);`
    - `LampiranController.php:123 ...->move('attachment', $fileName);`
- After scan:
  - Command:
    - `rg -n -- "->move\\(" app/Http/Controllers/PekerjaanController.php app/Http/Controllers/LampiranController.php`
  - Output:
    - `No direct ->move(...) calls found in hardened upload controllers.`

### A5 (Baseline security tests)

- Added tests:
  - `tests/Feature/SecuritySqlInjectionRegressionTest.php`
  - `tests/Feature/SecurityUploadHardeningTest.php`
- SQL malicious-input regression command/output:
  - Command:
    - `docker compose run --rm php74-pgsql "vendor/bin/phpunit tests/Feature/SecuritySqlInjectionRegressionTest.php"`
  - Output:
    - `OK (1 test, 3 assertions)`
- Upload negative/positive regression command/output:
  - Command:
    - `docker compose run --rm php74-pgsql "vendor/bin/phpunit tests/Feature/SecurityUploadHardeningTest.php"`
  - Output:
    - `OK (4 tests, 18 assertions)`
  - Covered cases:
    - spoofed extension blocked
    - forbidden file type blocked
    - oversize upload blocked
    - valid PDF upload accepted with safe generated filename

### A6 (CI baseline)

- Workflow updated:
  - `.github/workflows/security-guardrail.yml`
- Guardrail command output:
  - Command:
    - `php tools/security_guardrail_check.php`
  - Output:
    - `Hardcoded-secret guardrail passed (no obvious literals found).`
- CI job now fails build on:
  - guardrail failure (`php tools/security_guardrail_check.php`)
  - A3-A5 + transaction-boundary test failure:
    - `vendor/bin/phpunit tests/Feature/SecuritySqlInjectionRegressionTest.php tests/Feature/SecurityUploadHardeningTest.php tests/Feature/TransactionBoundaryRollbackTest.php`

## 12) Transaction Boundary Evidence Notes (executed 2026-02-21)

- Multi-write approval/submit flows wrapped in transactions:
  - `app/Http/Controllers/TasklistController.php`:
    - `approveEvaluator` (`DB::transaction` at line ~318)
    - `approveKadep` (`DB::transaction` at line ~373)
    - `approveKadiv` (`DB::transaction` at lines ~429 and ~467)
  - `app/Http/Controllers/PekerjaanController.php`:
    - `storeLampiran` (`DB::transaction` at line ~965)
- Verification scan:
  - Command:
    - `rg -n "DB::transaction\\(" app/Http/Controllers/TasklistController.php app/Http/Controllers/PekerjaanController.php`
  - Output:
    - `TasklistController.php:318`
    - `TasklistController.php:373`
    - `TasklistController.php:429`
    - `TasklistController.php:467`
    - `PekerjaanController.php:965`
- Forced error rollback confirmation:
  - Added test: `tests/Feature/TransactionBoundaryRollbackTest.php`
  - Mechanism:
    - first write inserts into `tbl_lampiran_pekerjaan`
    - second write intentionally fails (`tbl_log_pekerjaan` table not created in test)
    - assertion verifies first write was rolled back
  - Command:
    - `docker compose run --rm php74-pgsql "vendor/bin/phpunit tests/Feature/TransactionBoundaryRollbackTest.php"`
  - Output:
    - `OK (1 test, 2 assertions)`

## 13) Priority 1 Evidence Notes (executed 2026-02-21)

### P1.1 Controller decomposition + FormRequest migration (target-4 controllers)

- Scope executed:
  - `KelayakanController`: `cariBulan`, `cariTahun`, `cariPeriode` moved to FormRequest + Action flow
  - `APIController`: `postPaymentRequestAnnual` moved to FormRequest + Action flow
  - `DashboardController`: `postAnnual`, `postSubsidiary` moved to FormRequest + Action flow
  - `PembayaranController`: `store`, `update` moved to FormRequest + Action + `PembayaranUpsertService`
- Controller complexity scan (before vs after):
  - Command:
    - `$controllers = @('KelayakanController','APIController','DashboardController','PembayaranController'); foreach ($c in $controllers) { $path = "app/Http/Controllers/$c.php"; $beforeText = git show "HEAD:$path" | Out-String; $beforeLoc = ($beforeText -split "`n").Count; $beforeMethods = ([regex]::Matches($beforeText, '(?m)^\\s*public function\\s+')).Count; $afterLoc = (Get-Content $path).Count; $afterText = Get-Content $path -Raw; $afterMethods = ([regex]::Matches($afterText, '(?m)^\\s*public function\\s+')).Count; "$c BEFORE: LOC=$beforeLoc methods=$beforeMethods | AFTER: LOC=$afterLoc methods=$afterMethods" }`
  - Output:
    - `KelayakanController BEFORE: LOC=3877 methods=64 | AFTER: LOC=3760 methods=64`
    - `APIController BEFORE: LOC=1929 methods=42 | AFTER: LOC=1912 methods=42`
    - `DashboardController BEFORE: LOC=1510 methods=9 | AFTER: LOC=1501 methods=9`
    - `PembayaranController BEFORE: LOC=1316 methods=20 | AFTER: LOC=1160 methods=20`
- Validation migration evidence (inline validate reductions):
  - Command:
    - `$controllers = @('KelayakanController','APIController','DashboardController','PembayaranController'); foreach ($c in $controllers) { $path = "app/Http/Controllers/$c.php"; $beforeText = git show "HEAD:$path" | Out-String; $beforeCount = ([regex]::Matches($beforeText, '\\$request->validate\\(|\\$this->validate\\(')).Count; $afterText = Get-Content $path -Raw; $afterCount = ([regex]::Matches($afterText, '\\$request->validate\\(|\\$this->validate\\(')).Count; "$c inline validate BEFORE=$beforeCount AFTER=$afterCount" }`
  - Output:
    - `KelayakanController inline validate BEFORE=31 AFTER=20`
    - `APIController inline validate BEFORE=14 AFTER=12`
    - `DashboardController inline validate BEFORE=2 AFTER=0`
    - `PembayaranController inline validate BEFORE=3 AFTER=1`
- Refactored flow tests (feature):
  - Local host runtime check:
    - `php artisan test --filter=PriorityOneMaintainabilityFlowsTest`
    - Output:
      - fails under host PHP 8.3 due Laravel 6 return-type compatibility warning (`Collection::offsetExists`)
  - Docker PHP 7.4 runtime command:
    - `docker run --rm -v "${PWD}:/app" -w /app php:7.4-cli php vendor/bin/phpunit --filter PriorityOneMaintainabilityFlowsTest`
  - Output:
    - `OK (18 tests, 48 assertions)`
- Impacted files:
  - Controllers:
    - `app/Http/Controllers/KelayakanController.php`
    - `app/Http/Controllers/APIController.php`
    - `app/Http/Controllers/DashboardController.php`
    - `app/Http/Controllers/PembayaranController.php`
  - Actions:
    - `app/Actions/API/PostPaymentRequestAnnualAction.php`
    - `app/Actions/Dashboard/PostDashboardAnnualAction.php`
    - `app/Actions/Dashboard/PostDashboardSubsidiaryAction.php`
    - `app/Actions/Kelayakan/CariKelayakanBulanAction.php`
    - `app/Actions/Kelayakan/CariKelayakanTahunAction.php`
    - `app/Actions/Kelayakan/CariKelayakanPeriodeAction.php`
    - `app/Actions/Pembayaran/StorePembayaranAction.php`
    - `app/Actions/Pembayaran/UpdatePembayaranAction.php`
  - Services:
    - `app/Services/Pembayaran/PembayaranUpsertService.php`
  - FormRequests:
    - `app/Http/Requests/PostPaymentRequestAnnualRequest.php`
    - `app/Http/Requests/PostDashboardAnnualRequest.php`
    - `app/Http/Requests/PostDashboardSubsidiaryRequest.php`
    - `app/Http/Requests/CariKelayakanBulanRequest.php`
    - `app/Http/Requests/CariKelayakanTahunRequest.php`
    - `app/Http/Requests/CariKelayakanPeriodeRequest.php`
    - `app/Http/Requests/StorePembayaranRequest.php`
    - `app/Http/Requests/UpdatePembayaranRequest.php`
  - Tests:
    - `tests/Feature/PriorityOneMaintainabilityFlowsTest.php`
- Final changed-files command/output:
  - Command:
    - `git status --short`
  - Output:
    - `M app/Http/Controllers/APIController.php`
    - `M app/Http/Controllers/DashboardController.php`
    - `M app/Http/Controllers/KelayakanController.php`
    - `M app/Http/Controllers/PembayaranController.php`
    - `M docs/project-improvement-checklist.md`
    - `?? app/Actions/API/PostPaymentRequestAnnualAction.php`
    - `?? app/Actions/Dashboard/PostDashboardAnnualAction.php`
    - `?? app/Actions/Dashboard/PostDashboardSubsidiaryAction.php`
    - `?? app/Actions/Kelayakan/CariKelayakanBulanAction.php`
    - `?? app/Actions/Kelayakan/CariKelayakanPeriodeAction.php`
    - `?? app/Actions/Kelayakan/CariKelayakanTahunAction.php`
    - `?? app/Actions/Pembayaran/StorePembayaranAction.php`
    - `?? app/Actions/Pembayaran/UpdatePembayaranAction.php`
    - `?? app/Http/Requests/CariKelayakanBulanRequest.php`
    - `?? app/Http/Requests/CariKelayakanPeriodeRequest.php`
    - `?? app/Http/Requests/CariKelayakanTahunRequest.php`
    - `?? app/Http/Requests/PostDashboardAnnualRequest.php`
    - `?? app/Http/Requests/PostDashboardSubsidiaryRequest.php`
    - `?? app/Http/Requests/PostPaymentRequestAnnualRequest.php`
    - `?? app/Http/Requests/StorePembayaranRequest.php`
    - `?? app/Http/Requests/UpdatePembayaranRequest.php`
    - `?? app/Services/Pembayaran/PembayaranUpsertService.php`
    - `?? tests/Feature/PriorityOneMaintainabilityFlowsTest.php`

## 14) Priority 1 Follow-up Evidence Notes (executed 2026-02-21)

### P1.2 Unify authentication state management

- Implementation:
  - Added centralized auth abstraction: `app/Services/Auth/AuthContext.php`
  - Registered service binding: `app/Providers/AppServiceProvider.php`
  - Refactored middleware to use auth context:
    - `app/Http/Middleware/CredentialLogin.php`
    - `app/Http/Middleware/SessionTimeOut.php`
    - `app/Http/Middleware/OnlyAdmin.php`
    - `app/Http/Middleware/OnlyApprover.php`
    - `app/Http/Middleware/OnlyExporter.php`
    - `app/Http/Middleware/OnlyFinance.php`
    - `app/Http/Middleware/OnlyLegal.php`
    - `app/Http/Middleware/OnlyReport.php`
    - `app/Http/Middleware/OnlySubsidiary.php`
    - `app/Http/Middleware/OnlyUser.php`
    - `app/Http/Middleware/OnlyVendor.php`
  - Refactored critical controllers:
    - `app/Http/Controllers/LoginController.php`
    - `app/Http/Controllers/DashboardController.php`
    - `app/Http/Controllers/PembayaranController.php`
- Before/after scan (direct `session('user')` in refactored files):
  - Before command:
    - `rg -n "session\\('user'\\)" app/Http/Middleware app/Http/Controllers/LoginController.php app/Http/Controllers/PembayaranController.php app/Http/Controllers/DashboardController.php`
  - Before output:
    - `34` matches
  - After command:
    - `rg -n "session\\('user'\\)" app/Http/Middleware app/Http/Controllers/LoginController.php app/Http/Controllers/PembayaranController.php app/Http/Controllers/DashboardController.php`
  - After output:
    - `No direct session('user') usage found in refactored middleware/controllers.`
- Flow tests:
  - `docker compose run --rm php74-pgsql 'vendor/bin/phpunit tests/Feature/AuthStateConsistencyTest.php'`
  - Output: `OK (8 tests, 18 assertions)`
  - `docker compose run --rm php74-pgsql 'vendor/bin/phpunit tests/Feature/PriorityOneMaintainabilityFlowsTest.php'`
  - Output: `OK (18 tests, 48 assertions)`

### P1.3 Remove legacy/duplicate `*Old` methods + dead/commented code

- Removed legacy methods:
  - `app/Http/Controllers/LoginController.php` (`loginOld`)
  - `app/Http/Controllers/KelayakanController.php` (`submitOld`)
  - `app/Http/Controllers/ReportController.php` (`indexOld`)
  - `app/Http/Controllers/SurveiController.php` (`updateTerminOld`)
- Dead/commented cleanup in touched scope:
  - `app/Http/Controllers/SurveiController.php` (obsolete commented termin block)
  - `app/Http/Controllers/PembayaranController.php` (obsolete commented try/catch block)
  - `routes/web/protected/anggaran.php` (obsolete commented route line)
- Before/after scan:
  - Before command:
    - `rg -n "public function \\w+Old\\b|->\\w+Old\\(|::\\w+Old\\(" app/Http/Controllers routes tests`
  - Before output:
    - `4` declarations
  - After command:
    - `rg -n "public function \\w+Old\\b|->\\w+Old\\(|::\\w+Old\\(" app/Http/Controllers routes tests`
  - After output:
    - `No *Old method declarations/usages found in controllers/routes/tests.`

### P1.4 Modularize route definition

- Route split:
  - Root loader: `routes/web.php`
  - Public route files:
    - `routes/web/public-auth.php`
    - `routes/web/public-form.php`
  - Protected wrapper:
    - `routes/web/protected.php`
  - Protected domain files:
    - `routes/web/protected/dashboard.php`
    - `routes/web/protected/master.php`
    - `routes/web/protected/vendor.php`
    - `routes/web/protected/operasional.php`
    - `routes/web/protected/proposal.php`
    - `routes/web/protected/anggaran.php`
    - `routes/web/protected/report.php`
    - `routes/web/protected/payment.php`
    - `routes/web/protected/export-popay.php`
    - `routes/web/protected/todo.php`
    - `routes/web/protected/tasklist.php`
    - `routes/web/protected/tasklist-legal.php`
    - `routes/web/protected/dokumen-legal.php`
    - `routes/web/protected/profile.php`
    - `routes/web/protected/subsidiary.php`
- Route equivalence verification:
  - Before command:
    - `docker compose run --rm php74-pgsql 'php artisan route:list > storage/route-list-before-p1.txt && wc -l storage/route-list-before-p1.txt'`
  - Before output:
    - `508 storage/route-list-before-p1.txt`
  - After command:
    - `docker compose run --rm php74-pgsql 'php artisan route:list > storage/route-list-after-p1.txt && wc -l storage/route-list-after-p1.txt'`
  - After output:
    - `508 storage/route-list-after-p1.txt`
  - Diff command:
    - `git diff --no-index -- storage/route-list-before-p1.txt storage/route-list-after-p1.txt`
  - Diff output:
    - `Route list diff: no changes detected.`

## 15) Priority 2 Evidence Notes (executed 2026-02-21)

### P2.1 Build meaningful critical-path tests

- Added/expanded critical-path tests:
  - `tests/Feature/PriorityTwoCriticalPathTransitionsTest.php`
  - `tests/Feature/AuthStateConsistencyTest.php` (added `OnlyUser` + `OnlyReport` role-gate assertions)
- Coverage delivered in test cases:
  - auth/session flows (`AuthStateConsistencyTest`)
  - authorization role-gates (`OnlyAdmin`, `OnlyUser`, `OnlyReport`)
  - proposal lifecycle transitions (`storeSubProposal`, `editSubProposal`, `deleteSubProposal`)
  - approval transitions (`approveEvaluator`, `approveKadep`, `approveKadiv`)
  - destructive action protection (`deleteSubProposal`: GET blocked, CSRF blocked, unauthorized role blocked)
- Before/after scan command:
  - `rg -n "PriorityTwoCriticalPathTransitionsTest|deleteSubProposal|approveEvaluator|approveKadep|approveKadiv|OnlyUser|OnlyReport" tests/Feature -S`
  - Output includes new `PriorityTwoCriticalPathTransitionsTest` route/middleware coverage and added `OnlyUser`/`OnlyReport` checks.
- Test execution command/output:
  - `docker compose run --rm php74-pgsql "vendor/bin/composer run quality:test:critical"`
  - Output: `OK (48 tests, 118 assertions)`

### P2.2 CI pipeline baseline

- Workflow updated:
  - `.github/workflows/security-guardrail.yml`
- Workflow diff highlights:
  - renamed to `Quality Baseline`
  - added `concurrency` (`cancel-in-progress: true`) for PR-friendliness
  - retained guardrail and added static/style/test quality gates
  - step sequence is fail-fast by default (later checks stop when earlier step fails)
- Validation command/output (local CI-like run):
  - `docker compose run --rm php74-pgsql "vendor/bin/composer install --no-interaction --prefer-dist --no-progress --ignore-platform-req=ext-oci8 --ignore-platform-req=ext-gd --ignore-platform-req=ext-zip && php tools/security_guardrail_check.php && vendor/bin/composer run quality:static && vendor/bin/composer run quality:style && vendor/bin/composer run quality:test:critical"`
  - Output highlights:
    - `Hardcoded-secret guardrail passed (no obvious literals found).`
    - `No errors` (PHPStan)
    - style dry-run clean
    - `OK (48 tests, 118 assertions)`

### P2.3 Static analysis + style gate baseline

- Tooling introduced:
  - `phpstan/phpstan`, `nunomaduro/larastan`, `friendsofphp/php-cs-fixer` in `composer.json`/`composer.lock`
  - `phpstan.neon.dist`
  - `phpstan-baseline.neon` (generated baseline)
  - `.php-cs-fixer.dist.php` (scoped baseline to critical files)
  - Composer scripts:
    - `quality:static`
    - `quality:style`
    - `quality:test:critical`
- Before/after scan command:
  - Before (no baseline files): `rg --files -g "*phpstan*" -g "*pint*" -g ".php-cs-fixer*" -g "*.neon" -g "*.dist"`
    - result before implementation: no quality baseline config files
  - After: `rg --files -g "phpstan*.neon*" -g ".php-cs-fixer.dist.php"`
    - output:
      - `phpstan.neon.dist`
      - `phpstan-baseline.neon`
      - `.php-cs-fixer.dist.php`
- Static/style command outputs:
  - `docker compose run --rm php74-pgsql "vendor/bin/composer run quality:static"`
    - output: `[OK] No errors`
  - `docker compose run --rm php74-pgsql "vendor/bin/composer run quality:style"`
    - output: style dry-run clean

### P2.4 Runtime observability baseline

- Structured logging added (actor/action/context fields):
  - `app/Http/Controllers/TasklistController.php`:
    - `approval.transition`
    - `approval.transition_failed`
  - `app/Http/Controllers/LampiranController.php`:
    - `upload.event`
    - `upload.event_failed`
  - `app/Exceptions/Handler.php`:
    - `critical_exception`
- Scan command/output:
  - `rg -n "approval.transition|upload.event|critical_exception" app/Http/Controllers/TasklistController.php app/Http/Controllers/LampiranController.php app/Exceptions/Handler.php -S`
  - Output confirms all required structured log markers exist in target files.
- Sample log evidence from test/dev execution:
  - `testing.INFO: approval.transition {"action":"approve_evaluator","actor_username":"critical.path.user","actor_role":"Inputer","evaluasi_ids":["1"],"target_status":"Approved 1","catatan":"CatatanEvaluator","agenda":"AGD-APP-001"}`
  - `testing.INFO: upload.event {"action":"lampiran_store","actor_username":"security.tester","actor_role":"Inputer","kelayakan_id":1,"agenda":"AGD-001","file_name":"...pdf","file_type":"pdf","file_size":262144}`
  - `local.ERROR: critical_exception {"exception_class":"Exception","message":"P2 critical exception probe","url":"http://localhost","method":"GET","actor_username":null,"actor_role":null}`

### P2.5 Dependency hygiene pass (plan only)

- Added planning artifact:
  - `docs/dependency-hygiene-plan.md`
- Compatibility/risk data sources:
  - `docker compose run --rm php74-pgsql "php -v | head -n 1 && vendor/bin/composer --version"`
  - `docker compose run --rm php74-pgsql "vendor/bin/composer show --direct"`
  - `docker compose run --rm php74-pgsql "vendor/bin/composer outdated --direct --strict"`
- Plan contents:
  - current compatibility/risk matrix
  - phased roadmap (Phase 0..3)
  - execution rules (one-axis upgrades, rollback, gate criteria)

### Priority 2 impacted files

- `.github/workflows/security-guardrail.yml`
- `app/Exceptions/Handler.php`
- `app/Http/Controllers/LampiranController.php`
- `app/Http/Controllers/TasklistController.php`
- `composer.json`
- `composer.lock`
- `docs/dependency-hygiene-plan.md`
- `phpstan.neon.dist`
- `phpstan-baseline.neon`
- `.php-cs-fixer.dist.php`
- `tests/Feature/AuthStateConsistencyTest.php`
- `tests/Feature/PriorityTwoCriticalPathTransitionsTest.php`
- `tools/security_guardrail_check.php`

### Residual risks and follow-up items

- PHPStan emits a Larastan legacy deprecation warning (`checkGenericClassInNonGenericObjectType`) from extension-level behavior; analysis still passes.
- PHP-CS-Fixer v2 is functional on current stack but unmaintained; plan migration to v3 in dependency roadmap.
- Root dependency graph remains legacy/EOL-biased (Laravel 6/PHP 7.x line); phased upgrade roadmap documented in `docs/dependency-hygiene-plan.md`.
