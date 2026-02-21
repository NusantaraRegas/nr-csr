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

- [ ] **Replace destructive GET endpoints with POST/DELETE + CSRF + authorization**
  - [ ] Confirmation: grep for destructive GET routes returns **0** for approved route groups
  - [ ] Confirmation: feature tests verify unauthorized/CSRF-invalid delete requests are blocked

- [ ] **Eliminate SQL injection vectors from interpolated raw SQL**
  - [ ] Confirmation: migrate to query builder / bound parameters (`?` bindings)
  - [ ] Confirmation: regression test includes malicious payloads and query remains safe

- [ ] **Fix credentials/secrets hygiene**
  - [ ] **SH-01: Inventory secrets exposure points** (compose, env examples, scripts, seed/default credential paths)
  - [ ] **SH-02: Remove hardcoded DB secrets from docker setup**
    - [ ] Replace literal passwords in `docker-compose.yml` with `${...}` variables
    - [ ] Keep safe non-sensitive defaults only for local convenience
  - [ ] **SH-03: Sanitize example env files**
    - [ ] `.env.docker.example` must use placeholders/example values, not real-like secrets
    - [ ] Add inline comments describing which values must be changed per environment
  - [ ] **SH-04: Remove static default password patterns from app code**
    - [ ] Eliminate/replace code paths like `bcrypt('corp.NR')`
    - [ ] Require explicit password input or generated one-time onboarding flow
  - [ ] **SH-05: Add lightweight guardrail check**
    - [ ] Add simple grep/check step in CI to detect obvious hardcoded patterns (`PASSWORD=`, `corp.NR`, `StrongPass123`)
  - [ ] Confirmation: repository scan shows no hardcoded secrets/default passwords in tracked config + app code
  - [ ] Confirmation: docker/local boot still works with env-driven credentials

- [ ] **Standardize transaction boundaries**
  - [ ] Prefer `DB::transaction(...)` for multi-write flows, especially approval/submit flows
  - [ ] Confirmation: forced error path proves rollback consistency

- [ ] **Harden upload surface**
  - [ ] Replace direct `->move(...)` with `Storage` abstraction where possible
  - [ ] Enforce strict mime, extension, size, and naming policies
  - [ ] Confirmation: blocked upload tests (spoofed extension, oversize, forbidden type) pass

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
- [ ] **A0: Create execution board (0.5 day)**
  - [ ] Create tickets: `A1-secrets`, `A2-routes`, `A3-sql`, `A4-uploads`, `A5-tests`, `A6-ci`
  - [ ] Define owner + due date + verification evidence format per ticket

- [ ] **A1: Secrets hygiene (small slices, 1–2 days)**
  - [ ] **A1.1 (quick win):** replace hardcoded passwords in `docker-compose.yml` with env vars
  - [ ] **A1.2:** sanitize `.env.docker.example` placeholders + comments
  - [ ] **A1.3:** remove static default password code path(s), including `corp.NR`
  - [ ] **A1.4:** add CI grep guardrail for obvious secret patterns
  - [ ] **A1.5 verification:** run scan commands + smoke boot and attach evidence

- [ ] **A2: Destructive GET remediation (1–2 days)**
  - [ ] Convert delete/hapus/destroy GET routes to POST/DELETE in one domain at a time
  - [ ] Update forms/buttons/calls and verify CSRF + authorization behavior

- [ ] **A3: SQL interpolation remediation (2–4 days)**
  - [ ] Batch by controller risk order: `APIController` → `AnggaranController` → `DashboardController` → `TasklistController` → `PekerjaanController`
  - [ ] Replace interpolation with query builder/bindings and verify malicious-input behavior

- [ ] **A4: Upload hardening (1–2 days)**
  - [ ] Prioritize top upload flows first, migrate to `Storage`, tighten validation

- [ ] **A5: Baseline tests (1–2 days)**
  - [ ] Add security-focused feature tests for A1–A4 critical scenarios

- [ ] **A6: CI baseline (0.5–1 day)**
  - [ ] Add workflow running tests + secret guardrail checks on PR

- [ ] **Phase A exit criteria**
  - [ ] All A1–A6 tickets merged
  - [ ] Checklist confirmations include command/test evidence links

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
