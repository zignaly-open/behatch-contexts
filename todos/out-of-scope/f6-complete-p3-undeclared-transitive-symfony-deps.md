---
status: complete
priority: p3
issue_id: 'f6'
source: ai
author: 'architecture-strategist'
scope: out_of_scope
tags: [code-review, architecture]
file: null
line: null
resolved_at: 2026-04-24
---

## Problem Statement
File: N/A
behatch uses symfony/browser-kit etc. via Mink but does not declare them in require/require-dev.

## Finding
Pre-existing smell: behatch uses symfony/browser-kit etc. via Mink but does not declare them in require/require-dev. Out of scope for PR1; should be addressed in PR2's modernization.

## Proposed Solution
Defer to PR2. Already tracked in the plan's PR2 composer.json rewrite (adds symfony/browser-kit and symfony/http-client explicitly).

## Acceptance Criteria
- [ ] PR2 plan explicitly lists the transitive Symfony deps to declare
- [ ] Declarations appear in composer.json during PR2 execution
- [ ] `composer validate --strict` passes after PR2 changes

## Work Log

### 2026-04-24 — Resolved in PR #4
**By:** Claude Triage System
**Actions:**
- Already resolved by PR #4 (PR2 of the upgrade series). PR2 commit 8abed63 explicitly added symfony/browser-kit ^6.4 and symfony/http-client ^6.4 to require-dev.
