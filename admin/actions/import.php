<?php


$result = '';
$result .= shell_exec('echo "Starting.."');
//$result .= shell_exec('rm -rf /home/admin/converted_backups/*.tar.gz');
//$result .= shell_exec('for i in \'ls /home/admin/all_backups/\'; do { /bin/sh /usr/local/directadmin/scripts/cpanel_to_da/cpanel_to_da.sh /home/admin/all_backups/$i /home$');
$result .= shell_exec('echo "End.."');
echo "<pre class='w-100'>$result</pre>";

/*
require_once $DIR.'/../vendor/autoload.php';

$process = new \Symfony\Component\Process\Process(['/usr/local/bin/php', 'll']);
$process->run();

// executes after the command finishes
if (!$process->isSuccessful()) {
    throw new ProcessFailedException($process);
}

echo $process->getOutput();

/*

$process = new \Symfony\Component\Process\Process('ls -lsa');
$process->start();

foreach ($process as $type => $data) {
    if ($process::OUT === $type) {
        echo "\nRead from stdout: ".$data;
    } else { // $process::ERR === $type
        echo "\nRead from stderr: ".$data;
    }
}

/*
$process = new \Symfony\Component\Process\Process(['ls', '-lsa']);

$process->start();
$iterator = $process->getIterator($process::ITER_SKIP_ERR | $process::ITER_KEEP_OUTPUT);
echo "<pre class='w-100'>";
foreach ($iterator as $data) {
    echo $data."\n";
}
echo "</pre>";

*/
/*
$result = '';
$result .= shell_exec('echo "Starting.."');
//$result .= shell_exec('rm -rf /home/admin/converted_backups/*.tar.gz');
//$result .= shell_exec('for i in \'ls /home/admin/all_backups/\'; do { /bin/sh /usr/local/directadmin/scripts/cpanel_to_da/cpanel_to_da.sh /home/admin/all_backups/$i /home$');
$result .= shell_exec('echo "End.."');
echo "<pre class='w-100'>$result</pre>";
*/