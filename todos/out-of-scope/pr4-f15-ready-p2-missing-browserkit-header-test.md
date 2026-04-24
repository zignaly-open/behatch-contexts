---
status: ready
priority: p2
issue_id: 'pr4-f15'
pr: 4
source: ai
author: 'architecture-strategist (H2)'
scope: out_of_scope
tags: [code-review, testing, defer-pr3]
defer: pr3
file: null
line: null
---

## Problem Statement
File: N/A

## Finding
The Goutte→BrowserKit cutover removed the `method_exists($client, 'setHeader')` branch. Under Symfony BrowserKit HttpBrowser, only whitelisted $_SERVER keys propagate to outbound symfony/http-client requests. A custom header like `X-Foo` may not actually reach the wire. No test asserts this.

## Proposed Solution
Add tests/units/HttpCall/BrowserKit.php with a round-trip test: set a custom header via setHttpHeader, send a request to a mock endpoint, assert the header is received on the wire. Fix in PR2 or PR3 — reasonable either way.

## Acceptance Criteria
- [ ] tests/units/HttpCall/BrowserKit.php integration test added
- [ ] Test asserts custom header round-trips via BrowserKit
- [ ] Test runs in CI

## Work Log

### 2026-04-24 — Approved as PR3-deferred
**By:** Claude Triage System
**Actions:**
- Approved during triage but explicitly scoped to PR3 (security audit + hardening phase) per the plan at docs/plans/2026-04-24-refactor-security-php84-symfony64-upgrade-plan.md.
- Status pending → ready; defer: pr3.
- This todo will be picked up when PR3 starts, not during PR2 resolution.
