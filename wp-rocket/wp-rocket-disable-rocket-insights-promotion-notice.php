add_action('admin_init', function () {
    $container = apply_filters('rocket_container', null);
    if (!is_object($container) || !method_exists($container, 'get')) {
        return;
    }
    if (!$container->has('ri_subscriber')) {
        return;
    }
    $subscriber = $container->get('ri_subscriber');
    remove_action('admin_notices', [$subscriber, 'maybe_display_rocket_insights_promotion_notice']);
}, 11);
