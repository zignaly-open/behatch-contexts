---
status: pending
priority: p1
issue_id: 'f2'
source: ai
author: 'architecture-strategist'
scope: out_of_scope
tags: [code-review, documentation]
file: null
line: null
---

## Problem Statement
File: N/A
Dropping Symfony 2/3/4/5 support is a BC break in the library's public dependency contract, yet no UPGRADE entry or CHANGELOG entry documents this.

## Finding
Dropping Symfony 2/3/4/5 support is a BC break in the library's public dependency contract. Repo already has UPGRADE-3.0.md and UPGRADE-4.0.md but no entry for this change. No CHANGELOG.md exists.

## Proposed Solution
Add a brief UPGRADE note (or create CHANGELOG.md) stating: new Symfony floor, security rationale (link GHSA IDs), downstream action required if they pinned Symfony <6.4.

## Acceptance Criteria
- [ ] UPGRADE note (or CHANGELOG.md) exists describing the Symfony floor raise
- [ ] Note links relevant GHSA IDs for the security rationale
- [ ] Downstream action guidance included for users pinned to Symfony <6.4
