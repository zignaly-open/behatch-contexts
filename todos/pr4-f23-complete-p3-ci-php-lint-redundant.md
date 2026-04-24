---
status: complete
resolved_at: 2026-04-24
priority: p3
issue_id: 'pr4-f23'
pr: 4
source: ai
author: 'code-simplicity-reviewer'
scope: in_scope
tags: [code-review, ci]
file: .github/workflows/ci.yml
line: 43
---

## Problem Statement
File: .github/workflows/ci.yml:43

## Finding
atoum loads every src/ and tests/units/ file at startup; any parse error surfaces there. Rector's AST parse also catches syntax errors. `php -l` across all files adds N process spawns for zero additional coverage.

## Proposed Solution
Drop the `Lint PHP` step. Fix in PR2 (trivial).

## Acceptance Criteria
- [ ] `Lint PHP` step removed from ci.yml
- [ ] CI runtime reduced
- [ ] All other checks still pass

## Work Log

### 2026-04-24 — Approved for Work
**By:** Claude Triage System
**Actions:**
- Approved during triage; status pending → ready.
