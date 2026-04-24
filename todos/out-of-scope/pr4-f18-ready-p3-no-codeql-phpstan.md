---
status: ready
priority: p3
issue_id: 'pr4-f18'
pr: 4
source: ai
author: 'security-sentinel + architecture-strategist'
scope: out_of_scope
tags: [code-review, ci, defer-pr3]
defer: pr3
file: null
line: null
---

## Problem Statement
File: N/A

## Finding
No static analysis wired up yet. Scrutinizer was deleted, nothing replaces it in PR2.

## Proposed Solution
Deferred to PR3 — plan specifies PHPStan L8 + CodeQL for PHP with weekly + on-push schedule. Fix in PR3.

## Acceptance Criteria
- [ ] PHPStan L8 configured and wired to CI
- [ ] CodeQL workflow added for PHP with weekly + on-push schedule
- [ ] Baseline findings triaged

## Work Log

### 2026-04-24 — Approved as PR3-deferred
**By:** Claude Triage System
**Actions:**
- Approved during triage but explicitly scoped to PR3 (security audit + hardening phase) per the plan at docs/plans/2026-04-24-refactor-security-php84-symfony64-upgrade-plan.md.
- Status pending → ready; defer: pr3.
- This todo will be picked up when PR3 starts, not during PR2 resolution.
