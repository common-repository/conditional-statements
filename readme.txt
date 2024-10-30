=== Conditional Statements ===
Contributors: aliakro
Donate link: https://www.paypal.me/yeken
Tags: if, statement, conditional, statements, else, elseif, and, logged, in
Requires at least: 4.2.0
Tested up to: 5.2.2
Stable tag: 1.0
Requires PHP: 5.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add Conditional Statements to your post content e.g. IF the user is logged in display "Welcome back!"

== Description ==

Conditional Statements allows you to add logic into your pages. The plugin supports various conditions allowing you to apply IF statements.

For example: "IF the user is logged in display X ELSE display Y" would look like:

[cs-if conditions="is-logged-in"]
    <p>Welcome Back!</p>
    [gallery]
[else]
    <p>You must be logged in to view the gallery.</p>
[/cs-if]

You can also nest conditions e.g.

[cs-if conditions="is-logged-in"]
  <p>The user is logged in.</p>
  [cs-if-1 conditions="firstname"]
    The user has entered a first name!
  [else-1]
    The user must enter a first name!
  [/cs-if-1]
  [cs-if-1 conditions="lastname"]
    The user has entered a last name!
  [else-1]
    The user must enter a last name!
  [/cs-if-1]
[/cs-if]

Simply add a hyphen and the depth (up to a maximum of 5) e.g. [cs-if-1], [cs-if-2], [cs-if-3] and so on.

= Examples =

Please look at these examples on how to use the Conditional Statements shortcode:

[Examples of how to use Conditional Statements](https://gist.github.com/yekenuk/2e61c83fc72b990878c55affa05e6d09 "Examples of how to use Conditional Statements")

= Features =

* Supports nesting of IF statements (upto 5 deep)
* AND logic. If you specify more than one condition, the conditions are AND'd (e.g. all conditions must be met for the condition to be true)
* ELSE conditions
* Comparisons e.g. "does the post type equal 'article'"

[cs-if conditions="post-type" operator="equals" compare-value="article"]
  Post Type is Article
[else]
  [cs-if-1 conditions="post-type" operator="equals" compare-value="post"]
    Post Type is Post
  [else-1]
    Post type is not Article or Post.
  [/cs-if-1]
[/cs-if]

= Supported Conditions =

* [cs-if conditions="is-logged-in"] (supported operators: equals) - User logged in
* [cs-if conditions="ip"] (supported operators: equals) - User's IP
* [cs-if conditions="first-name"] (supported operators: equals, exists, not-exists) - User's first name
* [cs-if conditions="last-name"] (supported operators: equals, exists, not-exists) - User's last name.
* [cs-if conditions="display-name"] (supported operators: equals, exists, not-exists) - User's display name.
* [cs-if conditions="user-id"] (supported operators: equals) - User's ID.
* [cs-if conditions="post-id"] (supported operators: equals) - Post ID of current post in loop.
* [cs-if conditions="post-slug"] (supported operators: equals) - Slug of current post in loop.
* [cs-if conditions="post-type"] (supported operators: equals) - Post type of current post in loop.

To suggest new conditions, email me at: email@yeken.uk

= Coming Soon =

* Support for ELSE IF statements
* OR statements
* New conditions (please email suggestions email@yeken.uk)

== Upgrade Notice ==


== Installation ==

1. Login into Wordpress Admin Panel
2. Navigate to Plugins > Add New
3. Search for "Conditional Statements"
4. Click Install now and activate plugin

== Frequently Asked Questions ==

= What is the best way to suggest a new condition? =

Drop me an email: email@yeken.uk

== Screenshots ==


== Changelog ==

= 1.0 =

* Initial Build
