<?php
function CT_CTDI_import_files() {

    $premium_buy_url = 'https://www.crafthemes.com/theme/strike-blog-pro/';

    return array(
        array(
            'import_file_name'           => __( 'Free Version', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/strike-blog/free/strike-blog-export.xml',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/strike-blog/free/strike-blog-widgets.wie',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/strike-blog/free/strike-blog-customizer.dat',
            'import_preview_image_url'   => 'https://dc.crafthemes.com/strike-blog/free/screenshot.jpg',
            'preview_url'                => 'https://crafthemes-demo.com/strike-blog/'
        ),
        array(
            'import_file_name'           => __( 'Strike Blog Premium', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/strike-blog/strike-blog-pro/strike-blog-export.xml',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/strike-blog/strike-blog-pro/strike-blog-widgets.wie',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/strike-blog/strike-blog-pro/strike-blog-customizer.dat',
            'import_preview_image_url'   => 'https://dc.crafthemes.com/strike-blog/strike-blog-pro/screenshot.jpg',
            'preview_url'                => 'https://crafthemes-demo.com/strike-blog-pro/',
            'premium_url'                => $premium_buy_url,
        ),
        array(
            'import_file_name'           => __( 'Strike Blog Banner', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/strike-blog/strike-blog-pro-two/strike-blog-export.xml',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/strike-blog/strike-blog-pro-two/strike-blog-widgets.wie',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/strike-blog/strike-blog-pro-two/strike-blog-customizer.dat',
            'import_preview_image_url'   => 'https://dc.crafthemes.com/strike-blog/strike-blog-pro-two/screenshot.jpg',
            'preview_url'                => 'https://crafthemes-demo.com/strike-blog-pro-two/',
            'premium_url'                => $premium_buy_url,
        ),
    );
}