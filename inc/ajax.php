<?php
$op = new operation();
$init = $op->init();
if ($init['state'] == 1) {
    $state = $_POST['state'];

    if ($state == "updata") {//插入

        $timestamp2 = $_POST['timestamp2'];
        if (!is_numeric($timestamp2)) {
            $error = array(
                "state" => -106,
                "errmsg" => $_POST,
            );
            errorE::outputJson($error);
        } else {
            if ($_SESSION['timestamp2'] != $timestamp2) {
                $_SESSION['timestamp2'] = $timestamp2;

                $responseTietuku = $op->uploadPciturToTietukuLocal($_FILES['file']['tmp_name'][0], $_FILES['file']['type'][0], $_FILES['file']['name'][0]);
                if ($responseTietuku['state'] == 1) {
                    $pic = $responseTietuku['msg'];
                    $resultUpdataAlbum = $op->updataAlbum($id, $pic);
                    if ($resultUpdataAlbum['state'] == 1) {
                        $result = $resultUpdataAlbum;
                    } else {
                        $error = array(
                            "state" => -209,
                            "errmsg" => array($responseTietuku, $resultUpdataAlbum),
                        );
                        errorE::outputJson($error);
                    }
                } else {
                    $responseAsync = $op->uploadPciturToAsync($_FILES['file']['tmp_name'][0], $_FILES['file']['type'][0], $_FILES['file']['name'][0]);
                    if ($responseAsync['state'] == 1) {
                        $pic = $responseAsync['msg'];
                        
                        $resultUpdataAlbum = $op->updataAlbum($id, $pic);
                        if ($resultUpdataAlbum['state'] == 1) {
                            foreach($pic as $key=>$value);
                            $resultUpdataAlbumWait = $op->updataAlbumWait($pic[$key]['linkurl'], $key, $id);
                            if ($resultUpdataAlbumWait['state'] == 1) {
                                $result = $resultUpdataAlbum;
                            } else {
                                $error = array(
                                    "state" => -208,
                                    "errmsg" => array($responseTietuku, $responseAsync, $resultUpdataAlbum, $resultUpdataAlbumWait),
                                );
                                errorE::outputJson($error);
                            }
                        } else {
                            $error = array(
                                "state" => -207,
                                "errmsg" => array($responseTietuku, $responseAsync, $resultUpdataAlbum),
                            );
                            errorE::outputJson($error);
                        }
                    } else {
                        $error = array(
                            "state" => -300,
                            "errmsg" => array($responseTietuku, $responseAsync),
                        );
                        errorE::outputJson($error);
                    }
                }
            } else {
                exit;
            }
        }
    } elseif ($state == "delete") {//删除
        $pictureIndex = $_POST['pictureIndex'];
        if (!empty($pictureIndex)) {
            $sql = "SELECT count,url FROM album where id=?";
            $sqlState = $op->sqlSelect($sql, $id);
            if ($sqlState['state'] == 1) {
                if (!empty($sqlState['msg'])) {
                    $row = $sqlState['msg'];
                    $url = $row['url'];
                    $count = $row['count'];

                    $count--;
                    $temp_arr = json_decode($url, true);
                    foreach ($temp_arr as $key=>$value) {
                        if (array_key_exists($pictureIndex, $value)) {
                            array_splice($temp_arr, $key, 1);
                            break;
                        }
                    }


                    $url = json_encode($temp_arr, JSON_UNESCAPED_SLASHES);
                    $url = str_replace("'", "\\'", $url);

                    $sql = "update `album` set `url`=?, `count`=? where `id`=?;";
                    $sqlState = $op->sqlExce($sql, array($url, $count, $id));
                    if ($sqlState['state'] == 1) {
                        $result = array(
                            'state' => '1',
                            'msg' => 'delete success',
                        );
                    } else {
                        $error = array(
                            'state' => -206,
                            'errmsg' => $sqlState,
                            'sql' => $sql,
                        );
                        errorE::outputJson($error);
                    }

                } else {
                    $error = array(
                        'state' => -205,
                        'errmsg' => $sqlState,
                        'sql' => $sql,
                    );
                    errorE::outputJson($error);
                }
            } else {
                $error = array(
                    "state" => -204,
                    "errmsg" => $sqlState,
                );
                errorE::outputJson($error);
            }
        } else {
            $error = array(
                "state" => -105,
                "errmsg" => $_POST,
            );
            errorE::outputJson($error);
        }
    } elseif ($state == "load") {//载入


        $sql = "SELECT url FROM album where id= ?";
        $sqlState = $op->sqlSelect($sql, $id);
        if ($sqlState['state'] == 1) {
            $result = array(
                'state' => '1',
                'msg' => $sqlState['msg']['url'],
            );
        } else {
            $error = array(
                "state" => -203,
                "errmsg" => $sqlState,
            );
            errorE::outputJson($error);
        }
    } else {
        $error = array(
            "state" => -104,
            'msg' => 'invalid parameter',
            "errmsg" => $_POST,
        );
        errorE::outputJson($error);
    }
    //输出
    die(json_encode($result, JSON_UNESCAPED_SLASHES));
} else {
    $error = array(
        "state" => -200,
        "errmsg" => $init,
    );
    errorE::outputJson($error);
}

