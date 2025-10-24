# WP Rocket | Prevent Recursive Folder Cleanup

Prevents WP Rocket from **recursively deleting cache folders** for specific folders or section URLs (e.g. `/fr/`), and instead deletes **only the index cache files** inside them.

This helps preserve multilingual cache structures or custom folder-based caches with parent-childen relationshios, that shouldn’t be entirely wiped during purge operations.


## How it works

When WP Rocket triggers a cache purge (e.g. after post update or manual purge), this helper:

1. Checks if the URL being purged matches a **protected folder** (like `/fr/` or `/es/`).
2. Deletes **only** the top-level cache files (`index.html` and `index.html_gzip`) inside that folder.
4. Marks the corresponding cache entry as **pending** in WP Rocket’s internal cache table (`wpr_rocket_cache`).


## Configuration

Edit the list of protected URLs inside the helper function:

```php
function rocket_fix_get_protected_urls() {
    $home_url = get_home_url();
    return [
        $home_url . '/fr/',
        // Add more folders below if needed:
        // $home_url . '/es/',
        // $home_url . '/blog/',
    ];
}
```

Add or remove any folders you want WP Rocket to skip during recursive purges.



## Tested with

- **WP Rocket:** 3.20.x  
- **WordPress:** 6.8.x  