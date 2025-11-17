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

**Add Donation to Cart** by YouBeHero is a powerful WordPress plugin that adds a donation widget to your WooCommerce checkout, transforming every purchase into an opportunity for social impact. By allowing customers to support nonprofit organizations during checkout, you create a more meaningful shopping experience that builds loyalty, differentiates your brand and boosts key business metrics.

**Why add donations to checkout?**
- **Increase customer loyalty** - Customers feel good about supporting causes they care about
- **Differentiate your brand** - Stand out as a socially responsible business
- **Boost conversions** - The "warm glow effect" increases checkout completion rates
- **Build trust** - Transparent impact reporting creates customer confidence

The plugin seamlessly integrates with your existing checkout flow without disrupting the customer experience. The donation widget is discreet and optional - customers can easily skip it if they prefer, ensuring your checkout process remains smooth and conversion-friendly. No changes to your payment processing are required. With dynamic widgets, shortcodes, and API-powered configurations, YouBeHero ensures a customizable and smooth donation process. Store owners can manage supported organizations, track donations and display impact statistics directly in their WordPress dashboard.

Although currently **only available for Greek e-commerce stores**, Add Donation to Cart supports English locales.

### Features
* Checkout Integration: Add donation widget to WooCommerce checkout page with multiple positioning options
* Flexible Positioning: Choose from 4 different checkout positions (before form, after billing, before notes, after payment)
* Multiple Display Options: Widgets, blocks, shortcodes, and Elementor integration for maximum flexibility
* Shortcodes Available:
  - `[youbehero_donation_form]` - Main donation form
* Page Builder Support: Native Elementor widget and WP Bakery integration
* Gutenberg Block: Custom "YouBeHero Donation Widget" block for checkout pages
* Thank You Page Widget: Post-purchase confirmation widget with customizable styling
* Email Integration: Donation widgets in WooCommerce order emails
* Dynamic Configuration: API-powered settings for organizations and donation amounts
* Customizable Styling: Full control over colors, borders, spacing, and appearance
* Multi-language Support: Translation-ready with Greek and English language files
* Admin Dashboard: Comprehensive statistics and analytics dashboard
* Real-time Statistics: Track total donations, sales, average cart value, order count, and supported nonprofit organizations
* Account Management: Balance tracking and account status monitoring
* Transaction History: Detailed transaction table with order tracking
* API Integration: Secure connection to YouBeHero platform for data management
* WooCommerce Hooks: Deep integration with WooCommerce order processing
* Session Management: Persistent donation data across checkout process
* Fee Integration: Seamless addition of donation fees to WooCommerce orders
* Responsive Design: Mobile-friendly donation forms and widgets

== Installation ==

