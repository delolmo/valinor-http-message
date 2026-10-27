# Changelog

All notable changes to this project are documented in this file. The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and the project adheres to [Semantic Versioning](https://semver.org/).

## [Unreleased]

## [2.6.1] - 2026-10-27

### Changed

- Same code as 2.6.0, republished from a history without the `.claude/` directory. 2.6.0 is withdrawn: its tag was moved after Packagist published it, and Packagist keeps published versions immutable.
- `.claude/` is ignored.

## [2.6.0] - 2026-10-27 [YANKED]

### Security

- Require PHP 8.4.27 or later on 8.4 and 8.5.12 or later on 8.5, the releases fixing CVE-2026-109618 and CVE-2026-109619.

### Changed

- Require `cuyz/valinor` 2.6 or later and `psr/http-message` 1.1 or later, the lowest versions the test suite runs against.
- `composer.json` declares the MIT license the package already shipped under.

### Fixed

- The README example used a wrong namespace, an undefined variable and `enableFlexibleCasting()`, which Valinor 2 removed in favour of `allowScalarValueCasting()`. It now also states that attributes take precedence over query params.

## [2.3] - 2026-03-20

- Last release before this changelog.

[Unreleased]: https://github.com/delolmo/valinor-http-message/compare/2.6.1...HEAD
[2.6.1]: https://github.com/delolmo/valinor-http-message/compare/2.3...2.6.1
[2.3]: https://github.com/delolmo/valinor-http-message/releases/tag/2.3
