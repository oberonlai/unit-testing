# Unit Testing Plugin

A demo WordPress plugin for testing the plugin development initialization workflow.

## Features

- Custom shortcode: `[unit_testing_demo]`
- REST API endpoint: `/wp-json/unit-testing/v1/demo`
- Custom post type: Demo Items
- Admin menu page
- PSR-4 autoloading ready

## Installation

1. Upload the plugin files to `/wp-content/plugins/unit-testing/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Visit the 'Unit Testing' menu in the admin dashboard

## Usage

### Shortcode

Use the shortcode in any post or page:

```
[unit_testing_demo title="My Title" content="My custom content"]
```

### REST API

Access the demo endpoint:

```
GET /wp-json/unit-testing/v1/demo
```

### Custom Post Type

Create and manage demo items through the WordPress admin.

## Development

This plugin is set up for testing the WordPress plugin development initialization workflow.

## License

GPL v2 or later
