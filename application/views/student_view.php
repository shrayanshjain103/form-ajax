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
    <!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add your JavaScript and CSS libraries here -->
</head>
<style>
    body {
        background-color: #f5f5f5;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    form {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    label {
        font-weight: bold;
        color: #333;
    }

    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
        color: #333;
    }

    select option {
        background-color: #fff;
        color: #333;
    }

    #second_dropdown option[value=""] {
        color: #999;
    }

    #logout-btn {
        position: absolute;
        top: 20px;
        right: 10px;
        color: blueviolet;
        text-decoration: none;
    }

    .csv, .word {
        text-decoration: none;
        border: 1px solid black;
        background-color: #000;
        color: white;
        border-radius: 5px;
        padding: 5px 10px;
        margin-right: 10px;
    }

    .csv:hover, .word:hover {
        background-color: #444;
    }

    .container {
        margin-top: 20px;
    }

    h1 {
        text-align: center;
    }

    #user_data {
        border: 2px solid black;
        background-color: skyblue;
    }
</style>
<body>
    <!-- Your existing HTML content here -->

    <!-- Your JavaScript code here -->

</body>
</html>

</style>

<body>
    <!-- Your navigation bar and logout button -->
    <!-- ... -->

    <form style="margin-top:20px">
        <label for="first_dropdown">Select Subject:</label>
        <select id="first_dropdown" name="first_dropdown">
            <option value="">Please Select Subject</option>
        </select>
        <br>
        <br>
        <label for="second_dropdown">Select Topics:</label>
        <select id="second_dropdown" name="second_dropdown">
        <option value="">Please Select Topic</option>
        </select>
        <br>
        <br>
        <label for="selectLang">Select Language:</label>
        <select id="selectLang" name="selectLang">
            <option value="">Please Select Language</option>
            <option value="1">English</option>
            <option value="2">Hindi</option>
        </select>
        <br>
        <br>
        <!-- <a href="">hello</a> -->
        <button id="search">Search</button>
    </form>
    <div class="container box" style="margin-top:20px">
        <div class="table-responsive">
            <br />
            <h1>Questions Paper</h1>
            <a href="" id="download" class="csv">CSV format Download</a>
            <br>
            <br>
            <a href="" id="wordDownload" class="word">Word format Download</a>
            <br>
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
                var lang= $("#selectLang").val();


                var hrefa = "getCSV/" + topic + "/" + sub +"/" + lang;
                $('#download').attr('href', hrefa);
                $("#download").prop('disable', false);

                var hrefc = "getDocument/" + topic + "/" + sub +"/" + lang;
                $('#wordDownload').attr('href', hrefc);
                $("#wordDownload").prop('disable', false);
                $.ajax({
                    url: '<?php echo base_url('index.php/Validation/getQuestions'); ?>',
                    method: 'POST',
                    data: {
                        "topic_id": topic,
                        "subject_id": sub,
                        "lang_id":lang
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