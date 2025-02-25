# MoonOrMars WordPress Plugin - User Guide

This comprehensive guide will help you get the most out of the MoonOrMars WordPress plugin.

## Table of Contents

1. [Introduction](#introduction)
2. [Installation](#installation)
3. [Adding the Poll to Your Site](#adding-the-poll-to-your-site)
4. [Admin Interface](#admin-interface)
5. [Settings Configuration](#settings-configuration)
6. [Vote Data Management](#vote-data-management)
7. [Troubleshooting](#troubleshooting)

## Introduction

MoonOrMars is an interactive WordPress plugin that adds a visually stunning poll to your website. The poll asks users a simple but thought-provoking question: "Where would you rather go - the Moon or Mars?"

The plugin features a beautiful space-themed design with cosmic animations, real-time results display, and comprehensive admin tools for managing votes.

## Installation

### Requirements

- WordPress 5.2 or higher
- PHP 7.2 or higher

### Installation Steps

1. Download the plugin zip file
2. Log in to your WordPress admin panel
3. Navigate to Plugins > Add New
4. Click the "Upload Plugin" button at the top of the page
5. Choose the downloaded zip file and click "Install Now"
6. After installation, click "Activate Plugin"

Alternatively, you can manually upload the plugin:

1. Unzip the plugin file
2. Upload the `moon-or-mars` folder to your `/wp-content/plugins/` directory via FTP
3. Activate the plugin through the 'Plugins' menu in WordPress

## Adding the Poll to Your Site

### Using the Shortcode

The simplest way to add the poll to any post or page is by using the shortcode:

```
[moon_or_mars]
```

Simply insert this shortcode into any post or page content where you want the poll to appear.

### Using the Gutenberg Block

If you're using the WordPress block editor (Gutenberg):

1. Edit the post or page where you want to add the poll
2. Click the "+" button to add a new block
3. Search for "Moon or Mars Poll" in the block inserter
4. Select the block to add it to your content
5. Save or update your post/page

The block will display a preview in the editor, and the full interactive poll will appear on the front-end of your site.

## Admin Interface

After activating the plugin, you'll find a new menu item called "MoonOrMars" in your WordPress admin sidebar. This menu provides access to three main sections:

### Dashboard

The dashboard provides an overview of the plugin's functionality and current vote statistics. Here you can:

- View current vote results with percentages and vote counts
- Access quick links to other plugin pages
- Read basic usage instructions

### Settings

The Settings page allows you to configure how the plugin works. Options include:

- **Allow Multiple Votes**: Toggle whether users can vote multiple times in the same session
- **Clear Votes**: Create a new vote segment and archive current votes
- **Usage Instructions**: View shortcode and block usage instructions

### Vote Data

The Vote Data page provides detailed analytics on voting patterns. Here you can:

- View current vote results with detailed statistics
- Browse historical vote segments
- Monitor voting trends over time

## Settings Configuration

### Allow Multiple Votes

By default, the plugin restricts users to one vote per session. To allow multiple votes:

1. Go to MoonOrMars > Settings
2. Toggle the "Allow Multiple Votes" switch to the on position
3. Click "Save Settings"

When this option is enabled, users can vote multiple times without restrictions.

### Vote Segmentation

The plugin supports vote segmentation, which allows you to create distinct voting periods without losing historical data.

To create a new segment:

1. Go to MoonOrMars > Settings
2. In the "Clear Votes" section, enter an optional description for the new segment (e.g., "Summer Campaign 2025")
3. Click the "Clear Votes" button
4. Confirm the action in the popup dialog

This will:
- Close the current segment and record its end date
- Create a new active segment
- Preserve all previous votes for historical reference
- Reset the current vote count to zero

You can view all segments and their vote data on the Vote Data page.

## Vote Data Management

The Vote Data page provides comprehensive analytics on voting patterns:

### Current Results

The top section displays the current active segment's results, including:

- Percentage and vote count for Moon
- Percentage and vote count for Mars
- Total number of votes

### Historical Segments

The bottom section displays a table of all vote segments, including:

- Segment ID
- Description (if provided)
- Start and end dates
- Vote counts and percentages for each option
- Total votes per segment

This historical data is automatically refreshed every 30 seconds, or you can manually refresh the page to see the latest data.

## Troubleshooting

### Common Issues

#### The poll is not displaying on my site

- Ensure the plugin is activated
- Check that you've correctly added the shortcode `[moon_or_mars]` or the Gutenberg block
- Verify that your theme is not hiding the poll with CSS

#### Users report they cannot vote

- Check if the "Allow Multiple Votes" setting is disabled and users have already voted
- Ensure your server has session support enabled
- Verify that your site is not using aggressive caching that might interfere with the voting process

#### The admin pages are not styled correctly

- Try refreshing the page while holding the Shift key (hard refresh)
- Check if your browser has disabled CSS for your admin area
- Ensure no other plugins are conflicting with the MoonOrMars admin styles

### Getting Support

If you encounter any issues not covered in this guide, please contact us at support@example.com with the following information:

- WordPress version
- PHP version
- List of active plugins
- Description of the issue
- Screenshots (if applicable)

## Customization for Developers

Advanced users and developers can customize the plugin by modifying the CSS files:

- Admin styles: `wp-content/plugins/moon-or-mars/admin/css/moon-or-mars-admin.css`
- Public styles: `wp-content/plugins/moon-or-mars/public/css/moon-or-mars-public.css`

Note: Custom modifications may be overwritten when the plugin is updated. Consider creating a child theme or custom plugin for permanent customizations.
