---
status: pending
priority: p3
issue_id: 'f6'
source: ai
author: 'architecture-strategist'
scope: out_of_scope
tags: [code-review, architecture]
file: null
line: null
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
