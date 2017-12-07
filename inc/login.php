<?php
$op = new operation();
$init = $op->init();
if ($init['state'] == 1) {
    $sql = "SELECT id FROM album where id= ?";
    $sqlState = $op->sqlSelect($sql, $id);
    if ($sqlState['state'] == 1) {
        require_once APP_PATH."wechat.class.php";
        $wechat = new wechat("wxbd1f588134ac8258", "658927c15c768c847bb4512800e58710");

        $wechatJssdk = array(
            "appId" => $wechat->appId,
            "timestamp" => $wechat->timestamp,
            "nonceStr" => $wechat->get_noncestr(),
            "signature" => $wechat->get_jssk_signature(),
        );

        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $wechatShare = array(
            "title" => "Time-Capsule",
            "desc" => "帮你留住大学的时光",
            "link" => $protocol.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI],
            "imgurl" => "http://p1.bqimg.com/501024/0191ace9c6977b62.jpg",
        );
        if (!empty($sqlState['msg'])) {
            include(APP_PATH."default.php");
        } else {
            $sql = "insert `album`(`id`,`count`) values(?, 0);";
            $sqlState = $op->sqlExce($sql, $id);
            if ($sqlState['state'] == 1) {
                include(APP_PATH."default.php");
                exit;
            } else {
                $error = array(
                    "state" => -202,
                    "errmsg" => $sqlState,
                );
                errorE::outputHtml($error);
            }
        }
    } else {
        $error = array(
            "state" => -201,
            "errmsg" => $sqlState,
        );
        errorE::outputHtml($error);
    }
} else {
    $error = array(
        "state" => -200,
        "errmsg" => $init,
    );
    errorE::outputHtml($error);
}