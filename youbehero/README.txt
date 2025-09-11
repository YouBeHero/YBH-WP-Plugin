=== YouBeHero ===
Contributors: youbehero
Donate link: https://youbehero.com/
Tags: woocommerce, donations, charity, nonprofit, checkout
Requires at least: 5.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Enable donations in WooCommerce checkout and product pages with customizable widgets, shortcodes, and API-powered settings.

== Description ==

**YouBeHero** is a powerful WordPress plugin that seamlessly integrates with WooCommerce, allowing store owners to enable a donation system on checkout and product pages. Customers can easily contribute to nonprofit organizations during their shopping experience.

With dynamic widgets, shortcodes, and API-powered configurations, YouBeHero ensures a customizable and smooth donation process. Store owners can manage supported organizations, track donations, and display impact statistics directly in their WordPress dashboard.

### Features
* Add donation options to WooCommerce checkout and product pages.
* Let customers support nonprofit organizations while shopping.
* Configure donations dynamically via API.
* Widgets and shortcodes for flexible display.
* Customizable donation amounts and presentation.
* Dashboard view of donation data and statistics.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/youbehero/` directory, or install the plugin through the WordPress Plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Navigate to **WooCommerce → YouBeHero Settings** to configure your API key and set up donation preferences.
4. Optionally, add donation widgets or shortcodes (`[youbehero_donation]`) to display donation forms on other pages.

== External services ==

Privacy and data handling

This plugin integrates your WooCommerce store with the YouBeHero platform to facilitate
charitable donations and related features. Below is an overview of what data is shared and
why.

Data shared with YouBeHero
When using this plugin, the following information is transmitted to YouBeHero’s servers:

* API key: Used to securely connect your store to your YouBeHero account to record and track donations
* WooCommerce order ID: For accurate donation-to-order association and tracking
* User ID: To identify the donor and associate their donation details to their purchase
* Purchase amount: The total cart value for transaction recording and donation integration
* Donation amount: The exact donated sum to ensure correct processing and allocation to the designated charity
* Selected organization: To determine the destination of the donation

Why this data is collected
This data is necessary to:

* Register and authenticate your store with YouBeHero
* Process and record donations made through your checkout
* Display donation widgets and campaign information to shoppers
* Provide donation reporting and analytics within your WordPress admin

Important notes

* No payment details are sent to YouBeHero
* Only donation metadata and order references are shared
* All data is transmitted securely via HTTPS

**Callback URL handling:**
The YouBeHero service may redirect administrators to a callback URL inside the WordPress admin (e.g., `wp-admin/admin.php?page=youbehero-settings&api_token=xxxxx`). This URL automatically configures the API token. Only users with administrator permissions can access this page, and the token is sanitized before storage. Since this request originates from a trusted external service, a WordPress nonce cannot be applied.

External service: **YouBeHero**
- Website: [https://dev.youbehero.com](https://dev.youbehero.com)
- Terms of Service: [https://dev.youbehero.com/gr/termsbusiness](https://dev.youbehero.com/gr/termsbusiness)
- Privacy Policy: [https://dev.youbehero.com/gr/privacy](https://dev.youbehero.com/gr/privacy)

== Frequently Asked Questions ==

= Does this plugin require WooCommerce? =
Yes, WooCommerce must be installed and active for YouBeHero to work.

= Can customers choose the donation amount? =
Yes, you can configure preset donation amounts, and customers can also enter their own preferred amount.

= Can I show donations outside checkout? =
Yes, YouBeHero includes widgets and shortcodes to place donation options on product pages or other areas.

= Does this plugin support multiple organizations? =
Yes, you can configure multiple nonprofit organizations via API.

== Screenshots ==

1. Plugin settings screen with API configuration.
2. WooCommerce checkout page with donation option.
3. Product page with donation widget.
4. Dashboard showing donation statistics.

== Changelog ==

= 1.0.0 =
* Initial release.
* Donation option in WooCommerce checkout and product pages.
* Widgets and shortcodes for flexible display.
* Dashboard view of donation statistics.
* API integration for fetching and managing nonprofit organizations.

== Upgrade Notice ==

= 1.0.0 =
First stable release — add donation functionality to WooCommerce checkout and product pages.

= 1.0.1 =
Fix translation problems.

= 1.1.0 =
* Fixed issue with inline styles.
* Updated to clarify that the donation feature uses our own trusted third-party service.
* Standardized slugs to match the text domain.
* Improved widget for better security.