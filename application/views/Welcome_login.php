<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <title>User Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
        }

        .box {
            width: 900px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <h1>Welcome to Admin Page</h1>
    <div class="container box">
        <div class="table-responsive">
            <br />
            <table id="user_data" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="35%">Name</th>
                        <th width="35%">Email</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Add a logout button with a link to the logout URL -->
    <button><a href="<?= base_url('index.php/validation/logout'); ?>">Logout</a></button>
    <script>
        $(document).ready(function() {
            $('#user_data').DataTable({
                "lengthMenu": [
                    [50, 75, 100, 300],
                    [50, 75, 100, 300]
                ],
                "processing": true,
                "serverSide": true,

                "ajax": {
                    "url": "<?php echo base_url('index.php/crud_controller/getUsers'); ?>",
                    "type": "POST"
                },
                "columns": [{
                        "data": "user_name"
                    },
                    {
                        "data": "email"
                    }
                    // {
                    //     "data": null,
                    //     "render": function (data, type, row) {
                    //         return '<a href="edit.php?id=' + data.id + '">Edit</a>';
                    //     }
                    // },
                    // {
                    //     "data": null,
                    //     "render": function (data, type, row) {
                    //         return '<a href="delete.php?id=' + data.id + '">Delete</a>';
                    //     }
                    // }
                ]
            });
        });
    </script>
</body>

</html>