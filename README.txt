=== Add Donation to Cart ===
Contributors: youbehero, deviqbal
Donate link: https://youbehero.com/
Tags: fundraising, donations, nonprofit, checkout, woocommerce
Requires at least: 5.7
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add Donation to Cart by YouBeHero is a powerful WordPress plugin that adds a donation widget to your WooCommerce checkout.

== Description ==

**Add Donation to Cart** by YouBeHero adds a donation widget to your WooCommerce checkout, allowing customers to support nonprofit organizations during purchase. The widget is optional and seamlessly integrates without disrupting the checkout flow.

**Benefits:**
* Increase customer loyalty and conversions
* Differentiate your brand as socially responsible
* Build trust through transparent impact reporting

Currently available for Greek e-commerce stores with English locale support.

**Key Features:**
* Checkout integration with flexible positioning options
* Gutenberg block, Elementor widget, WP Bakery integration, and shortcodes
* Admin dashboard with real-time statistics and transaction history
* Customizable styling and appearance settings
* Support for multiple organizations (up to 7)
* Thank you page widget and email integration
* Translation-ready (Greek and English)

== Installation ==

1. Install the plugin from WordPress plugins dashboard
2. Create an account at [YouBeHero](https://dev.youbehero.com/gr/signup-eshop)
3. Copy your API key and paste it in **YouBeHero** settings in WordPress admin
4. Add the donation widget using:
   - Gutenberg block: "YouBeHero Donation Widget"
   - Elementor: "YouBeHero Donation Widget" widget
   - WP Bakery: Drag and drop the donation widget
   - Shortcode: `[youbehero_donation_form]`

== Shortcodes ==

**Donation Form:**
* `[youbehero_donation_form]` - Main donation form widget

**Statistics:**
* `[total-donations]` - Total amount of donations (formatted with currency)
* `[total-number-of-donations]` - Total number of donations made
* `[total-number-supported-non-profits]` - Number of supported organizations

Works with Elementor, WP Bakery, Gutenberg, and any theme that supports shortcodes.

== Admin Dashboard ==

The dashboard provides:
* Account management (API key, status, balance)
* Statistics (total donations, sales, average cart value, order count, supported organizations)
* Transaction history with links to WooCommerce orders
* Widget configuration (positioning, styling, organizations, donation amounts)

== External Services ==

**Privacy and Data Handling**

This plugin integrates with the YouBeHero platform. The following data is shared:
* API key, order ID, purchase amount, donation amount, selected organization

**Why:** To process donations, display widgets, and provide analytics. No payment details are shared. All data transmitted via HTTPS.

**Callback URL:** YouBeHero may redirect administrators to automatically configure API tokens. Only administrators can access, and tokens are sanitized before storage.

External service: **YouBeHero**
* Website: [https://dev.youbehero.com](https://dev.youbehero.com)
* Terms: [https://dev.youbehero.com/gr/termsbusiness](https://dev.youbehero.com/gr/termsbusiness)
* Privacy: [https://dev.youbehero.com/gr/privacy](https://dev.youbehero.com/gr/privacy)

== Contributing ==

Open source contributions welcome! Submit pull requests at [https://github.com/YouBeHero/YBH-WP-Plugin](https://github.com/YouBeHero/YBH-WP-Plugin)

== Frequently Asked Questions ==

= Does this plugin require WooCommerce? =
Yes, WooCommerce must be installed and active.

= Can customers choose the donation amount? =
Yes, store managers configure preset amounts and customers can select or enter custom amounts.

= Can I show donations outside checkout? =
Yes, use widgets, blocks, or shortcodes anywhere on your site.

= Does this plugin support multiple organizations? =
Yes, select up to 7 nonprofit organizations. Customers choose which cause to support.

= Which nonprofit organizations can I choose from? =
Over 150 verified organizations across Greece in three categories: Animal welfare, Human-centered, and Environmental. Browse at [https://youbehero.com/gr/cause-categories](https://youbehero.com/gr/cause-categories)

= What page builders are supported? =
Elementor, WP Bakery, Gutenberg blocks, and any theme that supports shortcodes.

= Can I customize the appearance? =
Yes, full control over colors, borders, spacing, fonts, and layout through admin settings.

= How do I track donations? =
The admin dashboard shows total donations, sales, average cart value, order count, and supported organizations.

= What are the pricing and costs? =
* Free for first use (prepaid donations)
* 0.07€ (including VAT) per donation after initial period
* No setup fees or monthly subscriptions

= What technical support is available? =
Email support, WordPress plugin forum, and help center at [help.youbehero.com](https://help.youbehero.com/)

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

= 1.1.1 =
* Fix hidden files problem (.DS_Store).

= 1.1.0 =
* Fixed inline styles issue
* Clarified third-party service usage
* Standardized slugs to match text domain
* Improved widget security

= 1.0.1 =
* Fix translation problems.

= 1.0.0 =
* Initial release with donation option in WooCommerce checkout, widgets, shortcodes, dashboard statistics, and API integration.
