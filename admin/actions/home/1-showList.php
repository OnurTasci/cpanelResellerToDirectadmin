<div class="col-md-4" id="whmInfo">
    <form method="POST" id="showList" action="">
        <div class="form-group">
            <label for="hostname">Source cPanel Hostname or IP</label>
            <input type="text" class="form-control" id="hostname" name="hostname"
                   placeholder="Ex: tr1.burtinet.com OR 195.192.100.43" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="*********" required>
        </div>
        <div class="form-group">
            <label for="port">Port</label>
            <input type="number" class="form-control" id="port" name="port" value="2087" required>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="ssl" name="ssl" checked>
            <label class="form-check-label" for="ssl">SSL Connection</label>
        </div>
        <button type="submit" class="btn btn-primary">Show List</button>
    </form>
</div>
<div class="col-md-8 table-responsive" id="hostingInfo">
    <button type="button" style="display:none;" class="getbackups btn btn-primary mt-3 mb-3">GET BACKUPS</button>
    <table class="table table-striped table-bordered"  id="datatableList">
        <thead>
        <tr>
            <th></th>
            <th>User</th>
            <th>Domain</th>
            <th>Used Disk</th>
            <th>IP</th>
            <th>Owner</th>
            <th>Plan</th>
            <th>Suspended?</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <button type="button" style="display:none;" class="getbackups btn btn-primary mt-3 mb-3">GET BACKUPS</button>
</div>
<script>

    $("#showList").on("submit", function (event) {
        if (event.isDefaultPrevented()) {
            submitMSG(false);
        } else {
            event.preventDefault();

            var hostname = $("#hostname").val();
            var password = btoa($("#password").val());
            var username = $("#username").val();

            var port = $("#port").val();
            var ssl = $("#ssl").val();

            $.ajax({
                type: "POST",
                url: "<?=$REQUEST_URI?>&actionPost=showList",
                data: "username=" + username + "&hostname=" + hostname + "&password=" + password + "&port=" + port + "&ssl=" + ssl,
                success: function (data) {
                    var json = $.parseJSON($(data).find('#cpanelMigratorJson').html());

                    if (json.status == "success") {
                        submitMSG(true, json.msg);

                        $('#whmInfo').attr('style','display: none !important');
                        $('#hostingInfo').removeClass('col-md-8');
                        $('#hostingInfo').addClass('col-md-12');

                        var suspended = '';
                        $("#datatable tbody").empty();

                        $.each( json.listaccts.acct, function( index, value ){

                            suspended = '';
                            if(value.suspended == 1) { suspended = 'table-warning'; }

                            $('#datatableList tbody').append(
                                '<tr class="'+suspended+'" id="user_'+value.user+'" >' +
                                '<td>'+value.user+'</td>' +
                                '<td>'+value.user+'</td>' +
                                '<td>'+value.domain+'</td>' +
                                '<td>'+value.diskused+'</td>' +
                                '<td>'+value.ip+'</td>' +
                                '<td>'+value.owner+'</td>' +
                                '<td>'+value.plan+'</td>' +
                                '<td>'+value.suspendreason+'</td>' +
                                '</tr>'
                            );
                        });
                        $('.getbackups').attr('style','display: block !important');

                        tableGenerator()

                    } else {
                        submitMSG(false, json.msg);
                    }
                }
            });




            function tableGenerator(){
                var datatableList = $('#datatableList').DataTable({
                    'columnDefs': [
                        {
                            'targets': 0,
                            'checkboxes': {
                                'selectRow': true
                            }
                        }
                    ],
                    'select': {
                        'style': 'multi'
                    },
                    'order': [[1, 'asc']]
                });
                $(".getbackups").click(function (event) {
                    if (event.isDefaultPrevented()) {
                        submitMSG(false);
                    } else {
                        event.preventDefault();

                        $('#backupsList').attr('style','display: block !important');
                        $('#hostingInfo').attr('style','display: none !important');

                        var tableBackupsListBa = $('#tableBackupsList').DataTable({
                            'columnDefs': [
                                {
                                    'targets': 0,
                                    'checkboxes': {
                                        'selectRow': true
                                    }
                                }
                            ],
                            'select': {
                                'style': 'multi'
                            },
                            'order': [[1, 'asc']]
                        });

                        var hostname = $("#hostname").val();
                        var password = btoa($("#password").val());
                        var username = $("#username").val();
                        var port = $("#port").val();
                        var ssl = $("#ssl").val();


                        $.each(datatableList.column(0).checkboxes.selected(), function(index, host){

                            var hostDetails = datatableList.$('#user_'+host);

                            $.ajax({
                                type: "POST",
                                url: "<?=$REQUEST_URI?>&actionPost=getBackups",
                                data: "host=" + host + "&username=" + username + "&hostname=" + hostname + "&password=" + password + "&port=" + port + "&ssl=" + ssl,
                                success: function (data) {
                                    var json = $.parseJSON($(data).find('#cpanelMigratorJson').html());
                                    if (json.status == "success") {
                                        $('#tableBackupsList').dataTable().fnAddData( [
                                            '<input type="checkbox" class="checkBackupFinis" checked="checked" name="backup['+host+']" data-username="'+host+'" readonly>',
                                            host,
                                            hostDetails.find("td:eq(2)").text(),
                                            hostDetails.find("td:eq(3)").text(),
                                            '0MB',
                                            '<div class="spinner-border text-primary m-1" style=" width: 1rem !important; height: 1rem !important; "></div> Transferred',
                                            '<button data-user="'+host+'" class="checkBackupUser btn btn-warning">Check Transfer</button>'
                                        ] );
                                    } else {
                                        $('#tableBackupsList').dataTable().fnAddData( [
                                            '<input type="checkbox" class="checkBackupFinis" name="backup['+host+']" data-username="'+host+'" readonly>',
                                            host,
                                            hostDetails.find("td:eq(2)").text(),
                                            hostDetails.find("td:eq(3)").text(),
                                            '0MB',
                                            'Error Server Disapproved',
                                            '<button data-retryuser="'+host+'" class="retryBackupUser btn btn-primary">Transfer Retry</button>'
                                        ] );
                                    }

                                }
                            });
                        });

                        var setCheckAllBakcup = setInterval( function() { checkAllBakcup(false,datatableList); }, 10000);

                    }
                });


            }







        }
    });
</script>