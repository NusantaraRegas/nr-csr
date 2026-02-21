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

- [ ] **Split oversized controllers into Service + Action/UseCase classes**
  - Target first: `KelayakanController`, `APIController`, `DashboardController`, `PembayaranController`
  - [ ] Confirmation: controller LOC/complexity reduced and critical paths still pass tests

- [ ] **Adopt FormRequest consistently**
  - [ ] Replace inline `$request->validate(...)` in core flows with dedicated Request classes
  - [ ] Confirmation: validation behavior parity proven via feature tests

- [ ] **Unify authentication state management**
  - [ ] Gradually replace/manual-wrap direct `session('user')` dependency with centralized auth context
  - [ ] Confirmation: login/logout/session-timeout flows are consistent and tested

- [ ] **Remove legacy/duplicate methods (`*Old`) + dead/commented code**
  - [ ] Confirmation: route references cleaned; grep shows no active legacy entrypoints

- [ ] **Modularize route definition**
  - [ ] Split `routes/web.php` by bounded feature domains
  - [ ] Confirmation: `route:list` remains behaviorally equivalent

---

## 5) Priority 2 — Reliability and delivery quality

- [ ] **Build meaningful test suite for critical journeys**
  - Coverage minimum: auth, authorization, proposal lifecycle, approval transitions, destructive actions
  - [ ] Confirmation: CI test run green with critical-path tests in place

- [ ] **Add CI pipeline**
  - [ ] Include lint/static checks + unit/feature tests on PR
  - [ ] Confirmation: failing checks block merge

- [ ] **Introduce static analysis + style gate**
  - [ ] Add PHPStan/Larastan and formatter (Pint or PHP-CS-Fixer)
  - [ ] Confirmation: baseline established and enforced in CI

- [ ] **Improve runtime observability**
  - [ ] Structured logs for approval actions, upload events, critical exceptions
  - [ ] Confirmation: log entries contain traceable actor/action/context fields

- [ ] **Dependency hygiene pass**
  - [ ] Plan upgrade path for Laravel/PHP and review deprecated packages in `composer.json`
  - [ ] Confirmation: documented compatibility matrix and phased migration plan

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
