<?php
function CT_CTDI_import_files() {

    $theme = wp_get_theme();
    $theme_name = $theme->get('TextDomain');

    $url = "http://demo.crafthemes.com/import/manager/demo-import-api/read.php?load=demos&text_domain={$theme_name}";
    $importUrl = "https://dc.crafthemes.com/{$theme_name}/";
    $response = wp_remote_get($url);

    if (is_array($response)) {
        $headers = $response['headers']; // Response headers.
        $body    = $response['body'];    // Response body.
        $code    = $response['response']['code'];    // Response code.

        $result = json_decode($body, true);

        $return_array = array();
        foreach ($result as $item) {
            $array = array();
            $array['import_file_name'] = $item['import_file_name'];
            $array['categories'] = $item['categories'];
            $array['import_file_url'] = $importUrl . $item['import_file_url'];
            $array['import_widget_file_url'] = $importUrl . $item['import_widget_file_url'];
            $array['import_customizer_file_url'] = $importUrl . $item['import_customizer_file_url'];
            $array['import_preview_image_url'] = $importUrl . $item['import_preview_image_url'];
            $array['additional_plugin'] = $item['additional_plugins'];
            $array['preview_url'] = $item['preview_url'];
            $array['premium_url'] = $item['premium_url'];

            array_push($return_array, $array);
        }
    }

    return $return_array;
}
