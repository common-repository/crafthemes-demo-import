<?php

function CT_CTDI_import_files() {

    $premium_buy_url = 'https://www.crafthemes.com/theme/minimalist-blog-pro/';

    return array(
        array(
            'import_file_name'           => __( 'Free Version', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/minimalist/meet/meet-minimalist.xml',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/minimalist/meet/meet-minmalist.wie',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/minimalist/meet/meet-minmalist.dat',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/2022/10/screenshot.png',
            'preview_url'                => 'https://www.crafthemes.com/go/meet-minimalist-demo',
        ),
        array(
            'import_file_name'           => __( 'Premium Default', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/minimalist/pro/minimalistpro.xml',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/minimalist/pro/minimalist-pro-customizer.dat',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/minimalist/pro/minimalist-pro-widgets.wie',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/edd/2019/04/minimalist-pro.png',
            'preview_url'                => 'https://www.crafthemes.com/go/minimalist-pro-demo',
            'premium_url'                => $premium_buy_url,
        ),
        array(
            'import_file_name'           => __( 'Premium Meet', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/minimalist/meet-pro/meet-minimalist.xml',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/minimalist/meet-pro/minimalist-pro.dat',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/minimalist/meet-pro/meet-minimalist-pro.wie',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/2022/10/Screenshot-2-1.png',
            'preview_url'                => 'https://crafthemes-demo.click/meet-minimalist-pro/',
            'premium_url'                => $premium_buy_url,
        ),
    );
}
