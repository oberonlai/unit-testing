# WordPress Plugin Unit Testing Guide

This project uses PHPUnit and the WordPress testing framework for unit testing.

## Prerequisites

- PHP >= 8.0
- MySQL/MariaDB
- Composer
- SVN (for downloading WordPress testing framework)

## Quick Start

### 1. Install Testing Environment (One-time Setup)

```bash
composer test:install
```

This command will:
- ✅ Create test database `wordpress_test`
- ✅ Download WordPress core files to `/tmp/wordpress`
- ✅ Download WordPress testing framework to `/tmp/wordpress-tests-lib`
- ✅ Configure testing environment

**Note:**
- Default database name: `wordpress_test`
- Default database user: `root`
- Default database password: (empty)
- Default database host: `localhost`

If your database settings are different, modify the `test:install` command in `composer.json`.

### 2. Run Tests

```bash
composer test
```

This will run all tests in the `tests/` directory.

## Test File Structure

```
tests/
├── bootstrap.php          # Test bootstrap file
└── test-sample.php        # Sample test file
```

## Writing Tests

### Basic Test Example

Create a test file in `tests/`, for example `test-my-feature.php`:

```php
<?php
/**
 * Class MyFeatureTest
 *
 * @package Unit Testing
 */

class MyFeatureTest extends WP_UnitTestCase {

    /**
     * Test basic functionality
     */
    public function test_basic_functionality() {
        // Arrange
        $expected = 'Hello World';
        
        // Act
        $actual = my_function();
        
        // Assert
        $this->assertEquals( $expected, $actual );
    }
    
    /**
     * Test WordPress integration
     */
    public function test_wordpress_integration() {
        // Create test post
        $post_id = $this->factory->post->create([
            'post_title' => 'Test Post',
            'post_status' => 'publish'
        ]);
        
        // Assert post was created
        $this->assertNotEmpty( $post_id );
        
        // Get post and verify
        $post = get_post( $post_id );
        $this->assertEquals( 'Test Post', $post->post_title );
    }
}
```

## Common Test Methods

### Assertion Methods

```php
// Equality tests
$this->assertEquals( $expected, $actual );
$this->assertNotEquals( $expected, $actual );

// Boolean tests
$this->assertTrue( $condition );
$this->assertFalse( $condition );

// Empty tests
$this->assertEmpty( $value );
$this->assertNotEmpty( $value );

// Contains tests
$this->assertContains( $needle, $haystack );
$this->assertNotContains( $needle, $haystack );

// Array key tests
$this->assertArrayHasKey( 'key', $array );
```

### WordPress Test Factories

```php
// Create test post
$post_id = $this->factory->post->create();

// Create test user
$user_id = $this->factory->user->create([
    'role' => 'administrator'
]);

// Create test term
$term_id = $this->factory->term->create([
    'taxonomy' => 'category',
    'name' => 'Test Category'
]);
```

## Test Best Practices

### 1. Test Naming Convention

- Test file name: `test-{feature-name}.php`
- Test class name: `{FeatureName}Test`
- Test method name: `test_{what_it_tests}`

### 2. Test Structure (AAA Pattern)

```php
public function test_example() {
    // Arrange - Prepare test data
    $input = 'test';
    
    // Act - Execute the functionality
    $result = my_function( $input );
    
    // Assert - Verify the result
    $this->assertEquals( 'expected', $result );
}
```

### 3. Using setUp and tearDown

```php
class MyTest extends WP_UnitTestCase {
    
    protected $test_user_id;
    
    /**
     * Runs before each test method
     */
    public function setUp(): void {
        parent::setUp();
        $this->test_user_id = $this->factory->user->create();
    }
    
    /**
     * Runs after each test method
     */
    public function tearDown(): void {
        wp_delete_user( $this->test_user_id );
        parent::tearDown();
    }
}
```

## Running Specific Tests

```bash
# Run specific test file
phpunit tests/test-my-feature.php

# Run specific test method
phpunit --filter test_specific_method

# Show verbose output
phpunit --verbose
```

## Test Coverage

If you want to see test coverage, you need to install Xdebug:

```bash
# Run tests and generate coverage report
phpunit --coverage-html coverage
```

The report will be generated in the `coverage/` directory.

## Troubleshooting

### Issue: phpunit command not found

**Solution:**
```bash
# Ensure dev dependencies are installed
composer install

# Use full path
./vendor/bin/phpunit
```

### Issue: Database connection failed

**Solution:**
1. Verify MySQL is running
2. Check database credentials are correct
3. Re-run `composer test:install`

### Issue: Test environment files not found

**Solution:**
```bash
# Clean old test environment
rm -rf /tmp/wordpress /tmp/wordpress-tests-lib

# Reinstall
composer test:install
```

## Resources

- [WordPress Plugin Unit Tests](https://make.wordpress.org/cli/handbook/misc/plugin-unit-tests/)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [WordPress Testing Handbook](https://make.wordpress.org/core/handbook/testing/automated-testing/phpunit/)

## CI/CD Integration

This project includes GitHub Actions for automated testing. Tests run automatically on every Pull Request.

See `.github/workflows/release.yml` for details.
