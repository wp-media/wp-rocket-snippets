<?php 

// Clear the post cache after saving a page using the Breakdance builder.
// to be added into functions.php, via code snippets or similar
// https://breakdance.com/
// Breakdance hooks: https://github.com/soflyy/breakdance-developer-docs/blob/master/hooks/other.md

add_action("breakdance_after_save_document", function ($postId) {
// the save button in Breakdance was clicked and the post was saved
rocket_clean_post($postId);
});