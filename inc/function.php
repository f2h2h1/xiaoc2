<?php
//用于post数据的curl函数
function httpRequest($url, $data = null) {
    $result = array();
    if (!empty($url)) {
        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            if (!empty($data)) {
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($curl);
            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if ($http_status == 200) {
                $result = array(
                    "state" => 1,
                    "msg" => $output,
                );
            } else {
                $result = array(
                    "state" => -1,
                    "msg" => "http_status != 200",
                );
            }
        } catch(PDOException $e) {
            $result = array(
                "state" => -2,
                "msg" => $e,
            );
        }
    } else {
        $result = array(
            "state" => -3,
            "msg" => "url is empty",
        );
    }
    return $result;
}
function httpRequestFile($url, $filesrc, $filetype, $filename, $data = null) {
    $result = array();
    if (!empty($url) && !empty($filesrc) && !empty($filetype) && !empty($filename)) {
        $cfile = curl_file_create($filesrc, $filetype, $filename);
        if ($data == null || is_array($data)) {
            if ($data == null) {
                $data = array("file" => $cfile);
            } else {
                $data['file'] = $cfile;
            }
            $result = httpRequest($url, $data);
        } else {
            $result = array(
                "state" => -2,
                "msg" => "\$data is not a array",
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

function sql_exce($dbh, $sql, $user) {
    $result = array();
    $sth = $dbh->prepare($sql);
    if ($sth->execute(array($user))) { 
        $row = $sth->fetch(PDO::FETCH_BOTH);
        $result = array(
            "state" => 1,
            "msg" => $row,
        );
    } else {
        $result = array(
            "state" => -2,
            "msg" => "a sql statement execution failed",
        );
    }
    return $result;
}
function output_error($errcode = -99, $errmsg = "unexpected error") {
    $error = array();
    $error = array(
        "errcode" => $errcode,
        "errmsg" => $errmsg,
    );
    include(APP_PATH."error.php");
    exit;
}