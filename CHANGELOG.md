# Changelog

## Unreleased
* Added image size classname to wrapper div.

## [1.2.0]
### Breaking Changes
- Remove heading field, provided from Core in [#53](https://github.com/DekodeInteraktiv/hogan-core/pull/53)
- Heading field has to be added using filter (was default on before).

## [1.1.0]
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
