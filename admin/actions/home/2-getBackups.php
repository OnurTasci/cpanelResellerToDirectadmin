<div id="backupsList"  style="display: none;" class="col-md-12">
    <button type="button" style="display:none;" class="importbackups btn btn-primary mt-3 mb-3">IMPORTING BACKUPS</button>
    <table class="table table-striped table-bordered" id="tableBackupsList">
        <thead>
        <tr>
            <th></th>
            <th>User</th>
            <th>Domain</th>
            <th>Used Disk</th>
            <th>Backup Size</th>
            <th>Status</th>
            <th>Operation</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <button type="button" style="display:none;" class="importbackups btn btn-primary mt-3 mb-3">IMPORTING BACKUPS</button>

    <div class="progress mt-3">
        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: 1%"></div>
    </div>

</div>

<script>



    function checkAllBakcup (username=false,tableBackupsListBa) {

        var users = [];
        var totalusers = 0;

        if (username){
            users.push(username);
        }else{
            $.each(tableBackupsListBa.column(0).checkboxes.selected(), function(index, host){
                users.push(host);
            });
        }

        totalusers = users.length;

        $.ajax({
            type: "POST",
            url: "<?=$REQUEST_URI?>&actionPost=checkBackups",
            data: "users=" + users,
            success: function (data) {
                var json = $.parseJSON($(data).find('#cpanelMigratorJson').html());
                if (json.status == "success") {

                    var propCount = 0;
                    $.each(json.users, function( index, value ) {
                        propCount++;
                        $('*[data-user="'+index+'"]').parent().parent().find('td:nth-child(6)').html(value.name);
                        $('*[data-user="'+index+'"]').parent().parent().find('td:nth-child(5)').html(value.size);
                        $('*[data-user="'+index+'"]').parent().parent().find('td:nth-child(7)').html('<button data-takenuser="'+index+'" disabled class="btn btn-success">Backup Taken</button>');
                    });


                    var successPro = Math.floor(propCount / ( totalusers / 100 ));
                    $('.progress-bar').attr('style','width: '+successPro+'%');
                    if(successPro == 100){
                        $('.importbackups').attr('style','display: block; !important');
                    }

                } else {

                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: json.msg,
                        showConfirmButton: false,
                        timer: 2500
                    })

                }

            }
        });

    }

    $(document).on("click", ".checkBackupUser", function(event) {
        event.preventDefault();
        Swal.fire({
            position: 'top-end',
            title: 'Transfer is automatically checked every 10 seconds',
            showConfirmButton: false,
            timer: 2500
        })
    });

    $(document).on("click", ".importbackups", function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28b62c',
            cancelButtonColor: '#d33',
            confirmButtonText: 'İmport!'
        }).then((result) => {
            if (result.value) {
                window.location.href = "<?=$REQUEST_URI?>&action=import";
            }
        })
    });

    $(document).on("click", ".retryBackupUser", function(event) {

        event.preventDefault();

        var hostname = $("#hostname").val();
        var password = btoa($("#password").val());
        var username = $("#username").val();
        var port = $("#port").val();
        var ssl = $("#ssl").val();

        var host = $(this).data('retryuser');

        $.ajax({
            type: "POST",
            url: "<?=$REQUEST_URI?>&actionPost=getBackups",
            data: "host=" + host + "&username=" + username + "&hostname=" + hostname + "&password=" + password + "&port=" + port + "&ssl=" + ssl,
            success: function (data) {
                var json = $.parseJSON($(data).find('#cpanelMigratorJson').html());
                if (json.status == "success") {

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: json.msg,
                        showConfirmButton: false,
                        timer: 1500
                    })


                    $('*[data-retryuser="'+host+'"]').parent().parent().find('td:nth-child(6)').html('<div class="spinner-border text-primary m-1" style=" width: 1rem !important; height: 1rem !important; "></div> Transferred');
                    $('*[data-retryuser="'+host+'"]').parent().parent().find('td:nth-child(1)').html('<input type="checkbox" class="checkBackupFinis" checked="checked" name="backup['+host+']" data-username="'+host+'" readonly>');
                    $('*[data-retryuser="'+host+'"]').parent().parent().find('td:nth-child(7)').html('<button data-user="'+host+'" class="checkBackupUser btn btn-warning">Check Transfer</button>');
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: json.msg,
                        showConfirmButton: false,
                        timer: 2500
                    })
                }

            }
        });

    });


</script>