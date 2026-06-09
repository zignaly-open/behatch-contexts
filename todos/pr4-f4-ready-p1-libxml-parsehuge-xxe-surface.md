---
status: ready
priority: p1
issue_id: 'pr4-f4'
pr: 4
source: ai
author: 'security-sentinel'
scope: in_scope
tags: [code-review, security, defer-pr3]
defer: pr3
file: src/Xml/Dom.php
line: 23
---

## Problem Statement
File: src/Xml/Dom.php:23

## Finding
`$dom->loadXML($content, LIBXML_PARSEHUGE)` with no LIBXML_NONET, no external-entity-loader shim. LIBXML_PARSEHUGE actually WIDENS the DoS/XXE attack surface. `validateXsd`/`validateNg` also pull external schemas. Pre-existing; surfaced in_scope because Rector touched this file.

## Proposed Solution
Deferred to PR3. The plan specifies: install `libxml_set_external_entity_loader(static fn() => null)` in a @BeforeSuite hook, drop LIBXML_PARSEHUGE, add LIBXML_NONET + LIBXML_NO_XXE (on PHP 8.4 with libxml 2.13+). Do not block PR2 merge.

## Acceptance Criteria
- [ ] `libxml_set_external_entity_loader` installed in @BeforeSuite hook
- [ ] LIBXML_PARSEHUGE replaced with LIBXML_NONET + LIBXML_NO_XXE
- [ ] XXE regression test added

## Work Log

### 2026-04-24 — Approved as PR3-deferred
**By:** Claude Triage System
**Actions:**
- Approved during triage but explicitly scoped to PR3 (security audit + hardening phase) per the plan at docs/plans/2026-04-24-refactor-security-php84-symfony64-upgrade-plan.md.
- Status pending → ready; defer: pr3.
- This todo will be picked up when PR3 starts, not during PR2 resolution.
