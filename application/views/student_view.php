<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JavaScript -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons JavaScript -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

</head>
<style>
    /* Style the form container */
    body {
        background-color: #ccc;
    }

    form {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f5f5f5;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    /* Style labels and select boxes */
    label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
        color: #333;
        /* Text color */
    }

    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
        /* Dropdown background color */
        color: #333;
        /* Text color */
    }

    /* Style the default option in dropdowns */
    option {
        background-color: #fff;
        /* Background color */
        color: #333;
        /* Text color */
    }

    /* Style the "Topics" dropdown */
    #second_dropdown {
        margin-top: 10px;
    }

    /* Style the default "No topics found" option */
    #second_dropdown option[value=""] {
        color: #999;
        /* Grayed-out text color */
    }

    /* Position the logout button at the top right corner */
    #logout-btn {
        position: absolute;
        top: 20px;
        right: 10px;
        color: blueviolet;
        text-decoration: none;
    }
</style>

<body>
    <!-- Your navigation bar and logout button -->
    <!-- ... -->

    <form style="margin-top:20px">
        <label for="first_dropdown">Select Subject:</label>
        <select id="first_dropdown" name="first_dropdown">
            <!-- Options for the first dropdown -->
            <option value="">Please Select Subject</option>

        </select>
        <br>
        <br>
        <label for="second_dropdown">Topics:</label>
        <select id="second_dropdown" name="second_dropdown">
        </select>
        <br>
        <br>
        <!-- <a href="">hello</a> -->
        <button id="search">Search</button>
    </form>
    <div class="container box" style="margin-top:20px">
        <div class="table-responsive">
            <br />
            <h1 style="margin-left: 420px;">Questions Paper</h1>
            <a href="" id="download" >Download</a>
            <br>
            <a href="" id="wordDownload" >Word Download</a>
            <br>
            <table id="user_data" class="table table-bordered table-striped" style="border:2px solid black;background-color:skyblue;">
                <!-- <thead>
                    <tr>
                        <th width="35%" style="border:2px solid black; background-color:antiquewhite; ">question</th>

                    </tr>
                </thead> -->
            </table>
        </div>
    </div>
    <button id="logout-btn"><a href="<?= base_url('index.php/validation/logout'); ?>">Logout</a></button>

    <!-- Your JavaScript code -->

    <script>
        $(document).ready(function() {
            // Fetch subjects using AJAX and populate the first dropdown
            $.ajax({
                url: '<?php echo base_url('index.php/Validation/get_subjects'); ?>',
                method: 'POST',
                dataType: 'json',
                success: function(data) {
                    if (data != 0) {
                        // Populate the first dropdown with fetched subjects
                        $.each(data, function(index, subject) {
                            $('#first_dropdown').append($('<option>', {
                                value: subject.id,
                                text: subject.name
                            }));
                        });
                    } else {
                        // Handle the case when no subjects are found
                        alert("No subjects found");
                    }
                },
                error: function() {
                    // Handle AJAX error here
                    alert("An error occurred while fetching subjects.");
                }
            });
        });

        $(document).ready(function() {
            $('#first_dropdown').on('change', function() {
                var selectedOption = $(this).val();
                $.ajax({
                    url: '<?php echo base_url('index.php/Validation/getTopics'); ?>',
                    method: 'POST',
                    data: {
                        selected_option: selectedOption
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data && data.length > 0) {
                            $('#second_dropdown').empty(); // Clear existing options
                            $('#second_dropdown').append('<option value="">Select Topic</option>'); // Add a default option

                            // Add new options based on the AJAX response
                            $.each(data, function(index, topic) {
                                $('#second_dropdown').append($('<option>', {
                                    value: topic.id,
                                    text: topic.topic
                                }));
                            });
                        } else {
                            // Handle the case when no topics are found
                            $('#second_dropdown').empty();
                            $('#second_dropdown').append('<option value="">No topics found</option>');
                        }
                    },
                    error: function() {
                        // Handle AJAX error here
                        alert("An error occurred while fetching topics.");
                    }
                });
            });
        });

        $(function() {
            $("#search").click(function(e) {
                e.preventDefault();

                var topic = $("#second_dropdown").val();
                var sub = $("#first_dropdown").val();

             
             var hrefa = "getCSV/"+topic+"/"+sub;
             $('#download').attr('href' , hrefa);
             $("#download").prop('disable' , false);

             var hrefc = "getDocument/"+topic+"/"+sub;
             $('#wordDownload').attr('href' , hrefc);
             $("#wordDownload").prop('disable' , false);
                $.ajax({
                    url: '<?php echo base_url('index.php/Validation/getQuestions'); ?>',
                    method: 'POST',
                    data: {
                        "topic_id": topic,
                        "subject_id": sub
                    },
                    dataType: 'json',
                    success: function(data) {
                        // if (data != 0) {
                        //     $.each(data, function(index, topic) {
                        //         $("#user_data").append("<tr><td>" + topic.question +
                        //             "</td></tr>");
                        //     });

                        // } else {
                        //     console.log(null);
                        // }

                        if (data.length > 0) {
                            var table = $("#user_data").DataTable({
                                "bDestroy": true,
                                // dom: 'Bfrtip ',
                                // buttons: [
                                //     'copy', 'csv', 'excel', 'print'
                                // ],
                                data: data,
                                columns: [{
                                        data: 'question',
                                        title: 'Question'
                                    },
                                    {
                                        data: 'opt1',
                                        title: 'Option 1'
                                    },
                                    {
                                        data: 'opt2',
                                        title: 'Option 2'
                                    },
                                    {
                                        data: 'opt3',
                                        title: 'Option 3'
                                    },
                                    {
                                        data: 'opt4',
                                        title: 'Option 4'
                                    },
                                    {
                                        data: 'answer',
                                        title: 'Answer'
                                    },
                                ],
                                order: [0]
                            });
                        } else {
                            console.log("No data available")
                        }
                    },
                    error: function() {
                        alert("An error occurred while fetching topics.");
                    }
                });

            });


        });
        // $("#download").click(function(e) {
        //     e.preventDefault();
        //     var topic = $("#second_dropdown").val();
        //     var sub = $("#first_dropdown").val();
        //      var hrefa = "getQuestion/"+topic+"/"+sub;
        //      $('#download').attr('href' , hrefa);
        //      $("#download").prop('disable' , false);

        // });
    </script>
</body>

</html>