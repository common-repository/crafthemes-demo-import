<?php

function CT_CTDI_import_files() {

    $premium_buy_url = 'https://www.crafthemes.com/theme/periar-pro/';

    return array(
        array(
            'import_file_name'           => __( 'Free Version', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/periar/free/periar-export.xml',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/periar/free/periar-widgets.wie',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/periar/free/periar-customizer.dat',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/edd/2021/01/screenshot-1.png',
            'preview_url'                => 'https://www.crafthemes.com/go/periar-demo',
        ),
        array(
            'import_file_name'           => __( 'Premium Banner', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/periar/pro-banner/periar-export.xml',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/periar/pro-banner/periar-customizer.dat',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/periar/pro-banner/periar-widgets.wie',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/2021/01/periar-banner.jpg',
            'preview_url'                => 'https://crafthemes-demo.com/periar-banner-pro/',
            'premium_url'                => $premium_buy_url,
        ),
        array(
            'import_file_name'           => __( 'Premium Default', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/periar/pro/periar-export.xml',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/periar/pro/periar-customizer.dat',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/periar/pro/periar-widgets.wie',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/2021/01/periar-pro-default.jpg',
            'preview_url'                => 'https://www.crafthemes.com/go/periar-pro-demo',
            'premium_url'                => $premium_buy_url,
        ),
        array(
            'import_file_name'           => __( 'Premium Slider', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/periar/pro-slider/periar-export.xml',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/periar/pro-slider/periar-customizer.dat',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/periar/pro-slider/periar-widgets.wie',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/2021/01/periar-banner.png',
            'preview_url'                => 'https://crafthemes-demo.com/periar-slider-pro/',
            'premium_url'                => $premium_buy_url,
        ),
    );
}
