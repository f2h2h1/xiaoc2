<?php
class verification {
    function verifyEntrance($parameter) {
        $work = $parameter[0];
        $timestamp = $parameter[1];
        $norstr = $parameter[2];
        $signature = $parameter[3];
        $result = array();
        if (!empty($work) && !empty($timestamp) && !empty($norstr) && !empty($signature)) {
            if (is_numeric($timestamp) && (time() - $timestamp) < 300) {
                if (strlen($norstr) == 16) {
                    if (md5(sha1(md5($timestamp).$norstr).$work) == $signature) {
                        $result = array(
                            "state" => 1,
                            "msg" => "valid signature",
                        );
                    } else {
                        $result = array(
                            "state" => -4,
                            "msg" => "invalid signature",
                        );
                    }
                } else {
                    $result = array(
                        "state" => -3,
                        "msg" => "invalid parameter",
                    );
                }
            } else {
                $result = array(
                    "state" => -2,
                    "msg" => "timestamp timeout",
                );
            }
        } else {
            $result = array(
                "state" => -1,
                "msg" => "there is a parameter for the empty",
            );
        }
        return $result;
    }
}