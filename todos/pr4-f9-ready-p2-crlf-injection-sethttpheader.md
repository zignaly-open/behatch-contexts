---
status: ready
priority: p2
issue_id: 'pr4-f9'
pr: 4
source: ai
author: 'security-sentinel'
scope: in_scope
tags: [code-review, security, defer-pr3]
defer: pr3
file: src/HttpCall/Request/BrowserKit.php
line: 63
---

## Problem Statement
File: src/HttpCall/Request/BrowserKit.php:63

## Finding
setHttpHeader($name, $value) passes $value unvalidated to setServerParameter. A Gherkin step with $value containing `\r\nInjected-Header: evil` splits the header. Symfony BrowserKit normalizes $_SERVER keys but not values.

## Proposed Solution
Deferred to PR3. The plan specifies a `Behatch\HttpCall\Request\HeaderValidator` (next to its consumer per architecture review) with RFC 7230 token grammar on the name and field-value validation on the value, explicit reject on CR/LF/NUL/obs-fold. Do not block PR2 merge.

## Acceptance Criteria
- [ ] `HeaderValidator` implemented with RFC 7230 token grammar
- [ ] setHttpHeader rejects CR/LF/NUL/obs-fold in values
- [ ] CRLF injection regression test added

## Work Log

### 2026-04-24 — Approved as PR3-deferred
**By:** Claude Triage System
**Actions:**
- Approved during triage but explicitly scoped to PR3 (security audit + hardening phase) per the plan at docs/plans/2026-04-24-refactor-security-php84-symfony64-upgrade-plan.md.
- Status pending → ready; defer: pr3.
- This todo will be picked up when PR3 starts, not during PR2 resolution.
