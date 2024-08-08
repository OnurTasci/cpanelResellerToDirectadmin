<div class="col-md-12">
    <h2>Migrator</h2>
    <p>To take hosting from the WHM Panel, simply enter the whm panel information in the field below and then click the Show List button.</p>
</div>
<?php

include __DIR__.'/home/0-ftpCheck.php';

if($ftpConnect){
    include __DIR__.'/home/1-showList.php';
    include __DIR__.'/home/2-getBackups.php';
}else{
    ?>
    <div class="col-lg-8 m-auto">
        <div class="bs-component">
            <div class="alert alert-dismissible alert-danger">
                <strong>Oh snap!</strong> The ftp account is required to take backups to the server. <a href="<?=$REQUEST_URI?>&action=settings" class="alert-link">Settings</a>
            </div>
        </div>
    </div>
<?php } ?>
