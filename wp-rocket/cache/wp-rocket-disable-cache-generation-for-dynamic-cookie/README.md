
# WP Rocket | Disable Cache Generation for Dynamic Cookie

This helper disables cache files generation when a registered dynamic cookie is set, while preserving other WP Rocket optimization features.

## What this helper does

The helper:

1. Registers your cookie as dynamic cookie using the `rocket_cache_dynamic_cookies` filter.
2. Prevents cache file generation for pages where that cookie is set through the `do_rocket_generate_caching_files` filter, while keeping WP Rocket optimizations features such as Remove Unused CSS, Lazyload, Delay JavaScript Execution, etc.
3. Updates the `.htaccess`file and regenerates WP Rocket config file on activation and deactivation.

## When to use it

Some plugins use cookies to display content based on a visitor's conditions. If that content is cached and is not implemented with JavaScript, visitors may see the wrong version of the page.

Normally, registering a cookie with WP Rocket as a dynamic cookie using the `rocket_cache_dynamic_cookies` filter should be enough. However, this approach may not work as expected for all plugins/websites. This helper is useful when:

- Your plugin is not fully compatible with WP Rocket's [dynamic-cookie approach](https://docs.wp-rocket.me/article/1313-create-different-cache-files-with-dynamic-and-mandatory-cookies).
- Cached pages display inconsistent or incorrect content when the cookie is present, and the only option is to disable caching.


## Manual Configuration

Manual edit is required before activating the helper. Please open the PHP file and make the following updates:

### 1. Register the cookie

Find this section near the top of the PHP file:

```php
// Edit below: add the cookie name.
//$cookies[] = 'my_dynamic_cookie';
// STOP EDITING
```

Uncomment the line and replace `my_dynamic_cookie` with the cookie name you want to register as your dynamic cookie:


### 2. Use the same cookie name in the cache-generation check

Find the return statement in `wpr_dynamic_cookie_maybe_disable_cache_generation()`:

```php
return ! isset( $_COOKIE['my_dynamic_cookie'] );
```

Replace `my_dynamic_cookie` with the same cookie name used above:


---

## Installation

1. Edit the PHP file as described above.
2. Zip the helper folder or PHP file.
3. In WordPress, go to **WP Admin > Plugins > Add New > Upload Plugin**.
4. Upload and install the ZIP file.
5. Activate the helper.

On activation, the helper updates WP Rocket's configuration and `.htaccess` files. Deactivating it restores those settings.

## Important notes

- The cookie name must match in both locations.
- Test your pages after activating the plugin.
- Do not add the cookie to **Never Cache Cookies** unless you intentionally want to disable caching and optimzation all together, which then defeats the purpose of this approach.

## Compatibility

Last tested with:

- WP Rocket 3.23.x
- WordPress 7.x
