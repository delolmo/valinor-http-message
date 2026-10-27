# Changelog

All notable changes to this project are documented in this file. The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and the project adheres to [Semantic Versioning](https://semver.org/).

## [Unreleased]

### Security

- Require PHP 8.4.27 or later, the release fixing CVE-2026-109618 and CVE-2026-109619.

### Changed

- Require `cuyz/valinor` 2.6 or later and `psr/http-message` 1.1 or later, the lowest versions the test suite runs against.
- `composer.json` declares the MIT license the package already shipped under.

### Fixed

- The README example used a wrong namespace, an undefined variable and `enableFlexibleCasting()`, which Valinor 2 removed in favour of `allowScalarValueCasting()`. It now also states that attributes take precedence over query params.

## [2.3] - 2026-03-20

- Last release before this changelog.

[Unreleased]: https://github.com/delolmo/valinor-http-message/compare/2.3...HEAD
[2.3]: https://github.com/delolmo/valinor-http-message/releases/tag/2.3
