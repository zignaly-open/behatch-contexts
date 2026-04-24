Changelog
=========

All notable changes to the Zignaly fork of `behatch/contexts` are
recorded here. Format loosely follows [keepachangelog.com](https://keepachangelog.com).

## [Unreleased] — 5.0 development

### Added
- GitHub Actions CI workflow at `.github/workflows/ci.yml` (PHP 8.4
  matrix, SHA-pinned actions, `composer validate` + atoum).
- `rector.php` with PHP 8.4 + Symfony 6.4 sets + code-quality /
  type-declarations / dead-code / early-return prepared sets.
- `docs/solutions/security-issues/symfony-http-foundation-cve-closure-in-php-library.md`
  — first compound-knowledge entry.
- `UPGRADE-5.0.md` — migration guide for consumers.

### Changed
- **Require PHP `^8.4`** (was `>=5.5`).
- **Require Symfony `^6.4.29`** for `property-access`, `http-foundation`,
  `dom-crawler` (was `^2.3 | ^3.0 | ^4.0 | ^5.0 | ^6.0`). Closes
  GHSA-3rg7-wf37-54rm (HIGH PATH_INFO auth bypass) and
  GHSA-mrqx-rp3w-jpjp (LOW open redirect).
- Require `behat/behat ^3.15`, `friends-of-behat/mink-extension ^2.7`,
  `justinrainbow/json-schema ^6.5`.
- Replace `fabpot/goutte` + `behat/mink-goutte-driver` (both abandoned)
  with `behat/mink-browserkit-driver ^2.3` + `symfony/browser-kit ^6.4`
  + `symfony/http-client ^6.4`.
- Bump `atoum/atoum` to `^4.4` (PHP 8.4 compatible).
- Bump `guzzlehttp/guzzle` to `^7.9`.
- Code modernized via Rector (constructor promotion, readonly,
  explicit return types, strict_types declarations). Public API
  unchanged.

### Removed
- `src/HttpCall/Request/Goutte.php` — Goutte alias class.
- `symfony2` session alias in `HttpCall\Request::getClient()` — now
  throws `\InvalidArgumentException` with a migration hint.
- `.travis.yml` — replaced by GitHub Actions.
- `.scrutinizer.yml` — static analysis moves to PHPStan in PR3.
- Legacy `branch-alias: 3.0.x-dev` — now `5.0.x-dev`.

### Security
- See the "Changed" section: both open Dependabot alerts on
  `symfony/http-foundation` close on PR1 merge (the composer.json
  constraint tightening). This 5.0 release is the first with a
  baseline free of known CVEs at release time.

## 4.x and earlier

No changelog was maintained prior to the Zignaly fork. See the upstream
[Behatch/contexts commit history](https://github.com/Behatch/contexts)
for earlier changes.
