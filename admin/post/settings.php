<?php

try {

    $env = [
        'server' => $_POST['server'],
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'port' => $_POST['port'],
        'dir' => $_POST['dir'],
        'mail' => $_POST['mail'],
    ];

    $conn_id = ftp_connect($env['server'], $env['port']);
    $login_result = @ftp_login($conn_id, $env['username'], $env['password']);
    if ((!$conn_id) || (!$login_result)) {
        echo json_encode([
            'status' => 'error',
            'msg' => 'Failed to connect to ftp'
        ]);
        exit;
    }
    ftp_close($conn_id);

    $fp = fopen(dirname(__DIR__).'/../.env', 'w');
    $pross = fwrite($fp, json_encode($env));
    fclose($fp);
    if($pross){
        $data = [
            'status' => 'success',
            'msg' => 'Settings saved',
        ];
    }

} catch (\Exception $e) {

    $data = [
        'status' => 'error',
        'msg' => $e->getMessage()
    ];

}

echo json_encode($data);