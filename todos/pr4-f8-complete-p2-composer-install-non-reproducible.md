---
status: complete
resolved_at: 2026-04-24
priority: p2
issue_id: 'pr4-f8'
pr: 4
source: ai
author: 'performance-oracle + architecture-strategist + security-sentinel'
scope: in_scope
tags: [code-review, ci]
file: .github/workflows/ci.yml
line: 47
---

## Problem Statement
File: .github/workflows/ci.yml:47

## Finding
composer.lock is .gitignored. CI runs `composer install` which, without a lock, falls back to update behavior (Composer 2.x warns but proceeds). Every CI run resolves deps fresh; 'green on CI' is a moving target, and a malicious minor in any direct dep lands silently. The compound doc explicitly blessed 'no lock for libraries' but CI reproducibility is a separate concern.

## Proposed Solution
Two clean paths: (a) commit composer.lock (standard in 2026 for libraries with CI; update the compound doc with the nuance that consumers still resolve their own tree), or (b) switch to `composer update --prefer-dist --no-interaction --no-progress` explicitly and accept non-determinism. Recommend (a). Fix in PR2.

## Acceptance Criteria
- [ ] Decision recorded (commit lock vs explicit update)
- [ ] If (a): composer.lock committed and .gitignore updated
- [ ] Compound doc updated to reflect the new convention

## Work Log

### 2026-04-24 — Approved for Work
**By:** Claude Triage System
**Actions:**
- Approved during triage; status pending → ready.
