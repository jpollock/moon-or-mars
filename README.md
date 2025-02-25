# MoonOrMars WordPress Plugin

![MoonOrMars Banner](https://via.placeholder.com/1200x300/0A1128/FFFFFF?text=MoonOrMars+WordPress+Plugin)

A cosmic poll plugin that lets users vote on whether they'd prefer to go to the Moon or Mars.

## 🚀 Features

- **Interactive Poll**: Beautiful space-themed design with cosmic animations
- **Custom SVG Illustrations**: Handcrafted illustrations of the Moon and Mars
- **Real-time Results**: Animated progress bars show voting results
- **Admin Dashboard**: Comprehensive admin interface for managing votes
- **Vote Segmentation**: Track results over time with vote segments
- **Multiple Vote Control**: Allow or restrict multiple votes per user
- **Gutenberg Block**: Easy integration with the WordPress block editor
- **Shortcode Support**: Use `[moon_or_mars]` to add the poll anywhere

## 📦 Installation

### From GitHub Releases (Recommended)

1. Go to the [GitHub Releases page](https://github.com/yourusername/moon-or-mars/releases)
2. Download the latest release ZIP file
3. In your WordPress admin, go to Plugins > Add New > Upload Plugin
4. Choose the downloaded ZIP file and click "Install Now"
5. Activate the plugin

### Manual Installation

1. Clone this repository
2. Run `zip -r moon-or-mars.zip wp-content/plugins/moon-or-mars` to create a ZIP file
3. Upload and install in WordPress as described above

## 🔄 Automatic Updates

The plugin includes an automatic update mechanism that checks for new releases on GitHub. When a new version is available, you'll see an update notification in your WordPress admin just like with plugins from the WordPress.org repository.

## 🛠️ Development

### Prerequisites

- WordPress development environment
- PHP 7.2 or higher
- Basic knowledge of WordPress plugin development

### Setup for Development

1. Clone this repository
2. Link or copy the `wp-content/plugins/moon-or-mars` directory to your WordPress installation's plugins directory
3. Activate the plugin in WordPress

### Build Process

This repository includes GitHub Actions workflows that automatically:

1. Run PHP linting
2. Create a distribution ZIP file
3. Attach the ZIP to GitHub releases

To create a new release:

1. Update the version number in `wp-content/plugins/moon-or-mars/moon-or-mars.php`
2. Update the changelog in `CHANGELOG.md`
3. Create a new release on GitHub with the tag matching the version number (e.g., `v1.0.1`)

## 📚 Documentation

- [User Guide](wp-content/plugins/moon-or-mars/USER-GUIDE.md): Detailed instructions for end users
- [Contributing Guide](CONTRIBUTING.md): Guidelines for contributing to the project
- [Changelog](CHANGELOG.md): History of changes and updates

## 🤝 Contributing

Contributions are welcome! Please see the [CONTRIBUTING.md](CONTRIBUTING.md) file for guidelines.

## 📄 License

This project is licensed under the GPL v2 or later - see the [LICENSE](LICENSE) file for details.

## 👥 Credits

- Developed by: Cline
- Version: 1.0.0
