<?php
function entrance() {
    require 'config.php';
    require CLASS_PATH.'base.class.php';
    require CLASS_PATH.'database.class.php';
    require CLASS_PATH.'operation.class.php';
    $parameter = explode("/", $_SERVER['QUERY_STRING']);
    $id = $parameter[0];
    $signature = $parameter[1];
    if (!empty($id) && !empty($signature) && $signature == md5(sha1(md5(sha1($id.$id.$id))))) {
        $timestamp = time();
        $_SESSION["id"] = $id;
        $_SESSION["timestamp"] = $timestamp;
        $_SESSION["signature"] = $signature;
        $_SESSION["signature2"] = sha1($signature.$timestamp.$id);
        include(APP_PATH."login.php");
    } elseif ($_SERVER['QUERY_STRING'] == "ajax") {
        if (!empty($_SESSION["id"]) && !empty($_SESSION["timestamp"]) && !empty($_SESSION["signature"]) && !empty($_SESSION["signature2"])) {
            $id = $_SESSION["id"];
            $timestamp = $_SESSION["timestamp"];
            $signature = $_SESSION["signature"];
            $signature2 = $_SESSION["signature2"];
            if (is_numeric($timestamp) && $signature2 == sha1($signature.$timestamp.$id)) {
                include(APP_PATH."ajax.php");
            } else {
                $error = array(
                    "state" => -103,
                    "msg" => "invalid parameter",
                    "errmsg" => $_SESSION,
                );
                errorE::outputJson($error);
            }
        } else {
            $error = array(
                "state" => -102,
                "msg" => "invalid parameter",
                "errmsg" => array($_SERVER['QUERY_STRING'], $_SESSION),
            );
            errorE::outputJson($error);
        }
    } else {
        $error = array(
            "state" => -101,
            "msg" => "invalid parameter",
            "errmsg" => $_SERVER['QUERY_STRING'],
        );
        errorE::output($error);
    }
}