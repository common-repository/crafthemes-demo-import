<?php

function CT_CTDI_import_files() {

    $premium_buy_url = 'https://www.crafthemes.com/theme/apex-dentist-pro/';

    return array(
        array(
            'import_file_name'           => __( 'Free Version', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/dentist/free/free.xml',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/dentist/free/free.wie',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/dentist/free/free.dat',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/2022/12/crafthemes-demo-com-1200x900desktop-a0311f.jpg',
            'additional_plugin'          => 'smart-slider-3, elementor, elegant-addons-for-elementor',
            'preview_url'                => 'https://www.crafthemes-demo.com/demo/apex-dental',
        ),
        array(
            'import_file_name'           => __( 'Premium Ceative', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/dentist/pro-creative/pro.xml',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/dentist/pro-creative/pro.dat',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/dentist/pro-creative/pro.wie',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/2022/12/crafthemes-demo-com-1200x900desktop-4fa978.jpg',
            'preview_url'                => 'https://www.crafthemes-demo.com/demo/apex-dental-premium-2/',
            'additional_plugin'          => 'elementor, elegant-addons-for-elementor-premium',
            'premium_url'                => $premium_buy_url,
        ),
        array(
            'import_file_name'           => __( 'Premium Classic', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/dentist/pro-classic/pro-classic.xml',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/dentist/pro-classic/pro-classic.dat',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/dentist/pro-classic/pro-classic.wie',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/2022/12/crafthemes-demo-com-1200x900desktop-9ad513.jpg',
            'additional_plugin'          => 'smart-slider-3, elementor, elegant-addons-for-elementor-premium',
            'preview_url'                => 'https://www.crafthemes-demo.com/demo/apex-dental-premium',
            'premium_url'                => $premium_buy_url,
        ),
    );
}
