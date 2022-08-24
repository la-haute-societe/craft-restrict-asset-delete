# Restrict Asset Delete Changelog

## [Unreleased]
### Added
- Add a setting to allow deleting assets only used in revisions
### Fixed
- the `adminCanSkipRestriction` setting was not honored; admin users were always 
  allowed to skip the restriction (thanks [@ryssbowh][], fixes [#6][])


## [1.1.4] - 2021-07-07
- Fix a bug when removing assets from a console command (thanks [@ryssbowh][])


## [1.1.3] - 2021-07-06
### Fixed
- Re-add schemaVersion mistakenly removed in previous release


## [1.1.2] - 2021-06-30
### Changed
- Minor translation changes
### Fixed
- PSR-4 autoloading issue (thanks [@ryssbowh][])
- Change the check to determine if an asset can be deleted to mirror recent
  Craft versions behavior (thanks [@mattcdavis1][])


## [1.1.1] - 2020-18-28
### Fixed
- Renamed folder to comply with psr-4 autoloading standard


## [1.1.0] - 2018-11-22
### Added
- Ability to set the restriction permission per user
- Ability to skip the restriction for Admin users


## [1.0.0] - 2018-10-24
### Added
- Initial release


[@ryssbowh]: https://github.com/ryssbowh
[@mattcdavis1]: https://github.com/mattcdavis1
[#6]: https://github.com/la-haute-societe/craft-restrict-asset-delete/issues/6
[Unreleased]: https://github.com/la-haute-societe/craft-restrict-asset-delete/compare/1.1.4...HEAD
[1.0.0]: https://github.com/la-haute-societe/craft-restrict-asset-delete/releases/tag/1.0.0
[1.1.0]: https://github.com/la-haute-societe/craft-restrict-asset-delete/compare/1.0.0...1.1.0
[1.1.1]: https://github.com/la-haute-societe/craft-restrict-asset-delete/compare/1.1.0...1.1.1
[1.1.2]: https://github.com/la-haute-societe/craft-restrict-asset-delete/compare/1.1.1...1.1.2
[1.1.3]: https://github.com/la-haute-societe/craft-restrict-asset-delete/compare/1.1.2...1.1.3
[1.1.4]: https://github.com/la-haute-societe/craft-restrict-asset-delete/compare/1.1.3...1.1.4
