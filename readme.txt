=== Integrate SharpSpring and Gravity Forms ===
Contributors: Oyova
Donate link: https://www.oyova.com
Tags: Gravity Forms, CRM, SharpSpring
Requires at least: 5.4
Tested up to: 6.1
Stable tag: 1.0.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Seamlessly integrate Gravity Forms with SharpSpring. Easily connect all forms on your website, collect lead information into your CRM and power up your email and marketing automation.

== Description ==

## Intelligent Integration

Connect your forms with SharpSpring and push your lead data into your lists. Capture new leads from any form on your site, they will automatically be added to your contact manager as a lead. Have one form connect to multiple lists and capture different data using multiple feeds on one form.

## Custom Fields

Capture more data than the basics. Create custom fields in SharpSpring and easily map them to any field from your form. That data will then be mapped to your new lead.

## Conditional Logic

Enable conditional logic to dynamically send leads based on information they’ve provided. Don’t want a lead to go to a list if they’ve selected a specific checkbox option? Easily done with conditional logic.

## Integrate SharpSpring and Gravity Forms Setup:

* Go To Forms -> Settings -> SharpSpring -> Add API settings ( These can be found in SharpSpring: SharpSpring Settings -> Sharppring API -> API Settings )
* Go to Forms -> Select any Form -> Settings -> SharpSpring -> Create feed ( Create One )
* Feed Settings -> Create feed name -> Choose a list -> Map form fields -> Update settings

## Instructional Videos:

[youtube https://www.youtube.com/watch?v=L_AOPqNKLZA]

[youtube https://www.youtube.com/watch?v=xJ7Tjj16d64]

== Changelog ==

= 1.0.4 =
*Release Date - 2 December 2022*

* Dev - Increment tested value: 6.1.
* Corrected readme typographical errors.
* Dev - Corrected null offset warning.

= 1.0.3 =
*Release Date - 11 May 2021*

* New - Added support for updateLeads method. This addition will update a lead's information if the lead already exists.
* Fixed - PHP notices that appeared when the Account ID was incorrect.

= 1.0.2 =
*Release Date - 28 April 2021*

* New - Added support for Akismet tagged spam prevention.

= 1.0.1 =
*Release Date - 15 April 2021*

* Dev - Increment tested value: 5.7.

= 1.0.0 =
*Release Date - 7 October 2020*

* New - Initial release.