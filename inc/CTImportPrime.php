<?php

function CT_CTDI_import_files() {

    $premium_buy_url = 'https://www.crafthemes.com/theme/prime-business-pro/';

    return array(
        array(
            'import_file_name'           => __( 'Free Version', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/prime-business/free/primebusiness.xml',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/prime-business/free/prime-business-widgets.wie',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/prime-business/free/prime-business-customizer.dat',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/edd/2019/08/Prime-Business-Pro.jpg',
            'preview_url'                => 'https://www.crafthemes-demo.com/prime-business/',
        ),
        array(
            'import_file_name'           => __( 'Premium Features', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://crafthemes.com/xml/pbp/one-click/primebusinesspro.xml',
            'import_widget_file_url'     => 'https://crafthemes.com/xml/pbp/one-click/prime-business-pro-widgets.wie',
            'import_customizer_file_url' => 'http://crafthemes.com/xml/pbp/one-click/prime-business-pro.dat',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/edd/2019/08/Prime-Business-Pro.jpg',
            'preview_url'                => 'https://www.crafthemes.com/go/prime-business-pro-demo',
            'premium_url'                => $premium_buy_url,
        ),
    );
}
