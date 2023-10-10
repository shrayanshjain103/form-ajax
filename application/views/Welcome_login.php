<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- Include Bootstrap CSS (if not already included) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include DataTables JavaScript -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
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
                        <th width="15%">Edit</th>
                        <th width="15%">Delete</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Add a logout button with a link to the logout URL -->
    <button><a href="<?= base_url('index.php/validation/logout'); ?>">Logout</a></button>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var dataTable = $('#user_data').DataTable({
                "paging": true,
                "lengthMenu": [
                    [5, 2, 3, 4, 25, 50, 75, 100, -1],
                    [5, 2, 3, 4, 25, 50, 75, 100, 'All']
                ],
                "ajax": {
                    "url": "<?php echo base_url('index.php/crud_controller/getUsers'); ?>",
                    "type": "POST"
                },
                "columns": [{
                        "data": "user_name"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-info edit-btn" data-id="' + data.id + '">Edit</button>';
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-danger delete-btn" onclick="deleterec(' + data.id + ')" data-id="' + data.id + '">Delete</button>';
                        }
                    }
                ]
            });

        });

        function deleterec(id) {
            $.ajax({
                url: '<?php echo base_url('index.php/crud_controller/deleteData'); ?>',
                method: 'POST',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    if (data == 1) {
                        alert('deleted succesfully');
                        var table = $('#user_data').DataTable();
                        table.ajax.reload();
                    } else {
                        alert('not deleted');
                    }
                },
                error: function() {
                    // Handle AJAX error here
                    alert("An error occurred while fetching topics.");
                }
            });
        }
    </script>
</body>

</html>