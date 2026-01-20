# Release Guide

This project uses GitHub Actions to automatically create releases.

## 📋 Release Process

### 1. Update Version Number

Update the version number in your main plugin file:

```php
/**
 * Version: v1.0.0  // Update this
 */
```

### 2. Commit Changes

```bash
git add .
git commit -m "chore: bump version to v1.0.0"
git push origin main
```

### 3. Create and Push Tag

```bash
# Create tag (version must match the one in plugin file)
git tag v1.0.0

# Push tag to GitHub
git push origin v1.0.0
```

### 4. Automatic Build

When you push a tag, GitHub Actions will automatically:
1. ✅ Run tests on multiple PHP versions
2. ✅ Install production dependencies (`composer install --no-dev`)
3. ✅ Copy necessary plugin files
4. ✅ Create ZIP file with production dependencies
5. ✅ Generate changelog
6. ✅ Create GitHub Release
7. ✅ Upload ZIP file to release

### 5. Check Release

Go to your GitHub repository's Releases page:
```
https://github.com/YOUR-USERNAME/unit-testing/releases
```

You will see the new release with:
- 📦 Downloadable ZIP file
- 📝 Auto-generated changelog
- 📄 Installation instructions

## 🔍 View Build Status

You can view the build progress on the GitHub Actions page:
```
https://github.com/YOUR-USERNAME/unit-testing/actions
```

## 🛠️ Local Testing

If you want to test the build process locally, run:

```bash
composer build
```

This will create a ZIP file in the `build/` directory.

## 📌 Important Notes

1. **Version Format**: Tags must start with `v`, e.g., `v1.0.1`
2. **Version Consistency**: Tag version should match the version in your plugin file
3. **Vendor Directory**: Not committed to Git, but automatically included in release ZIP
4. **Test Suite**: Release ZIP does not include PHPUnit and other dev dependencies

## 🚀 Quick Release Commands

```bash
# Complete all steps at once
VERSION="v1.0.0"

# After updating version number:
git add .
git commit -m "chore: bump version to ${VERSION}"
git push origin main
git tag ${VERSION}
git push origin ${VERSION}
```

## 🔄 Delete Incorrect Release

If you need to delete an incorrect tag:

```bash
# Delete local tag
git tag -d v1.0.0

# Delete remote tag
git push origin :refs/tags/v1.0.0
```

Then manually delete the corresponding release on GitHub.

## 📦 What's Included in Release

The release ZIP file includes:
- ✅ All plugin files
- ✅ Production dependencies (e.g., vendor libraries)
- ❌ No test files
- ❌ No development dependencies
- ❌ No Git-related files
- ❌ No build scripts

## 🎯 Release Checklist

Before creating a release:
- [ ] Update version number in plugin file
- [ ] Update changelog/readme if needed
- [ ] Run tests locally: `composer test`
- [ ] Test build locally: `composer build`
- [ ] Commit all changes
- [ ] Create and push tag
- [ ] Verify GitHub Actions completes successfully
- [ ] Test the release ZIP file

## 🔧 Customizing the Build

To customize what's included in the release, edit:
- `.github/workflows/release.yml` - GitHub Actions workflow
- `scripts/build.php` - Local build script

Both files have an `--exclude` list where you can add or remove files/directories.
