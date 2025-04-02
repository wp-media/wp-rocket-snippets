# WP Rocket | Remove scripts from Delay JS Automatic Exclusions

For compatibility reasons, [some scripts](https://github.com/wp-media/wp-rocket/blob/trunk/dynamic-lists.json) are automatically excluded from Delay JavaSscript Execution feature to prevent potential issues with site functionality. Removing a script using this Helper Plugin will allow the script to be delayed.

⚠️ It is advised to use this with caution as delaying scripts may cause issues. Please test your site thoroughly after making changes.


📝&#160;&#160;**Manual editing required before use**

On line 30, items needing to be included to Delay JS should be entered one item per line as shown on the example.
Uncomment the extra line, or add them manually.


Documentation:
* [Delay JavaScript Execution compatibility exclusions](https://docs.wp-rocket.me/article/1560-delay-javascript-execution-compatibility-exclusions#other-automatic-exclusions)

To be used with:
* When 3rd party integration are using `rocket_delay_js_exclusions` to force exclusions from Delay JS.
* When the WP Rocket's automatic exclusion impacts site performance result, and removing the exclusion improves it.



Last tested with:
* WP Rocket 3.18.3
* WordPress 6.7.2
