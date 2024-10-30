<?php

function CT_CTDI_import_files() {

    $premium_buy_url = 'https://www.crafthemes.com/dreamer-pro/';

    return array(
        array(
            'import_file_name'           => __( 'Free Version', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/dreamer-blog/free/dreamer-blog-export.xml',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/dreamer-blog/free/dreamer-blog-widgets.wie',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/dreamer-blog/free/dreamer-blog-customizer.dat',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/2021/04/dreamer-screenshot-free.png',
            'preview_url'                => 'https://www.crafthemes.com/go/dreamer-blog',
        ),
        array(
            'import_file_name'           => __( 'Premium Default', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/dreamer-blog/pro-default/dreamer-blog-premium-export.xml',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/dreamer-blog/pro-default/dreamer-blog-premium-customizer.dat',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/dreamer-blog/pro-default/dreamer-blog-premium-widgets.wie',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/2021/04/dreamer-screenshot1.png',
            'preview_url'                => 'https://crafthemes-demo.com/dreamer-blog-pro/',
            'premium_url'                => $premium_buy_url,
        ),
        array(
            'import_file_name'           => __( 'Premium Banner', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://dc.crafthemes.com/dreamer-blog/pro-banner/dreamer-blog-premium-export.xml',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/dreamer-blog/pro-banner/dreamer-blog-premium-customizer.dat',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/dreamer-blog/pro-banner/dreamer-blog-premium-widgets.wie',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/2021/04/dreamer-blog-banner.png',
            'preview_url'                => 'https://crafthemes-demo.com/dreamer-blog-pro/',
            'premium_url'                => $premium_buy_url,
        ),
    );
}
