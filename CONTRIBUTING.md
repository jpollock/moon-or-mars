# Contributing to MoonOrMars

Thank you for considering contributing to the MoonOrMars WordPress plugin! This document provides guidelines and instructions for contributing to this project.

## Development Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/moon-or-mars.git
   cd moon-or-mars
   ```

2. **Set up a local WordPress environment**
   - You can use tools like [Local](https://localwp.com/), [XAMPP](https://www.apachefriends.org/), or [Docker](https://www.docker.com/)
   - Link or copy the plugin directory to your WordPress installation's `wp-content/plugins` directory

3. **Activate the plugin**
   - Log in to your WordPress admin
   - Navigate to Plugins > Installed Plugins
   - Activate "MoonOrMars"

## Coding Standards

This project follows the [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/):

- Use tabs for indentation
- Follow the WordPress PHP Documentation Standards for docblocks
- Use camelCase for JavaScript variables and functions
- Use snake_case for PHP variables and functions
- Prefix all functions, classes, and global variables with `moon_or_mars_`

## Pull Request Process

1. **Fork the repository**
   - Create your own fork of the project
   - Clone your fork locally

2. **Create a feature branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```

3. **Make your changes**
   - Implement your feature or fix
   - Add or update tests as necessary
   - Update documentation to reflect your changes

4. **Commit your changes**
   - Use clear, descriptive commit messages
   - Reference issue numbers in your commit messages when applicable
   ```bash
   git commit -m "Add feature X, resolves #123"
   ```

5. **Push to your fork**
   ```bash
   git push origin feature/your-feature-name
   ```

6. **Submit a pull request**
   - Go to the original repository on GitHub
   - Click "New pull request"
   - Select your fork and branch
   - Fill out the pull request template

## Release Process

The release process is automated using GitHub Actions:

1. **Version Bump**
   - Update the version number in `moon-or-mars.php`
   - Update the changelog in `CHANGELOG.md`

2. **Create a Release**
   - Go to the Releases section on GitHub
   - Click "Draft a new release"
   - Tag version should match the version in `moon-or-mars.php` (e.g., `v1.0.1`)
   - Title the release with the version number
   - Include release notes detailing changes
   - Publish the release

3. **Automated Build**
   - GitHub Actions will automatically:
     - Run tests
     - Create a distribution ZIP file
     - Attach the ZIP to the release

## Testing

Before submitting a pull request, please ensure your code passes all tests:

1. **PHP Linting**
   ```bash
   find . -type f -name "*.php" -not -path "./vendor/*" -print0 | xargs -0 -n1 php -l
   ```

2. **WordPress Coding Standards** (if phpcs is installed)
   ```bash
   phpcs --standard=WordPress wp-content/plugins/moon-or-mars
   ```

3. **Manual Testing**
   - Test your changes in a local WordPress environment
   - Verify functionality in both admin and front-end contexts
   - Test with different WordPress versions if possible

## Questions?

If you have any questions or need help with the contribution process, please open an issue on GitHub.

Thank you for contributing to MoonOrMars!
