<?php

function CT_CTDI_import_files() {

    $premium_buy_url = 'https://www.crafthemes.com/theme/spark-news-pro/';

    return array(
        array(
            'import_file_name'           => __( 'Free Version', 'ct-ctdi' ),
            'categories'                 => array( 'News' ),
            'import_file_url'            => 'https://dc.crafthemes.com/spark-news/free/spark-news-export.xml',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/spark-news/free/spark-news-widgets.wie',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/spark-news/free/spark-news-customizer.dat',
            'import_preview_image_url'   => 'https://i0.wp.com/themes.svn.wordpress.org/spark-news/1.1/screenshot.png',
            'preview_url'                => 'https://crafthemes-demo.com/spark-news',
        ),
        array(
            'import_file_name'           => __( 'Premium Default', 'ct-ctdi' ),
            'categories'                 => array( 'News' ),
            'import_file_url'            => 'https://dc.crafthemes.com/spark-news/pro-default/spark-news-export.xml',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/spark-news/pro-default/spark-news-customizer.dat',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/spark-news/pro-default/spark-news-widgets.wie',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/2021/05/spark-news-pro-default.png',
            'preview_url'                => 'https://crafthemes-demo.com/spark-news-pro/',
            'premium_url'                => $premium_buy_url,
        ),
        array(
            'import_file_name'           => __( 'Premium Banner', 'ct-ctdi' ),
            'categories'                 => array( 'News' ),
            'import_file_url'            => 'https://dc.crafthemes.com/spark-news/pro-banner/spark-news-export.xml',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/spark-news/pro-banner/spark-news-customizer.dat',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/spark-news/pro-banner/spark-news-widgets.wie',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/2021/05/spark-news-banner-pro.png',
            'preview_url'                => 'https://crafthemes-demo.com/spark-news-pro-three/',
            'premium_url'                => $premium_buy_url,
        ),
        array(
            'import_file_name'           => __( 'Premium Personal Blog', 'ct-ctdi' ),
            'categories'                 => array( 'Personal' ),
            'import_file_url'            => 'https://dc.crafthemes.com/spark-news/pro-blog/spark-news-export.xml',
            'import_customizer_file_url' => 'https://dc.crafthemes.com/spark-news/pro-blog/spark-news-customizer.dat',
            'import_widget_file_url'     => 'https://dc.crafthemes.com/spark-news/pro-blog/spark-news-widgets.wie',
            'import_preview_image_url'   => 'https://www.crafthemes.com/wp-content/uploads/2021/05/spark-banner-blog-pro.png',
            'preview_url'                => 'https://crafthemes-demo.com/spark-news-pro-two/',
            'premium_url'                => $premium_buy_url,
        ),
    );
}
