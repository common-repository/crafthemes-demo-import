<?php
// Block direct access to the main plugin file.
defined('ABSPATH') or die('No script kiddies please!');

/*****************************************************************************
 * Import Respective Theme Demos
 *****************************************************************************/
$theme = wp_get_theme();
$theme_name = $theme->get('Name');

if (
    $theme_name == "Apex Business"
    || $theme_name == "Apex Business Premium"
    || $theme_name == "Apex Business Pro"
) {
    include(plugin_dir_path(__FILE__) . '/CTImportApex.php');
} else if (
    $theme_name == "Minimalist Blog"
    || $theme_name == "Minimalist Blog Pro"
    || $theme_name == "Minimalist Blog Premium"
    || $theme_name == "Minimalist Premium"
    || $theme_name == "Minimalist Pro"
) {
    include(plugin_dir_path(__FILE__) . '/CTImportMinimalist.php');
} else if ($theme_name == "Meet Minimalist") {
    include(plugin_dir_path(__FILE__) . '/CTImportMeetMinimalist.php');
} else if (
    $theme_name == "Prime Business"
    || $theme_name == "Prime Business Pro"
    || $theme_name == "Prime Business Premium"
) {
    include(plugin_dir_path(__FILE__) . '/CTImportPrime.php');
} else if (
    $theme_name == "Writer Blog"
    || $theme_name == "Writer Blog Pro"
    || $theme_name == "Writer Blog Premium"
    || $theme_name == "Writer Premium"
    || $theme_name == "Writer Pro"
) {
    include(plugin_dir_path(__FILE__) . '/CTImportWriter.php');
} else if (
    $theme_name == "Periar"
    || $theme_name == "Periar Pro"
    || $theme_name == "Periar Premium"
    || $theme_name == "Periar"
) {
    include(plugin_dir_path(__FILE__) . '/CTImportPeriar.php');
} else if (
    $theme_name == "Dreamer Blog"
    || $theme_name == "Dreamer Pro"
    || $theme_name == "Dreamer Premium"
    || $theme_name == "Dreamer Blog Premium"
) {
    include(plugin_dir_path(__FILE__) . '/CTImportDreamer.php');
} else if (
    $theme_name == "Spark News"
    || $theme_name == "Spark News Pro"
    || $theme_name == "Spark News Premium"
    || $theme_name == "Spark Premium"
) {
    include(plugin_dir_path(__FILE__) . '/CTImportSpark.php');
} else if (
    $theme_name == "Calm Blog"
    || $theme_name == "Calm Blog Pro"
    || $theme_name == "Calm Blog Premium"
) {
    include(plugin_dir_path(__FILE__) . '/CTImportCalm.php');
} else if (
    $theme_name == "Prem Blog"
    || $theme_name == "Prem Blog Pro"
    || $theme_name == "Prem Blog Premium"
) {
    include(plugin_dir_path(__FILE__) . '/CTImportPrem.php');
} else if (
    $theme_name == "Strike Blog"
    || $theme_name == "Strike Blog Pro"
    || $theme_name == "Strike Blog Premium"
) {
    include(plugin_dir_path(__FILE__) . '/CTImportStrike.php');
} else if (
    $theme_name == "Apex Dentist"
    || $theme_name == "Apex Dentist Pro"
    || $theme_name == "Apex Dentist Premium"
) {
    include(plugin_dir_path(__FILE__) . '/CTImportApexDentist.php');
} else {
    include(plugin_dir_path(__FILE__) . '/CTImportAll.php');
}

// Looping the notification through time after clicking close button
// if( !get_option( 'ct-times-shown-option' ) ) {
//     update_option( 'ct-times-shown-option', 1 );
//     set_transient( 'ct-times-shown-transient', 1, 43200 ); // 12 hours in seconds
// } else if( get_option( 'ct-times-shown-option' ) == 1 ) {
//     update_option( 'ct-times-shown-option', 2 );
//     set_transient( 'ct-times-shown-transient', 1, 604800 ); // 7 days
// } else if( get_option( 'ct-times-shown-option' ) == 2 ) {
//     update_option( 'ct-times-shown-option', 3 );
//     set_transient( 'ct-times-shown-transient', 1, 45*24*60*60 ); // 45 days
// }

//  else if (
//     $theme_name == "Jupiter Blog"
//     || $theme_name == "Jupiter Blog Pro"
//     || $theme_name == "Jupiter Blog Premium"
// ) {
//     include(plugin_dir_path(__FILE__) . '/CTImportJupiter.php');
// }