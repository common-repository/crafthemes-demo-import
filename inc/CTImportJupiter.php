<?php

function CT_CTDI_import_files() {

    $premium_buy_url = 'https://www.crafthemes.com/theme/jupiter-blog-premium/';
    return array(
        array(
            'import_file_name'           => __( 'Free Version', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/jupiter-blog/free/free.xml',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/jupiter-blog/free/free.wie',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/jupiter-blog/free/free.dat',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/edd/2023/01/juptiter-blog-ss.jpg',
            'additional_plugin'          => 'mailchimp-for-wp',
            'preview_url'                => 'https://www.crafthemes-demo.click/jupiter-blog',
        ),
        array(
            'import_file_name'           => __( 'Premium Default', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/jupiter-blog/pro-default/pro.xml',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/jupiter-blog/pro-default/pro.dat',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/jupiter-blog/pro-default/pro.wie',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/edd/2023/01/crafthemes-demo-click-1300x975desktop-35ef501.png',
            'preview_url'                => 'https://www.crafthemes-demo.click/jupiter-blog-premium-two',
            'additional_plugin'          => 'mailchimp-for-wp, instagram-feed',
            'premium_url'                => $premium_buy_url,
        ),
        array(
            'import_file_name'           => __( 'Premium Banner', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/jupiter-blog/pro-banner/pro-classic.xml',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/jupiter-blog/pro-banner/pro-classic.dat',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/jupiter-blog/pro-banner/pro-classic.wie',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/2023/01/crafthemes-demo-click-1300x975desktop-193b8d1.jpg',
            'additional_plugin'          => 'mailchimp-for-wp, instagram-feed',
            'preview_url'                => 'https://www.crafthemes-demo.click/jupiter-blog-premium',
            'premium_url'                => $premium_buy_url,
        ),
    );
}
