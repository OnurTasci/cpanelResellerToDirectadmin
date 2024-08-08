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

try {

    $cpanel = new \Gufy\CpanelPhp\Cpanel($requestArray);
    $cpanel->setTimeout(5000);
    $requestAccounts = $cpanel->listaccts();

    $result = @explode('"',@explode('"error":"',$requestAccounts)[1])[0];

    if(!empty($result)){
        $data = [
            'status' => 'error',
            'msg' => $result,
        ];
    }else{
        $data = [
            'status' => 'success',
            'msg' => 'Brought a hosting list',
            'listaccts' => $requestAccounts
        ];
    }


} catch (\Exception $e) {

    $data = [
        'status' => 'error',
        'msg' => $e->getMessage()
    ];

}

echo json_encode($data);
