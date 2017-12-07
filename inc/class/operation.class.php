<?php
class operation extends database {
    function uploadPciturToTietukuWeb($fileurl) {
        $url = "http://up.tietuku.com/";
        $data = array(
            "Token" => TIETUKU_WEB_TOKEN,
            "fileurl" => $fileurl,
        );
        $response = parent::httpRequest($url, $data);
        $result = array();
        if ($response['state'] == 1) {
            $url_arr = json_decode($response['msg'], true);
            if (!empty($url_arr['s_url']) &&
                !empty($url_arr['t_url']) &&
                !empty($url_arr['linkurl']) &&
                !empty($url_arr['width']) &&
                !empty($url_arr['height'])) {

                unset($url_arr['ubburl']);
                unset($url_arr['htmlurl']);
                unset($url_arr['markdown']);

                $pic_index = md5($url_arr['s_url'].time());
                $pic = array($pic_index=>$url_arr);

                $result = array(
                    "state" => 1,
                    "msg" => $pic,
                );

            } else {
                $result = array(
                    "state" => -1,
                    "msg" => "curl response error parameter",
                );
            }
        } else {
            $result = array(
                "state" => -1,
                "msg" => $response,
            );
        }
        return $result;
    }
    function uploadPciturToTietukuLocal($filesrc, $filetype, $filename) {
        $url = "http://up.tietuku.com/";
        $data = array(
            "Token" => TIETUKU_LOCAL_TOKEN,
        );
        $response = parent::httpRequestFile($url, $filesrc, $filetype, $filename, $data);
        $result = array();
        if ($response['state'] == 1) {
            $url_arr = json_decode($response['msg'], true);
            if (!empty($url_arr['s_url']) &&
                !empty($url_arr['t_url']) &&
                !empty($url_arr['linkurl']) &&
                !empty($url_arr['width']) &&
                !empty($url_arr['height'])) {

                unset($url_arr['ubburl']);
                unset($url_arr['htmlurl']);
                unset($url_arr['markdown']);

                $pic_index = md5($url_arr['s_url'].time());
                $pic = array($pic_index=>$url_arr);
                
                $result = array(
                    "state" => 1,
                    "msg" => $pic,
                );

            } else {
                $result = array(
                    "state" => -1,
                    "msg" => "curl response error parameter",
                );
            }
        } else {
            $result = array(
                "state" => -1,
                "msg" => $response,
            );
        }
        return $result;
    }
    function uploadPciturToAsync($filesrc, $filetype, $filename) {
        $url = ASYNC_URL;
        $timestamp = time();
        $norstr = parent::getNoncestr();
        $work = "upload";
        $signature = md5(sha1(md5($timestamp).$norstr).$work);
        $url = $url."/?".$work."/".$timestamp."/".$norstr."/".$signature;
        
        $response = parent::httpRequestFile($url, $filesrc, $filetype, $filename);
        $result = array();
        if ($response['state'] == 1) {
            $pic = json_decode($response['msg'], true);
            $pic = $pic['msg'];
            $result = array(
                "state" => 1,
                "msg" => $pic,
            );
        } else {
            $result = array(
                "state" => -1,
                "msg" => $response,
            );
        }
        return $result;
    }
    function uploadPcitur($filesrc, $filetype, $filename) {
        $response = self::uploadPciturToTietukuLocal($filesrc, $filetype, $filename);
        if ($response['state'] == 1) {
            $result = $response;
        } else {
            $response = self::uploadPciturToAsync($filesrc, $filetype, $filename);
            $result = $response;
        }
        return $result;
    }
    function updataAlbum($id, $pic) {
        $sql = "SELECT count,url FROM album where id= ?";
        $sqlState = parent::sqlSelect($sql, $id);
        if ($sqlState['state'] == 1) {
            if (!empty($sqlState['msg'])) {
                $row = $sqlState['msg'];
                if (!empty($row['url'])) {
                    $temp_arr = json_decode($row['url'], true);
                    array_push($temp_arr, $pic);
                } else {
                    $temp_arr = array();
                    array_push($temp_arr, $pic);
                }
                $url = json_encode($temp_arr, JSON_UNESCAPED_SLASHES);
                $url = str_replace("'", "\\'", $url);

                $count = empty($row['count'])?0:$row['count'];
                $count++;

                $sql = "update `album` set `url`=?, `count`=? where `id`=?;";
                $sqlState = parent::sqlExce($sql, array($url, $count, $id));

                if ($sqlState['state'] == 1) {
                    $url_json = json_encode($pic, JSON_UNESCAPED_SLASHES);
                    $url_json = str_replace("'", "\\'", $url_json);
                    $result = array(
                        'state' => '1',
                        'msg' => $url_json,
                        'sql' => $sql,
                    );
                } else {
                    $result = array(
                        'state' => '-3',
                        'msg' => 'false',
                        'sql' => $sql,
                        'errmsg' => 'a sql statement execution failed',
                    );
                }
            } else {
                $result = array(
                    'state' => '-2',
                    'msg' => 'false',
                    'errmsg' => 'there is a parameter for the empty',
                    'sql' => $sql,
                );
            }
        } else {
            $result = array(
                'state' => '-1',
                'msg' => 'false',
                'errmsg' => 'a sql statement execution failed',
            );
        }
        return $result;
    }
    function updataAlbumWait($linkurl, $pic_index, $from) {
        $sql = "INSERT INTO `album_wechat`.`album_wait` (`linkurl`, `pic_index`, `from`) VALUES (?, ?, ?);";
        $sqlState = parent::sqlExce($sql, array($linkurl, $pic_index, $from));
        if ($sqlState['state'] == 1) {
            $result = array(
                'state' => '1',
                'msg' => $sqlState,
            );
        } else {
            $result = array(
                'state' => '-3',
                'msg' => 'false',
                'sql' => $sql,
                'errmsg' => 'a sql statement execution failed',
            );
        }
        return $result;
    }
}