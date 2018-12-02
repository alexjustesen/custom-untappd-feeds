# Custom Untappd Feeds
Custom Untappd Feeds is a WordPress plugin that lets you display your Untappd data on your WordPress site. [Donate :beers: or :coffee:](https://ko-fi.com/alexjustesen) to support the plugin.

### Installation

1. Download plugin zip file.
2. Extract folder and contents to wp-content/plugins or upload via the admin panel.
3. Activate the plugin.
4. Follow the directions on the settings page to apply for an Untappd API app.
5. Use the documentation page to configure the shortcodes.

### Change Log

#### v2018.12-beta2 - December 2nd, 2018
* Fixed incorrect transient prefix reference
* Removed duplicate html return

#### v2018.12-beta - November 28th, 2018
* New User Overview shortcode to show the users basic info, badges and recent activity
* Can now set custom api cache timeout
* New transient caching based on md5 of url
* Rewrite to transient handling for cached API calls
* Bumped min WP version to v4.4 to support longer transient names
* UI improvements to the widget header
* UI improvements to the user activity feed widget
* Load Font Awesome from their CDN to reduce plugin size
* Updated version references

#### v2018.11 - November 15th, 2018
* Switched to calendar versioning
* Upgraded Font Awesome to v5.5.0
* Fixed user badge display
* Shortcode UI updates
* Code improvements in the backend
* Documentation updates

#### v0.1.0 - March 26th, 2018
* Initial release, this plugin is still under development. Expect things to change, get added and removed from build to build.
