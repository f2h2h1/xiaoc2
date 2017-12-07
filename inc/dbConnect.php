<?php
    try {// 创建连接
        $dbh = new PDO($dataBaseConfig['sourceName'], $dataBaseConfig['dataBaseUserName'], $dataBaseConfig['dataBasePassWord'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
    } catch(PDOException $e) {// 检测连接
        errorE::output(-2);
    }