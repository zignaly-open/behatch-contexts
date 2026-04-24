---
status: pending
priority: p2
issue_id: 'f3'
source: ai
author: 'security-sentinel'
scope: out_of_scope
tags: [code-review, security]
file: composer.json
line: null
---

## Problem Statement
File: composer.json
A downstream root project that explicitly pins an older symfony/http-foundation could defeat this library's ^6.4.29 require. A conflict block would harden this.

## Finding
A downstream root project that explicitly pins 'symfony/http-foundation: ^6.4.0' would defeat this library's ^6.4.29 require. Adding 'conflict: { symfony/http-foundation: <6.4.29 }' survives transitive resolution more robustly.

## Proposed Solution
Optional: add conflict block on symfony/http-foundation <6.4.29 (and maybe <5.4.50 || <7.1.7 for belt-and-suspenders across all patched lines).

## Acceptance Criteria
- [ ] Decision made on whether to add `conflict` block
- [ ] If added: `conflict` entry present in composer.json covering vulnerable ranges
- [ ] `composer validate` passes and dependency resolution still succeeds in a sandbox install
