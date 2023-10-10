# WP Rocket Purge When Files Modified

📝 **Manual code edit required before use!**

The zipped folder should be unzipped and uploaded anywhere within the WordPress installation.

Within wp-rocket-purge-when-files-modified.php, you can specify as many CSS and JS files as needed to be monitored for changes.

You can also specify what combination of the following should automatically occur when file changes are detected:
- Clear Cache
- Clear RUCSS
- Clear Minified CSS/JS Files

A server cron should be set to call the wp-rocket-purge-when-files-modified.php script on a consistent interval of your choosing.

The script tracks the last time it was run by creating and using a file called time-last-cron-run.txt that stores the time.

When this script runs, it checks if the files were modified during the time since the script last ran, and if so, it purges Cache, RUCSS, and/or Minified files (depending on what options are enabled).

The first time the script runs, the time-last-cron-run.txt will not exist, so the purge happens automatically on that first run. Each time after, purging only occurs if the files have been modified.



To be used with:
Any setup

Last tested with:
* WP Rocket {3.15.2}
* WordPress {6.3.1}
