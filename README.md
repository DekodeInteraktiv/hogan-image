# Image Module for [Hogan](https://github.com/dekodeinteraktiv/hogan-image) [![Build Status](https://travis-ci.org/DekodeInteraktiv/hogan-image.svg?branch=master)](https://travis-ci.org/DekodeInteraktiv/hogan-image)

## Installation
Install the module using Composer `composer require dekodeinteraktiv/hogan-image` or simply by downloading this repository and placing it in `wp-content/plugins`

## Available filters
### Admin
- `hogan/module/image/image_size/choices` : Image size choices for image size field.
Default (will be merged with return filter return values):
```php
[
    'thumbnail' => _x( 'Small', 'Image Size', 'hogan-image' ),
    'medium'    => _x( 'Medium', 'Image Size', 'hogan-image' ),
    'large'     => _x( 'Large', 'Image Size', 'hogan-image' ),
]
```
- `hogan/module/image/image_size/constraints` : Image constraints for image size field.
Default (will be merged with return filter return values):
```php
[
    'min_width'  => '',
    'min_height' => '',
    'max_width'  => '',
    'max_height' => '',
    'min_size'   => '',
    'max_size'   => '',
    'mime_types' => '',
]
```
- `hogan/module/image/image_size/preview_size` : Admin preview size of uploaded image. Default: 'medium'
- `hogan/module/image/image_size/library` : Admin media library choice. Default: 'all'

### Template
- `hogan/module/image/figure_classes` : Add classes names to the figure tag. Default: `wp-caption` and `size-{thumbnail|medium|large}`.
- `hogan/module/image/figure_caption_classes` : Add classes names to the figure tag. Default: `wp-caption-text`.
- `hogan/module/image/image/args` : Attributes for the image markup.
- `hogan/module/image/template/caption` : Filter to change caption content. Defaults to the text inserted in the caption field in admin.
- 'hogan/module/image/figure_before_content' : Action hooks to inject content inside the figure element before the image.
- 'hogan/module/image/figure_after_content' : Action hooks to inject content inside the figure element after the image.
