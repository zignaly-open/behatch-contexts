---
status: complete
resolved_at: 2026-04-24
priority: p2
issue_id: 'pr4-f6'
pr: 4
source: ai
author: 'architecture-strategist'
scope: in_scope
tags: [code-review, architecture]
file: src/HttpCall/Request.php
line: 13
---

## Problem Statement
File: src/HttpCall/Request.php:13

## Finding
Rector-applied `private readonly Mink $mink` on Request.php. Any downstream subclass that overrode the constructor and reassigned $this->mink (legal in 4.x) now throws a fatal at class-load. For dev-master consumers, this is a silent BC break.

## Proposed Solution
Either: (a) remove `readonly` from Request::$mink (accept the modest encapsulation loss), or (b) document explicitly in UPGRADE-5.0.md and leave it (readonly is safer in practice; most subclasses don't need to reassign). Recommend (b) with doc update.

## Acceptance Criteria
- [ ] Decision recorded (keep readonly vs remove)
- [ ] If kept: UPGRADE-5.0.md documents the BC break explicitly
- [ ] If removed: `readonly` dropped from Request::$mink

## Work Log

### 2026-04-24 — Approved for Work
**By:** Claude Triage System
**Actions:**
- Approved during triage; status pending → ready.
