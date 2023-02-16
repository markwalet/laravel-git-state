# Changelog

## [Unreleased](https://github.com/markwalet/laravel-git-state/compare/v1.7.0...master)

## [v1.7.0 (2022-04-22)](https://github.com/markwalet/laravel-git-state/compare/v1.6.1...v1.7.0)

### Added
- Added support for Laravel 10
- Added support for PHP 8.2

### Removed
- Removed support for PHP 7.4
- Removed support for Laravel 6

## [v1.6.1 (2022-04-22)](https://github.com/markwalet/laravel-git-state/compare/v1.6.0...v1.6.1)

### Fixed
- Moved path assertion out of constructor for the git drivers.

## [v1.6.0 (2022-02-05)](https://github.com/markwalet/laravel-git-state/compare/v1.5.1...v1.6.0)

### Added
- Added Laravel 9 support.

## [v1.5.1 (2021-12-15)](https://github.com/markwalet/laravel-git-state/compare/v1.5.0...v1.5.1)

### Fixed
- Removed typo in readme.

## [v1.5.0 (2021-12-15)](https://github.com/markwalet/laravel-git-state/compare/v1.4.1...v1.5.0)

### Added
- Added PHP 8.1 support. ([#18](https://github.com/markwalet/laravel-git-state/issues/18))
- Improved code coverage.

### Changed
- Used [`webmozart/assert`](https://github.com/webmozarts/assert) instead of custom logic to reduce complexity.
- Simplified exception code style.

## [v1.4.1 (2020-10-19)](https://github.com/markwalet/laravel-git-state/compare/v1.4.0...v1.4.1)

### Added
- Added PHP 8.0 support
- Added PHP 7.4 support in combination with Laravel 6.

### Removed
- Removed PHP 7.3 support

## [v1.4.0 (2020-09-23)](https://github.com/markwalet/laravel-git-state/compare/v1.3.0...v1.4.0)

### Added
- Added a `latestCommitHash()` method to the `GitDriver` interface.
- Added Laravel 8 support.

### Removed
- Removed Laravel integration in `GitStateManager` tests. ([#12](https://github.com/markwalet/laravel-git-state/issues/12))

## [v1.3.0 (2020-03-24)](https://github.com/markwalet/laravel-git-state/compare/v1.2.0...v1.3.0)

### Added
- Added Github Actions integration.
- Added PHP 7.4 support.
- Added a `.gitattributes` file to shrink down releases.
 
### Removed
- Removed support for Laravel 5.
- Removed support for PHP 7.1
- Removed Travis integration.

## [v1.2.0 (2020-03-12)](https://github.com/markwalet/laravel-git-state/compare/v1.1.0...v1.2.0)

### Added
- Add support for Laravel 7. ([#9](https://github.com/markwalet/laravel-git-state/issues/9))

## [v1.1.0 (2019-10-10)](https://github.com/markwalet/laravel-git-state/compare/v1.0.6...v1.1.0)

### Added
- Added Codecov integration.
- Added support for Laravel 6. ([#8](https://github.com/markwalet/laravel-git-state/issues/8))

### Removed
- Removed Coveralls integration.

## [v1.0.6 (2019-08-13)](https://github.com/markwalet/laravel-git-state/compare/v1.0.5...v1.0.6)

### Fixed
- Fixed merge key for configuration file.

## [v1.0.5 (2019-08-13)](https://github.com/markwalet/laravel-git-state/compare/v1.0.4...v1.0.5)

### Fixed
- Fixed Composer auto-loading of service provider.

## [v1.0.4 (2019-08-06)](https://github.com/markwalet/laravel-git-state/compare/v1.0.3...v1.0.4)

### Changed
- Renamed `Git` to `GitState`.

## [v1.0.3 (2019-08-05)](https://github.com/markwalet/laravel-git-state/compare/v1.0.2...v1.0.3)

### Added
- Added DocBlock for git manager.
- Added a facade.

## [v1.0.2 (2019-08-05)](https://github.com/markwalet/laravel-git-state/compare/v1.0.1...v1.0.2)

### Fixed
- Fix failing tests.
- Improved code coverage.

### Removed
- Removed redundant clover call in CI.

## [v1.0.1 (2019-08-02)](https://github.com/markwalet/laravel-git-state/compare/v1.0.0...v1.0.1)

### Added
- Added a readme

### Fixed
- Fixed integration tests in CI.
- Fixed configuration loading.
