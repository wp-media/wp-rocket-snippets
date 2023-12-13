# WP Rocket | Reset cache tables after Multisite cache cleanup

 **could potentially trigger high CPU cases on some serves**

This helper will reset all the cache rows to a pending state on a multisite install, after WP Rocket's cache cleanup to trigger a preload.

**Important**: it is a workaround until this Github issue is fixed: 

Cache of the subsites is erased when purging the main site's cache in the multisite environment
https://github.com/wp-media/wp-rocket/issues/2746

