![LHS Restrict Asset Delete](resources/img/icon.png)

# Restrict Asset Delete plugin for Craft CMS 3.x

A Craft CMS plugin to prevent the deletion of a used asset.

## Requirements

This plugin requires Craft CMS 3.0.0 or later.

## Installation

### The easy way

Just install the plugin from the [Craft Plugin Store][craft-plugin-store].

### Using Composer

  - Install with Composer from your project directory: `composer require la-haute-societe/craft-restrict-asset-delete`
  - In the Craft Control Panel, go to Settings → Plugins and click the **Install** button for Restrict Asset Delete plugin.


## Restrict Asset Delete Overview

Want to prevent contributors from deleting a used asset?
This plugin is for you!


## Using Restrict Asset Delete

Once the plugin is activated, any attempt to delete an asset already linked to any entry by an unauthorized user will be refused.

> **Note:**
> The plugin will not prevent linked assets within WYSIWYG editors fields from being deleted.

## Users Restriction

The restriction can be set by using the relevant permission on a group or user level.

> **Note:**
> By default, users with `Admin` permission are allowed to skip the restriction.


Brought to you by [![LHS Logo](resources/img/lhs.png) La Haute Société][lhs-site].

[lhs-site]: https://www.lahautesociete.com
[craft-plugin-store]: https://plugins.craftcms.com
