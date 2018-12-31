# Custom Untappd Feeds
Custom Untappd Feeds is a WordPress plugin that lets you display your Untappd data on your WordPress site. Includes views for your profile summary (check-in count, unique count, badge count and friend count), recent check-ins and recently earned badges. [Donate :beers: or :coffee:](https://ko-fi.com/alexjustesen) to support the plugin.

### Installation

1. Download plugin zip file.
2. Extract folder and contents to wp-content/plugins or upload via the admin panel.
3. Activate the plugin.
4. Follow the directions on the settings page to apply for an Untappd API app.
5. Use the documentation page to configure the shortcodes.

### Developer

#### Additional Requirements
* Node Package Manager (NPM)

#### Installation
1. Clone repo to `wp-content/plugins`.
2. Run `npm install` from the `custom-untappd-feeds` directory to install plugin dependencies.
3. Activate the plugin.

### Change Log

#### v2019.01-alpha - December 30, 2018
* Added GitHub Plugin Update Checker to auto update from GitHub releases
* Removed admin page reliance on PureCSS
* Overhauled admin pages and moved under single settings menu item
* Can now delete single or all cached items
* Tested through WP v5.0.2
* Upgraded Font Awesome to v5.6.3

#### v2018.12 - December 4th, 2018
* New user overview shortcode to combine the profile summary, recently earned badges and recent check-ins.
* Improved caching and added cache timeout.
* UI improvements to the widget header and recent check-ins.

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
