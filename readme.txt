=== V.I.Plus - email marketing ===
Contributors: atplogic
Tags: V.I.Plus - Email Marketing, Email Marketing, commerce, subscription, registration, integration, feedback, support, newsletter
Requires at least: 3.0.0
Tested up to: 3.4.1
Stable tag: 1.534
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

V.I.Plus - email marketing registration plug-in enables you to register new 
subscribers to your newsletter directly from your WordPress site.




== Description ==

Word press plug-in
 

V.I.Plus - email marketing

V.I.Plus - email marketing is a professional yet easy and fun to use email marketing system.
The system includes a powerful newsletter builder, responsive email for 
mobile devices, auto launchers and more.

The V.I.Plus - email marketing registration plug-in enables you to integrate your V.I.Plus account 
with WordPress. After installing the plug-in, a widget will be created in the admin section. 
You can relocate the widget as you desire.

The widget provides support for several languages (English, Hebrew and Russian) 
and enables V.I.Plus members to implement a digital registration form users 
can subscribe to their mailing list.

Build & enhance your customer relationship today. Try V.I.Plus now!




== Installation ==

1. Create the 'viplus' folder in your '/wp-content/plugins/' directory.
1. Upload plugin files to newly created folder
1. Activate 'V.I.Plus - email marketing' plugin, pressing 'Plugins' => 'Installed plugins'
1. Visit 'Appearance' => 'Widgets' and drag your 'V.I.Plus - email marketing' widget to desired sidebar position
1. Visit your V.I.Plus account and create new API Key, pressing 'Settings' => 'API Keys' => 'Add IPI Key'
1. Copy created API Key value to 'API Key' field in 'V.I.Plus - email marketing' widget
1. Fill widget title. It will appear above registration form at your site
1. Done


== Frequently Asked Questions ==

= How to use 'V.I.Plus - email marketing' widget with a shortcode? =

In any editor, add the following line at the place You want the registration form will appear:
[atp-viplus-register apikey="XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX" title="TITLE"]test[/atp-viplus-register]
 * The 'apikey' attribute is required. You can get it from Your V.I.Plus account pressing "Settings => API Keys".
 * The 'title' key is used to define custom title above the form.

= How to subscribe users via 'V.I.Plus - email marketing' widget into specific group in your V.I.Plus account? =

In the source code, find 'viplists' variable value (located in function atpSendData()).
Initially, it looks like this: `'viplists' => '0'`.
Change '0' to desired group value. For example: `'viplists' => '123456'`. Save changes.
* The group number you can get in your V.I.Plus account, pressing 'Lists' and taking a value from the 
'System #' field.

= How to tune up updating mode for existing contacts? =

In the source code, find the string: `'exists' => 'Merge',`.
Change 'Merge' value to one of possible alternatives and save changes:
[Merge]: add new contact even if such contact already exists in another group (will appear in both groups). 
[Update]: add new contact even if such contact already exists in another group (will appear only in chosen group).
[Fail]: add only new contacts. don't add contact if such email already exists in any of your lists.
Example: 'exists' => 'Update',


= Widget don't work or something described here is going wrong =

Email us to support@viplus.com and describe a problem. Our staff will help you soon.

== Changelog ==
= 1.532 =
* Readme fix

= 1.53 =
* Registration mode handling: when account is exists, it is possible to merge, update or cancel registration.
This upgrade will give you possibility to choose registration mode: Merge, Update or Cancel.
New options are:
 1. [Merge]: add anyway; add to selected group even if exists in another group (will appear in both groups)
 2. [Update]: add anyway; add to selected group even if exists in another group (will appear only in selected group)
 3. [Fail]: don't add when such email already exists. Will give error message "User is already registered"

= 1.52 =
* Change readme

= 1.51 =
* Fixed options handling

= 1.5 =
* Contains options bug
* Hide apikey in the form when using via sidebar
* Minor bugs fixed

= 1.43 =
* Stable release
* Bugfix
* It is possible to use the widget with shortcode "atp-viplus-register". 
Example: [atp-viplus-register apikey="XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX" title="V.I.Plus Registration Form"]Example[/atp-viplus-register]

= 1.3 =
* This version is not available from WordPress Plugin Directory
* Added option to use shortcode

= 1.2 =
* First stable release.
* Support for English and Russian languages
* Minor bugs fixed

= 1.1 =
* This version is not available from WordPress Plugin Directory
* Bugfix
* Support for 'viplists' value to define specific group.

= 1.0 =
* This version is not available from WordPress Plugin Directory
* First version.

== Upgrade Notice ==
= 1.534
Change widget name
= 1.532 =
Readme fix 
= 1.53 =
This upgrade will give you possibility to choose registration mode: Merge, Update or Cancel.
New options are:
 * [Merge]: add anyway; add to selected group even if exists in another group (will appear in both groups)
 * [Update]: add anyway; add to selected group even if exists in another group (will appear only in selected group)
 * [Fail]: don't add when such email already exists. Will give error message "User is already registered"


= 1.52 =
Latest release

= 1.51 =
Latest stable release

= 1.43 =
Stable release

= 1.2 =
First stable release

