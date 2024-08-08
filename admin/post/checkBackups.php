<?php

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }
    return $bytes;
}

$fp = fopen(dirname(__DIR__).'/../.env', 'r');
$result = fgets($fp);
if($json = json_decode($result)){
    $server = $json->server;
    $username = $json->username;
    $password = $json->password;
    $port = $json->port;
    $dir = $json->dir;


    $conn_id = ftp_connect($server, $port);
    $login_result = @ftp_login($conn_id, $username, $password);

    $file_list = ftp_nlist($conn_id, $dir);

    $bakcupsList = [];

    foreach ($file_list as $file){
        if(strpos($file,'backup-') && strpos($file,'.tar.gz')){
            $bakcupsList[explode('_',explode('.tar.gz',$file)[0])[2]] = [
                'name'=>$file,
                'size' => formatSizeUnits(ftp_size($conn_id, $file))
            ];
        }
    }

    if ((!$conn_id) || (!$login_result)) {
        $ftpConnect = false;
    } else {
        $ftpConnect = true;
    }

}

if($ftpConnect){

    $successBackups = [];

    foreach (explode(',',$_POST['users']) as $user){

        if(isset($bakcupsList[$user])){
            $successBackups[$user] = $bakcupsList[$user];
        }

    }
    $data = [
        'status' => 'success',
        'msg' => 'Backups at ftp',
        'users' => $successBackups
    ];


}else{
    $data = [
        'status' => 'error',
        'msg' => 'Ftp connections error'
    ];
}



ftp_close($conn_id);


echo json_encode($data);

