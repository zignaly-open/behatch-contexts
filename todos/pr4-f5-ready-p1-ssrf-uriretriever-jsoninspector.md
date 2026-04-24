---
status: ready
priority: p1
issue_id: 'pr4-f5'
pr: 4
source: ai
author: 'security-sentinel'
scope: in_scope
tags: [code-review, security, defer-pr3]
defer: pr3
file: src/Json/JsonInspector.php
line: 38
---

## Problem Statement
File: src/Json/JsonInspector.php:38

## Finding
`new SchemaStorage(new UriRetriever, new UriResolver)` resolves $ref from any scheme by default — http, https, file. Malicious feature JSON can $ref http://169.254.169.254/ or file:///etc/passwd. Pre-existing; in_scope because Rector touched this file.

## Proposed Solution
Deferred to PR3. The plan specifies a `SafeUriRetriever` with a schema-root allowlist, injected via a `protected function createSchemaStorage()` override hook on JsonInspector (architecture review #1 from deepen-plan). Do not block PR2 merge.

## Acceptance Criteria
- [ ] `SafeUriRetriever` with schema-root allowlist implemented
- [ ] `createSchemaStorage()` override hook added to JsonInspector
- [ ] SSRF regression test added

## Work Log

### 2026-04-24 — Approved as PR3-deferred
**By:** Claude Triage System
**Actions:**
- Approved during triage but explicitly scoped to PR3 (security audit + hardening phase) per the plan at docs/plans/2026-04-24-refactor-security-php84-symfony64-upgrade-plan.md.
- Status pending → ready; defer: pr3.
- This todo will be picked up when PR3 starts, not during PR2 resolution.
