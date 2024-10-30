<?php
function CT_CTDI_import_files() {

    $premium_buy_url = 'https://www.crafthemes.com/theme/strike-blog-pro/';

    return array(
        array(
            'import_file_name'           => __( 'Free Version', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/prem-blog/free/prem-blog-export.xml',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/prem-blog/free/prem-blog-widgets.wie',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/prem-blog/free/prem-blog-customizer.dat',
            'import_preview_image_url'   => 'https://dc.crafthemes.com/prem-blog/free/screenshot.jpg',
            'preview_url'                => 'https://crafthemes-demo.com/prem-blog/'
        ),
        array(
            'import_file_name'           => __( 'Prem Blog Premium', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/prem-blog/prem-blog-pro/prem-blog-export.xml',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/prem-blog/prem-blog-pro/prem-blog-widgets.wie',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/prem-blog/prem-blog-pro/prem-blog-customizer.dat',
            'import_preview_image_url'   => 'https://dc.crafthemes.com/prem-blog/prem-blog-pro/screenshot.jpg',
            'preview_url'                => 'https://crafthemes-demo.com/prem-blog-pro/',
            'premium_url'                => $premium_buy_url,
        ),
        array(
            'import_file_name'           => __( 'Prem Blog Slider', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/prem-blog/prem-blog-pro-two/prem-blog-export.xml',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/prem-blog/prem-blog-pro-two/prem-blog-widgets.wie',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/prem-blog/prem-blog-pro-two/prem-blog-customizer.dat',
            'import_preview_image_url'   => 'https://dc.crafthemes.com/prem-blog/prem-blog-pro-two/screenshot.jpg',
            'preview_url'                => 'https://crafthemes-demo.com/prem-blog-pro-two/',
            'premium_url'                => $premium_buy_url,
        ),
    );
}