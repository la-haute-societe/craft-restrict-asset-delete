# Restrict Asset Delete plugin for Craft CMS

A Craft CMS plugin to prevent the deletion of a used asset.


## Requirements

This plugin requires Craft CMS 4.0.0 or later. Version 1.x of this plugin supports Craft CMS 3.x.


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

## Admin Restriction 

You can determine if `Admin` users can skip the restriction by going to  Settings → Restrict Asset Delete.

You can also copy and modify the plugin `config.php` file to `craft/config` as `restrict-asset-delete.php` to override that behavior.

> **Note:**
> By default, users with `Admin` permission are **not** allowed to skip the restriction.


Brought to you by
<a href="https://www.lahautesociete.com" target="_blank"><br><img src=".readme/logo-lahautesociete.png" height="100" alt="Logo La Haute Société" /></a>

[craft-plugin-store]: https://plugins.craftcms.com
