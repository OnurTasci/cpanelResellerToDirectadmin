<?php

$fp = fopen(dirname(__DIR__).'/../../.env', 'r');
$result = fgets($fp);
if($json = json_decode($result)){
    $server = $json->server;
    $username = $json->username;
    $password = $json->password;
    $port = $json->port;

    $conn_id = ftp_connect($server, $port);
    $login_result = @ftp_login($conn_id, $username, $password);
    if ((!$conn_id) || (!$login_result)) {
        $ftpConnect = false;
    } else {
        $ftpConnect = true;
    }
    ftp_close($conn_id);
}