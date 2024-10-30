<?php

function CT_CTDI_import_files() {

    $premium_buy_url = 'https://www.crafthemes.com/theme/writer-blog-pro/';

    return array(
        array(
            'import_file_name'           => __( 'Free Version', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://crafthemes.com/xml/writer-demo.xml',
            'import_widget_file_url'     => 'https://crafthemes.com/xml/writer-widgets.wie',
            'import_customizer_file_url' => 'http://crafthemes.com/xml/writer-blog-export.dat',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/edd/2018/12/writer-pro.jpg',
            'preview_url'                => 'https://crafthemes-demo.com/writer-blog/',
        ),
        array(
            'import_file_name'           => __( 'Fully Customized', 'ct-ctdi' ),
            'categories'                 => array( 'Blog' ),
            'import_file_url'            => 'https://crafthemes.com/xml/writer-demo.xml',
            'import_widget_file_url'     => 'https://crafthemes.com/xml/writer-pro-widgets.wie',
            'import_customizer_file_url' => 'http://crafthemes.com/xml/writer-blog-pro-export.dat',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/edd/2018/12/writer-pro.jpg',
            'preview_url'                => 'https://www.crafthemes-demo.com/writer-pro/wp-admin/customize.php?url=http%3A%2F%2Fwww.crafthemes.com%2Fthemes%2Fwriter-pro%2F',
            'premium_url'                => $premium_buy_url,
        ),
    );
}
