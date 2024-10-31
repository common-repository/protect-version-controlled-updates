=== Protect Version Controlled Updates ===
Contributors: RobertGillmer
Tags: prevent updates, version control, git
Requires at least: 4.2
Tested up to: 4.5.2
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin warns or prevents users from updating plugins on a Git version-controlled server.

== Description ==

This plugin is built to be used on production servers which are version-controlled with Git or SVN.  If plugins or themes are updated directly on production, they can get out of sync with the repo, and later pushes to the server might "roll back" plugin or theme updates which weren't committed to the repo.

Upon activation, the plugin looks in specific spots for .git or .svn folders and creates settings automatically.  These settings can be modified through this plugin's Settings screen.

Users who try to update a plugin via the Plugins screen or try to update a theme via the Updates screen, will get a modal window asking for confirmation.  Admins can also block updates entirely, so users will still get the modal window but will only have a cancel button.

The modal title and modal content are admin-configurable through the options page.

Please understand, we're *not* advocating *not* updating plugins.  You should still update all the things with the quickness.  Just do it in the repo and push the changes to the server.


== Installation ==

If you're running a version-controlled environment, I'm pretty sure that installing plugins is old hat to you.  But just in case...

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress.
1. Use the Settings->PVCU Options screen to configure the plugin.

== Frequently Asked Questions ==

= Does this auto-detect if I have a Git or SVN version-controllled server? =

This plugin looks in all the normal spots for .git and/or .svn folders - the root, the wp-content folder, the plugins folder, the themes folder, and even in the current theme and the parent theme (if applicable).

= If it doesn't autodetect my installation, what then? =

You can manually turn on the protection from the options screen.

= Can I turn the protection off? =

You can turn protection off individually for either plugins or themes.

= Which pages are protected? =

The plugins page (plugins.php), the plugin install page (plugin-install.php), and the general updates page (update-core.php).  Future versions will protect the themes page (themes.php).

= I can still update my theme from the Themes page, even with protection.  What gives? =

That's a known issue. Future versions will protect theme updates from the Themes screen.

= Does this protect plugin or theme deletion? =

Not at this time, but that's planned for a future version.

= Does this protect core? =

Not at this time, but that's planned for a future version.

== Screenshots ==

1. The modal title and description are user-changable.  Note that both the plugins and themes are set to "warn."
2. The actual modal.  Note that there's a cancel button and an update button.
3. Setting both plugins and themes to "block."
4. The actual modal, now with only a cancel button.

== Changelog ==

= 1.1 =
* Extensive refactoring of functions to allow for separate choices for plugins, themes, and core (upcoming release).
* Removed the checkbox to disable protection.
* Merged the protection disabling into the radio button choices for plugins and for themes.
* U	

= 1.0 =
* Initial release