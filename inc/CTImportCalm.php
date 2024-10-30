<?php

function CT_CTDI_import_files() {

    $premium_buy_url = 'https://www.crafthemes.com/theme/calm-blog-pro/';

    return array(
        array(
            'import_file_name'           => __( 'Free Version', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/calm-blog/free/calm-blog-export.xml',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/calm-blog/free/calm-blog-widgets.wie',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/calm-blog/free/calm-blog-customizer.dat',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/2021/06/screenshot.png',
            'preview_url'                => 'https://crafthemes-demo.com/calm-blog/'
        ),
        array(
            'import_file_name'           => __( 'Calm Banner', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/calm-blog/pro-banner/calm-blog-export.xml',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/calm-blog/pro-banner/calm-blog-widgets.wie',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/calm-blog/pro-banner/calm-blog-customizer.dat',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/2021/06/calm-blog-pro-banner.png',
            'preview_url'                => 'https://crafthemes-demo.com/calm-blog-pro-three/',
            'premium_url'                => $premium_buy_url,
        ),
        array(
            'import_file_name'           => __( 'Calm Slider', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/calm-blog/pro-slider/calm-blog-export.xml',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/calm-blog/pro-slider/calm-blog-widgets.wie',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/calm-blog/pro-slider/calm-blog-customizer.dat',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/2021/06/calm-blog-violet.png',
            'preview_url'                => 'https://crafthemes-demo.com/calm-blog-pro-two/',
            'premium_url'                => $premium_buy_url,
        ),array(
            'import_file_name'           => __( 'Calm Default', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/calm-blog/pro-default/calm-blog-export.xml',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/calm-blog/pro-default/calm-blog-widgets.wie',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/calm-blog/pro-default/calm-blog-customizer.dat',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/2021/06/calm-blog-screenshot.png',
            'preview_url'                => 'https://crafthemes-demo.com/calm-blog-pro/',
            'premium_url'                => $premium_buy_url,
        ),
    );
}
