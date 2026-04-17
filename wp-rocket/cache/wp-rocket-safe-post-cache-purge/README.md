# WP Rocket | Safe Post Cache Purge on Status Change

⚠ Used to prevent fatal errors when the `pre_post_update` hook is triggered with invalid or missing arguments (e.g. empty post ID or missing post data).  

This can happen with some plugins (e.g. custom post workflows or builders like JetEngine), which call the hook incorrectly.

---

## What this helper does

- Removes WP Rocket callbacks hooked to `pre_post_update` that expect valid arguments
- Replaces them with a safe wrapper that:
  - Runs the normal WP Rocket purge logic when data is valid
  - Falls back to `rocket_clean_post()` when data is missing or malformed

This avoids fatal errors while still ensuring cache is cleared.

---

## Notes

- In fallback cases, cache is purged more broadly (not limited to draft → publish transitions)
- Optional: can be limited to specific post types inside the helper
- This is a workaround — the root cause is a third-party plugin calling the hook incorrectly

---

## Last tested with:
* WP Rocket 3.21.x  
* WordPress 6.9.x