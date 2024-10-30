<?php
// Enqueue js file
if ( ! function_exists( 'ct_ctdi_admin_scripts' ) ) :
function ct_ctdi_admin_scripts() {
    wp_enqueue_media();
    wp_enqueue_script( 'ct-ctdi-jquery-admin-script', PT_CT_CTDI_URL . 'assets/js/jquery-admin-script.js', array( 'jquery' ), '', true );
    wp_localize_script( 'ct-ctdi-jquery-admin-script', 'ct_ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
    );
}
endif;
add_action( 'admin_enqueue_scripts', 'ct_ctdi_admin_scripts' );
add_action( 'customize_controls_enqueue_scripts', 'ct_ctdi_admin_scripts' );