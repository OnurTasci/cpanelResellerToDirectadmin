<?php
class Helper {

    public static function parseGET() {
        $_GET = array();
        $QUERY_STRING = getenv('QUERY_STRING');
        if ($QUERY_STRING != '') {
            parse_str(html_entity_decode($QUERY_STRING), $get_array);
            foreach ($get_array as $key => $value) {
                $_GET[urldecode($key)] = urldecode($value);
            }
        }
        return $_GET;
    }

    public static function parsePOST() {
        $_POST = array();
        $POST_STRING = getenv('POST');
        if ($POST_STRING != '') {
            parse_str(html_entity_decode($POST_STRING), $post_array);
            foreach ($post_array as $key => $value) {
                if (is_array($value)) {
                    $_POST[urldecode($key)] = array();
                    foreach ($value as $valueKey => $arrayValue) {
                        $_POST[urldecode($key)][$valueKey] = urldecode($arrayValue);
                    }
                } else {
                    $_POST[urldecode($key)] = urldecode($value);
                }
            }
        }
        return $_POST;
    }
}
?>
