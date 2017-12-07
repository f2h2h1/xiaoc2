<?php
class errorE {
    /*
    function output($errcode = -99, $errmsg = "unexpected error", $e = null, $style = null) {
        if ($style == null || $style = "html") {
            self::outputHtml($errcode, $errmsg, $e);
        } else {
            self::outputJson($errcode, $errmsg, $e);
        }
    }
    function outputHtml($errcode = -99, $errmsg = "unexpected error", $e = null) {
        $error = array();
        $error = array(
            "errcode" => $errcode,
            "errmsg" => $errmsg,
        );
        if (DEBUG) {
            $error['e'] = $e;
        }
        include(APP_PATH."error.php");
        exit;
    }
    function outputJson($errcode = -99, $errmsg = "unexpected error", $e = null) {
        $error = array();
        $error = array(
            "errcode" => $errcode,
            "errmsg" => $errmsg,
        );
        if (DEBUG) {
            $error['e'] = $e;
        }
        die(json_encode($error, JSON_UNESCAPED_SLASHES));
    }
    */
    function output($result = null, $style = null) {
        if (DEBUG) {
            $error = $result;
        } else {
            $error['state'] = empty($result['state']) ? -999 : $result['state'];
        }
        $error['msg'] = empty($result['msg']) ? "unexpected error" : $result['msg'];
        
        if ($style == "html") {
            include(APP_PATH."error.php");
            exit;
        } else {
            die(json_encode($error, JSON_UNESCAPED_SLASHES));
        }
    }
    function outputHtml($result) {
        self::output($result, "html");
    }
    function outputJson($result) {
        self::output($result, "json");
    }
}