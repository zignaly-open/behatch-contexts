---
status: ready
priority: p1
issue_id: 'pr4-f3'
pr: 4
source: ai
author: 'security-sentinel'
scope: in_scope
tags: [code-review, security, defer-pr3]
defer: pr3
file: src/Context/SystemContext.php
line: 35
---

## Problem Statement
File: src/Context/SystemContext.php:35

## Finding
`exec($cmd, ...)` runs Gherkin :command verbatim with no escapeshellarg/escapeshellcmd. Pre-existing issue; surfaced as in_scope because Rector modified this file in PR2. Already on PR3's security-audit checklist. Not a PR2 regression.

## Proposed Solution
Deferred to PR3 (security-audit phase). The plan specifies a path-containment helper + `escapeshellarg` wrapping for the `exec()` call site as part of that audit. Do not block PR2 merge on this.

## Acceptance Criteria
- [ ] Path-containment helper implemented per PR3 plan
- [ ] `exec()` call site wraps argument with `escapeshellarg`
- [ ] Security-audit test coverage added

## Work Log

### 2026-04-24 — Approved as PR3-deferred
**By:** Claude Triage System
**Actions:**
- Approved during triage but explicitly scoped to PR3 (security audit + hardening phase) per the plan at docs/plans/2026-04-24-refactor-security-php84-symfony64-upgrade-plan.md.
- Status pending → ready; defer: pr3.
- This todo will be picked up when PR3 starts, not during PR2 resolution.
