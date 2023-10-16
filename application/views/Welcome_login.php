<?php include('application/views/template/sidebar.php'); ?>

<main id="main" class="main">
    <section class="section dashboard">
        <div class="row">

            <h1>The User's Information List</h1>
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
            <div class="modal" id="exampleModal" tabindex="-1" role="dialog" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Update the Information</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>

                        <div class="modal-body">
                            <form id="save" action="">
                                <div class="container">
                                    <label for="Name">Change the Name: </label>
                                    <input type="text" id="name" name="name"></input>
                                </div>
                                <br>
                                <div class="container">
                                    <!-- <label for="id">Change the Name: </label> -->
                                    <input type="number" id="id" name="id" hidden></input>
                                </div>
                                <br>
                                <div class="container">
                                    <label for="email">Change the Email: </label>
                                    <input type="email" id="email" name="email"></input>
                                </div>
                        </div>

                        <div class="modal-footer pop">
                            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                            <button type="submit" class="btn btn-primary ">Save changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Add a logout button with a link to the logout URL -->
            <button><a href="<?= base_url('index.php/validation/logout'); ?>">Logout</a></button>
            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                        </div>
                    </div><!-- End Sales Card -->
    </section>

</main><!-- End #main -->
<script>
    $(document).ready(function() {
        $('#exampleModal').hide();
        // Initialize DataTable
        var dataTable = $('#user_data').DataTable({
            "paging": true,
            "lengthMenu": [
                [1, 2, 3, 4, 25, 50, 75, 100, -1],
                [1, 2, 3, 4, 25, 50, 75, 100, 'All']
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
                        return '<button class="btn btn-info edit-btn" onclick="modalopen(' + data.id + ')" data-id="' + data.id + '">Edit</button>';
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
    $(".close").click(function() {
        $('#exampleModal').hide();
    })

    function modalopen(id) {
        $('#exampleModal').show();
        $.ajax({
            url: '<?php echo base_url('index.php/crud_controller/updateInfo'); ?>',
            method: 'POST',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                //console.log(data);
                $('#name').val(data.user_name);
                $('#email').val(data.email);
                $('#id').val(data.id);

            },
            error: function() {
                // Handle AJAX error here
                alert("An error occurred while fetching topics.");
            }
        });

    }

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
    $(document).ready(function() {
        $("#save").submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/crud_controller/infoChange",
                dataType: "json",
                data: formData,
                success: function(res) {
                    if (res == 1) {

                        $('#exampleModal').hide();
                        var table = $('#user_data').DataTable();
                        table.ajax.reload();
                        alert("Data updated Successfully");
                    } else {

                        $('#exampleModal').hide();
                        alert("Data did not update");
                    }
                }

            });
        });
    });
</script>

<?php include('application/views/template/footer.php'); ?>
</body>

</html>