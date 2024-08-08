<?php

require_once $DIR.'/../vendor/autoload.php';

$protocol = 'http';
if(isset($_POST['ssl'])){
    $protocol .= 's';
}

$requestArray = [
    'host'      => $protocol.'://'.$_POST['hostname'].':'.$_POST['port'].'',
    'username'  => $_POST['username'],
    'auth_type' => 'password',
    'password'  => base64_decode($_POST['password']),
];


$fp = fopen(dirname(__DIR__).'/../.env', 'r');
$result = fgets($fp);
$port = 21;
if($json = json_decode($result)){

    $server = $json->server;
    $username = $json->username;
    $password = $json->password;
    $port = $json->port;
    $dir = $json->port;
    $mail = $json->mail;

}

try {

    $cpanel = new \Gufy\CpanelPhp\Cpanel($requestArray);
$cpanel=$cpanel->setTimeout(5000);

    $user = $_POST['host'];
    $createBackup = $cpanel->execute_action('3',
        'Backup', 'fullbackup_to_ftp',
        $user,
        [
//            'variant'   => 'active',
	    'variant'   => 'passive',
            'username'  => $username,
            'password'  => $password,
            'host'      => $server,
            'port'      => $port,
            'directory' => $dir,
            'email'     => $mail,
        ]);


    if($createBackup['result']['status'] == '1'){

        $data = [
            'status' => 'success',
            'msg' => ucwords($user).' hosting backup command sent',
            'result' => $createBackup
        ];

    }else{

        $data = [
            'status' => 'error',
            'msg' => implode($createBackup['result']['errors'],',')
        ];
    }

} catch (\Exception $e) {
    $data = [
        'status' => 'error',
        'msg' => $e->getMessage()
    ];
}

echo json_encode($data);
