<div class="col-md-12 p-5">
    <h2>Settings</h2>
    <p>The ftp account is required to take backups to the server.</p>
    <p>You must enter the directory where the backups will be taken and login information</p>
    <?php

    $fp = fopen(dirname(__DIR__).'/../.env', 'r');
    $result = fgets($fp);

    $port = 21;
    $dir = '/';
    if($json = json_decode($result)){

        $username = $json->username;
        $password = $json->password;
        $port = $json->port;
        $dir = $json->dir;
        $mail = $json->mail;


    }

    ?>
    <form method="POST" id="settingsForm" action="">
        <div class="form-group">
            <label for="hostname">Server IP</label>
            <input type="text" class="form-control" id="server" name="server" value="<?=getenv('SERVER_ADDR')?>" readonly>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="" value="<?=$username?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" value="<?=$password?>" placeholder="*********" required>
        </div>
        <div class="form-group">
            <label for="port">Port</label>
            <input type="number" class="form-control" id="port" name="port" value="<?=$port?>" required>
        </div>
        <div class="form-group">
            <label for="username">Folder Directory</label>
            <input type="text" class="form-control" id="dir" name="dir" placeholder="/" value="<?=$dir?>" required>
        </div>
        <hr>
        <div class="form-group">
            <label for="username">cPanel Notification Mail</label>
            <input type="text" class="form-control" id="mail" name="mail" placeholder="info@domain.com" value="<?=$mail?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
<script>

    $("#settingsForm").on("submit", function (event) {
        if (event.isDefaultPrevented()) {
            submitMSG(false);
        } else {
            event.preventDefault();

            var server = $("#server").val();
            var password = $("#password").val();
            var username = $("#username").val();
            var port = $("#port").val();
            var dir = $("#dir").val();
            var mail = $("#mail").val();


            $.ajax({
                type: "POST",
                url: "<?=$REQUEST_URI?>&actionPost=settings",
                data: "dir=" + dir + "&mail=" + mail + "&server=" + server + "&password=" + password + "&username=" + username + "&port=" + port,
                success: function (data) {
                    var json = $.parseJSON($(data).find('#cpanelMigratorJson').html());
                    if (json.status == "success") {
                        submitMSG(true, json.msg);
                    } else {
                        submitMSG(false, json.msg);
                    }
                }
            });

        }
    });

</script>