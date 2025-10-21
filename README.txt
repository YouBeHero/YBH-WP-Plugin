=== Add Donation to Cart ===
Contributors: youbehero, deviqbal
Donate link: https://youbehero.com/
Tags: fundraising, donations, nonprofit, checkout, woocommerce
Requires at least: 5.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.1.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Enable donations in WooCommerce checkout and other pages with customizable widgets, shortcodes and API-powered settings.

== Description ==

**YouBeHero** is a powerful WordPress plugin that seamlessly integrates with WooCommerce, allowing store owners to enable a donation system on checkout and product pages. Customers can easily contribute to nonprofit organizations during their shopping experience.

With dynamic widgets, shortcodes, and API-powered configurations, YouBeHero ensures a customizable and smooth donation process. Store owners can manage supported organizations, track donations, and display impact statistics directly in their WordPress dashboard.

Currently available for Greek e-commerce stores, Add Donation to Cart supports English language.

### Features
* Add donation widget to the checkout page
* Let customers support nonprofit organizations while shopping
* Configure donations dynamically via API
* Widgets, blocks and shortcodes for flexible display
* Customizable donation amounts and presentation
* Dashboard view of donation data and statistics
* Works great with Elementor & WP Bakery

== Installation ==

1. Install the plugin through the WordPress Plugins screen directly
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Create an account at YouBeHero
4. Copy the API key
5. Navigate to **WooCommerce → YouBeHero** paste the key
6. Drag and drop the **Donation widget** into the checkout page
7. Optionally, add donation widgets or shortcodes (`[youbehero_donation]`) to display donation forms on other pages.

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
Yes, the eshop manager can configure preset donation amounts and customers can then select whichever they like.

= Can I show donations outside checkout? =
Yes, YouBeHero includes widgets and shortcodes to place donation options on other areas.

= Does this plugin support multiple organizations? =
Yes, you can select one or multiple nonprofit organizations via the settings.

== Screenshots ==

1. WooCommerce checkout page Support a cause with your order
2. Add Donation to Cart dashboard showing donation statistics
3. YouBeHero dashboard showing API key and statistics
4. Donation widget style configuration page
5. Seamless integration on WP Bakery checkout
6. Post purchase thank you page widget
7. Email donation widget to inspire
8. Donations feed at the Angels of Joy's page @YouBeHero

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

= 1.1.1 =
Fix hidden files problem.