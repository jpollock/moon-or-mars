# MoonOrMars WordPress Plugin

A cosmic poll plugin that lets users vote on whether they'd prefer to go to the Moon or Mars.

## Description

MoonOrMars is an interactive WordPress plugin that adds a visually stunning poll to your website. The poll asks users a simple but thought-provoking question: "Where would you rather go - the Moon or Mars?"

The plugin features:

- Beautiful space-themed design with cosmic animations
- Interactive voting interface with custom SVG illustrations
- Real-time results display with animated progress bars
- Admin dashboard for viewing and managing vote data
- Support for both shortcode and Gutenberg block implementation
- Vote segmentation for tracking results over time
- Option to allow or restrict multiple votes per user

## Installation

1. Upload the `moon-or-mars` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the 'MoonOrMars' menu in your WordPress admin to configure settings

## Usage

### Shortcode

Add the poll to any post or page using the shortcode:

```
[moon_or_mars]
```

### Gutenberg Block

1. In the block editor, click the '+' button to add a new block
2. Search for "Moon or Mars Poll"
3. Select the block to add it to your content

## Admin Interface

The plugin adds a new top-level menu item called "MoonOrMars" to your WordPress admin. This menu provides access to:

### Dashboard

- View current vote results
- Quick links to other plugin pages
- Usage instructions

### Settings

- Toggle the option to allow multiple votes per user
- Clear votes and create a new vote segment
- View shortcode and block usage instructions

### Vote Data

- View current vote results with detailed statistics
- Browse historical vote segments
- Monitor voting trends over time

## Vote Segmentation

The plugin supports vote segmentation, which allows you to:

1. Clear current votes without losing historical data
2. Create named segments for different time periods or campaigns
3. Compare results across different segments

To create a new segment:

1. Go to MoonOrMars > Settings
2. Enter an optional description for the new segment
3. Click "Clear Votes"

This will close the current segment and create a new one. All previous votes will be preserved and viewable in the Vote Data page.

## Customization

The plugin is designed with a space theme that should work well with most WordPress themes. The responsive design ensures it looks great on all devices.

## FAQ

### Can users vote more than once?

By default, the plugin restricts users to one vote per session. However, you can enable multiple votes per user in the plugin settings.

### How does the plugin track unique voters?

The plugin uses a combination of IP address and session ID to identify unique voters.

### Can I reset the votes?

Yes, you can clear votes at any time from the Settings page. The plugin will create a new vote segment, preserving previous votes for historical reference.

### Is the plugin responsive?

Yes, the plugin is fully responsive and works well on mobile devices, tablets, and desktops.

## Support

If you encounter any issues or have questions about the plugin, please contact us at support@example.com.

## Credits

- Developed by: Cline
- Version: 1.0.0
- License: GPL v2 or later
- License URI: http://www.gnu.org/licenses/gpl-2.0.txt
