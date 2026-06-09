---
status: complete
resolved_at: 2026-04-24
priority: p2
issue_id: 'pr4-f13'
pr: 4
source: ai
author: 'pattern-recognition-specialist'
scope: in_scope
tags: [code-review, code-quality]
file: src/
line: 0
---

## Problem Statement
File: src/:0

## Finding
Request::$mink is readonly but structurally-identical BrowserKit::$mink, RestContext::$request, JsonContext::$httpCallResultPool, HttpCallResult::$value are not. Rector promoted some but left others.

## Proposed Solution
Either apply readonly uniformly across these classes, or remove it from Request.php so the whole library is consistent. Fix in PR2 as part of f2 cleanup (re-running Rector with the right set).

## Acceptance Criteria
- [ ] Decision recorded (uniform readonly vs uniform mutable)
- [ ] Rector config updated accordingly
- [ ] All listed classes consistent after fix

## Work Log

### 2026-04-24 — Approved for Work
**By:** Claude Triage System
**Actions:**
- Approved during triage; status pending → ready.
