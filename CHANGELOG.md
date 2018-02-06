# Changelog

## [Unreleased]
### Breaking Change
* Heading classname changed from `.heading` to `.hogan-heading`
* Deprecated `hogan/module/image/attachment/attr` filter in favor of `hogan/module/image/image/args`

### Internal
* Added filter `hogan/module/image/image/args` to filter image arguments
* Use `hogan_classnames` to join classnames together
* Use `caption` core component to print out caption.
* Make all code validate with PHPCS rules.
* Switch from `radio` to `button_group` field to select size.
* Added TravisCi config.
