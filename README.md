# Change Log
This is the Maleficarum Auth component.

## [4.0.0] - 2018-09-13
### Changed
- Bump IoC component to version 3.x
- Remove repositories section from composer file

## [3.0.1] - 2017-09-28
### Changed
- Support `Session` for incoming data stage

## [3.0.0] - 2017-08-01
### Changed
- Make use of nullable types provided in PHP 7.1 (http://php.net/manual/en/migration71.new-features.php)

## [2.0.1] - 2017-04-07
### Changed
- Unified method/parameter naming.

## [2.0.0] - 2017-04-07
### Changed
- Removed provider logic from auth initializer and replaced it with project specific implementations of the Provider interface.

## [1.0.1] - 2017-04-06
### Fixed
- A bug that caused the auth initializer to fail for nonexistent auth id values.

## [1.0.0] - 2017-04-05
### Added
- This is an initial release of the component.