1. Install the plugin through the WordPress plugins dashboard screen directly
2. Create an account at [YouBeHero](https://dev.youbehero.com/gr/signup-eshop)
   - Configure your settings and select supported organizations
   - Customize the appearance and positioning in the plugin settings
3. Copy your API key from the YouBeHero dashboard
4. Navigate to **YouBeHero** settings in your WordPress admin
5. Paste your API key and click "Login"
6. Add the donation widget to your checkout page using one of these methods:
   - **Gutenberg Block**: Add the "YouBeHero Donation Widget" block to your checkout page
   - **Elementor**: Use the "YouBeHero Donation Widget" in Elementor
   - **WP Bakery**: Drag and drop the donation widget
   - **Shortcode**: Use `[youbehero_donation_form]` anywhere on your site


== Shortcodes ==

The plugin provides several shortcodes for displaying donation forms:

**Main Donation Form:**
- `[youbehero_donation_form]` - Displays the main donation form widget
- `[ybhd_donation_form]` - Alternative shortcode for the same functionality

**Usage Examples:**
- Add to any page or post: `[youbehero_donation_form]`
- Use in page builders: Works with Elementor, WP Bakery and Gutenberg

== Admin Dashboard ==

The YouBeHero admin dashboard provides comprehensive management and analytics:

**Account Management:**
- API key configuration and validation
- Account status monitoring
- Balance tracking and top-up options
- Direct links to YouBeHero platform settings

**Statistics & Analytics:**
- Total donations collected
- Total sales value
- Average cart value
- Number of orders processed
- Count of supported nonprofit organizations
- Real-time data refresh

**Transaction Management:**
- Detailed transaction history table
- Order tracking and donation details
- Export capabilities for reporting
- Search and filter options

**Widget Configuration:**
- Checkout form positioning options
- Styling and appearance settings
- Organization selection and management
- Donation amount presets

**Integration Settings:**
- WooCommerce hook configuration
- Email widget settings
- Thank you page customization
- Multi-language support

== External services ==

**Privacy and data handling**

This plugin integrates your WooCommerce store with the YouBeHero platform to facilitate charitable donations and related features.

Below is an overview of what data is shared and why.

**Data shared with YouBeHero**

When using this plugin, the following information is transmitted to YouBeHero’s servers:

* API key: Used to securely connect your store to your YouBeHero account to record and track donations
* WooCommerce order ID: For accurate donation-to-order association and tracking
* Purchase amount: The total cart value for transaction recording and donation integration
* Donation amount: The exact donated sum to ensure correct processing and allocation to the designated charity
* Selected organization: To determine the destination of the donation

**Why this data is collected?**

This data is necessary to:

* Register and authenticate your store with YouBeHero
* Process and record donations made through your checkout
* Display donation widgets and campaign information to shoppers
* Provide donation reporting and analytics within your WordPress admin

**Important notes**

* No payment details are sent to YouBeHero
* Only donation metadata and order references are shared
* All data is transmitted securely via HTTPS

**Callback URL handling:**
The YouBeHero service may redirect administrators to a callback URL inside the WordPress admin (e.g., `wp-admin/admin.php?page=ybhd-settings&api_token=xxxxx`). This URL automatically configures the API token. Only users with administrator permissions can access this page, and the token is sanitized before storage. Since this request originates from a trusted external service, a WordPress nonce cannot be applied.

External service: **YouBeHero**
- Website: [https://dev.youbehero.com](https://dev.youbehero.com)
- Terms of Service: [https://dev.youbehero.com/gr/termsbusiness](https://dev.youbehero.com/gr/termsbusiness)
- Privacy Policy: [https://dev.youbehero.com/gr/privacy](https://dev.youbehero.com/gr/privacy)

== Contributing ==

This plugin is open source and we welcome contributions from the community! If you have ideas for improvements, bug fixes, or new features, please feel free to submit pull requests on GitHub at [https://github.com/YouBeHero/YBH-WP-Plugin](https://github.com/YouBeHero/YBH-WP-Plugin).

Your contributions help make this plugin better for everyone.

== Frequently Asked Questions ==

= Does this plugin require WooCommerce? =
Yes, WooCommerce must be installed and active for YouBeHero to work.

= Can customers choose the donation amount? =
Yes, store managers can configure preset donation amounts and customers can select from available options or enter custom amounts.

= Can I show donations outside checkout? =
Yes, YouBeHero includes widgets, blocks and shortcodes to place donation options.

= Does this plugin support multiple organizations? =
Yes, you can select one or multiple nonprofit organizations (max. 7) via the settings and customers can choose which cause to support.

= Which nonprofit organizations can I choose from? =
YouBeHero currently works with over 150 verified nonprofit organizations across Greece, with many more added throughout the year. Organizations are categorized into three main cause areas:
- **Animal welfare organizations**
- **Human-centered organizations**
- **Environmental organizations**

You can browse all available organizations and their categories at [https://youbehero.com/gr/cause-categories](https://youbehero.com/gr/cause-categories). All organizations are thoroughly vetted to ensure your customers' donations go to legitimate, impactful causes.

= Does adding donation options increase cart conversions? =
Yes! Studies show that adding donation options to checkout can increase cart conversions by 10-15% due to the "warm glow effect." When customers see they can support a cause they care about during their purchase, it creates positive emotions that make them more likely to complete their order. The donation option also differentiates your store from competitors and builds customer loyalty.

= What page builders are supported? =
The plugin works with Elementor, WP Bakery, Gutenberg blocks and any theme that supports shortcodes.

= Can I customize the appearance of the widgets? =
Yes, you have full control over colors, borders, spacing, fonts and layout through the admin settings.

= Is the plugin translation-ready? =
Yes, the plugin includes translation files for Greek and English, and is fully translation-ready for other languages.

= How do I track donations and statistics? =
The admin dashboard provides comprehensive statistics including total donations, sales, average cart value, order count and supported organizations with links to their public pages.

= Can I add donations to order emails? =
Yes, the plugin automatically includes donation information in WooCommerce order confirmation emails.

= Are donations visible in WooCommerce admin order details? =
Yes, donations appear as line items in the order details with the organization name, amount and metadata. They are also displayed in the order totals section for easy tracking.

= How can customers track their donations? =
Customers can track their donations through multiple channels:
- **YouBeHero Platform**: Track donation progress, connect with supported organizations, and see the impact created
- **Organization's Official Website**: Direct links to the nonprofit's website for updates and information
- **Social Media**: Links to the organization's social media channels (Twitter, Instagram, Facebook, YouTube, LinkedIn) for real-time updates

= Can shop managers share their impact statistics publicly? =
Yes, shop managers can display their donation impact statistics anywhere on their website using shortcodes. This includes:
- **Total donations** collected
- **Supported nonprofit organizations** count

These statistics can be embedded on any page, post, or widget area to showcase the positive impact created through customer donations.

= How transparent is YouBeHero with donation data? =
Trust is fundamental to YouBeHero's mission. All donation data is publicly visible and transparent through our dedicated transparency page at [https://youbehero.com/gr/diafaneia](https://youbehero.com/gr/diafaneia). This includes:
- **Total donations** collected across all stores
- **Commission amounts** and platform revenue
- **Number of approved donations** vs. pending donations
- **Store rankings** by donation impact
- **Organization distribution** by category

This complete transparency builds trust and ensures accountability in every donation made through the platform.

= How can I verify YouBeHero's credibility and stay updated? =
YouBeHero maintains an active presence across multiple social media platforms where you can follow our latest updates, success stories and impact reports:
- **Facebook**: [facebook.com/youbeheroGR](https://www.facebook.com/youbeheroGR/)
- **Twitter**: [twitter.com/youbehero](https://twitter.com/youbehero)
- **Instagram**: [instagram.com/youbeherogr](https://www.instagram.com/youbeherogr/)
- **LinkedIn**: [linkedin.com/company/youbehero](https://www.linkedin.com/company/youbehero/)
- **YouTube**: [youtube.com/@youbeherogr](https://www.youtube.com/@youbeherogr)

Follow us to see real-time impact stories, organization spotlights and community engagement that demonstrates our commitment to making a difference.

= What happens after a customer makes a donation? =
Customers see a thank you widget on the order confirmation page and donation details are included in order emails and admin reports.

= What technical support is available? =
YouBeHero provides comprehensive technical support through multiple channels:
- **Email support** - Direct assistance via email for technical issues and questions
- **WordPress plugin forum** - Community support and discussions on the official WordPress plugin page
- **Help Center** - Complete documentation, guides and troubleshooting resources at [help.youbehero.com](https://help.youbehero.com/)

Our support team is committed to helping you successfully implement and maintain the donation functionality on your store.

= What are the pricing and costs? =
YouBeHero offers a transparent and affordable pricing structure:
- **Free for first use** - Shop managers prepay all donations initially, allowing you to test the system at no cost
- **Low ongoing fee** - Only 0.07€ (including VAT) per donation after the initial period
- **No setup fees** - No hidden costs or monthly subscriptions
- **Transparent billing** - All costs are clearly displayed in your dashboard

This pricing model ensures that the donation system is accessible to stores of all sizes while maintaining the platform's sustainability.

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