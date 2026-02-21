# Dependency Hygiene Plan (Priority 2)

Date: 2026-02-21

## Scope

This document provides a compatibility and risk baseline for dependency upgrades.
It does **not** execute major-version runtime upgrades.

## Current Compatibility Matrix

| Area | Current constraint / lock | Compatibility notes | Risk |
|---|---|---|---|
| PHP runtime | `^7.2` (project), validated on PHP `7.4.33` | Laravel 6 is end-of-life; modern ecosystem support is shrinking | High |
| Laravel framework | `^6.0` (lock: `v6.20.16`) | Security/maintenance gap vs supported Laravel lines | High |
| Test framework | `phpunit/phpunit ^8.0` (lock: `8.5.51`) | Works for PHP 7.4; upgrade needed for newer PHP/Laravel targets | Medium |
| Static analysis | `phpstan/phpstan ^1.10` + `nunomaduro/larastan ^1.0` | Baseline established; Larastan package line is legacy/abandoned | Medium |
| Style tooling | `friendsofphp/php-cs-fixer ^2.19` | Functional for PHP 7.4; v2 line is unmaintained | Medium |
| DataTables stack | `yajra/laravel-datatables-oracle ^9.21` + OCI packages | Tied to older Laravel/PHP matrix and OCI availability | Medium |
| Excel/export stack | `maatwebsite/excel ^3.1` + `phpoffice/phpspreadsheet` | Platform extension requirements (`zip`, optionally `gd`) affect CI/runtime portability | Medium |
| Faker | `fzaninotto/faker ^1.4` | Abandoned package, replacement is `fakerphp/faker` | Medium |

## Upgrade Constraints Snapshot

- Laravel 6 + PHP 7.x coupling limits safe movement of static/style/testing toolchains.
- OCI8 stack must remain explicitly installed for app bootstrap compatibility.
- CI must continue ignoring `ext-oci8` where OCI extension is unavailable.
- Existing baseline tests must remain green during each phase.

## Phased Roadmap (No Major Upgrade Executed Yet)

### Phase 0: Stabilize quality gates on current stack

- Keep Laravel `6.20.16` lock stable.
- Keep OCI packages explicit in root dependencies.
- Run guardrail + static + style + critical-path tests in CI for every PR.
- Track current baseline warnings as debt (Larastan/CS-Fixer package lineage).

### Phase 1: Runtime readiness and package hygiene

- Raise minimum PHP target to `7.4` explicitly (constraint cleanup), then prepare for `8.1`.
- Replace `fzaninotto/faker` with `fakerphp/faker`.
- Migrate Larastan package namespace (`larastan/larastan`) on a compatible Laravel/PHP step.
- Upgrade CS-Fixer v2 -> v3 once PHP target and dependency graph allow.

### Phase 2: Framework modernization path

- Target Laravel 8/9 transitional upgrade first (framework + test harness compatibility).
- Update PHPUnit to line compatible with chosen Laravel/PHP target.
- Re-run full critical-path suite and static baseline regeneration per step.
- Keep OCI/DataTables compatibility verification as explicit gate.

### Phase 3: Post-upgrade hardening

- Move to supported Laravel LTS line and supported PHP runtime.
- Tighten PHPStan level gradually (remove baseline entries in slices).
- Expand style scope from critical files to broader app paths.

## Execution Rules for Future Upgrade Tickets

1. Upgrade one major axis at a time (PHP or Laravel, not both simultaneously).
2. Keep rollback path documented per step (lockfile + tagged build).
3. Require green guardrail, static/style baseline, and critical-path tests before merge.
4. Record environment constraints (`ext-oci8`, DB driver expectations) in each ticket.
