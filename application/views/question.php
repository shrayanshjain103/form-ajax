<?php include('application/views/template/sidebar.php'); ?>
<!-- Your code for the first link -->
<!-- Add your form here -->
<style>
    /* Style the form container */
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
        padding: 6px;
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

    .csv,
    .word {
        text-decoration: none;
        border: 1px solid black;
        background-color: #337ab7;
        color: white;
        border-radius: 8px;
        padding: 10px 10px;
        /* margin-right: 10px; */
        float: right;
    }

    .csv:hover,
    .word:hover {
        background-color: #444;
    }

    h1 {
        text-align: center;
    }

    #user_data {
        border: 2px solid black;
        background-color: skyblue;
    }

    .button-container {
        text-align: center;
        margin-top: 20px;
    }

    #search {
        background-color: #337ab7;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 5px 20px;
        cursor: pointer;
    }

    #search:hover {
        background-color: #23527c;
    }

    .download-buttons {
        display: inline-block;
        margin-right: 10px;
    }

    .img-icon {
        width: 20px;
    }

    .question {
        display: flex;
        justify-content: end;
    }
</style>
<main id="main" class="main">
    <br>
    <br>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <selection class="modal-title" id="exampleModalLabel">Add New Question</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Add New Question</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="save" action="" method="post">
                        <label for="first_dropdown">Select Subject:</label>
                        <br>
                        <br>
                        <select id="first_dropdown" name="subject_id">
                            <option value="">Please Select Subject</option>
                        </select>
                        <br>
                        <br>
                        <label for="second_dropdown">Select Topics:</label>
                        <br>
                        <br>
                        <select id="second_dropdown" name="topic_id">
                            <option value="">Please Select Topic</option>
                        </select>
                        <br>
                        <br>
                        <label for="lang_code">Select Language:</label>
                        <br>
                        <br>
                        <select id="lang_code" name="lang_code">
                            <option value="">Please Select Language</option>
                            <option value="1">English</option>
                            <option value="2">Hindi</option>
                        </select>
                        <br>
                        <br>
                        <div class="container">
                            <label for="Question">Question: </label>
                            <input type="text" id="Question" name="Question"></input>
                        </div>
                        <br>
                        <div class="container">
                            <label for="option1">Option 1: </label>
                            <input type="text" id="option1" name="option1"></input>
                        </div>
                        <br>
                        <div class="container">
                            <label for="option2">Option 2: </label>
                            <input type="text" id="option2" name="option2"></input>
                        </div>
                        <br>
                        <div class="container">
                            <label for="option3">Option 3: </label>
                            <input type="text" id="option3" name="option3"></input>
                        </div>
                        <br>
                        <div class="container">
                            <label for="option4">Option 4: </label>
                            <input type="text" id="option4" name="option4"></input>
                        </div>
                        <br>
                        <div class="container">
                            <label for="Answer">Answer: </label>
                            <input type="text" id="Answer" name="Answer"></input>
                        </div>
                        <br>
                        <div class="container">
                            <label for="Description">Description: </label>
                            <input type="text" id="Description" name="Description"></input>
                        </div>
                        <br>
                        <br>
                        <div class="container">
                            <label for="Status">Status: </label>
                            <input type="text" id="Status" name="Status"></input>
                        </div>
                        <br>
                </div>

                <div class="modal-footer pop">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-primary ">Save changes</button>
                </div>
                </form>
            </div>
        </div>

    </div>

    </div>


    <table class="display table table-bordered table-striped" id="user_data">
        <a href="javascript:void(0)"><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModal">Add Question</button></a>
        <thead>
            <tr>
                <th>#</th>
                <th>Subject</th>
                <th>Topic</th>
                <th>Language</th>
                <th>Question</th>
                <th>Option 1</th>
                <th>Option 2</th>
                <th>Option 3</th>
                <th>Option 4</th>
                <th>Answer</th>
                <th>Action</th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th><input type="text" data-column="0" class="search-input-text form-control"></th>
                <th><input type="text" data-column="7" class="search-input-text form-control"></th>
                <th><input type="text" data-column="8" class="search-input-text form-control"></th>
                <th><input type="text" data-column="9" class="search-input-text form-control"></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
    </table>

    </div>
</main>
<script>
    $(document).ready(function() {

        var table = 'user_data';
        var dataTable = jQuery("#" + table).DataTable({
            "processing": true,
            "serverSide": true,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                url: '<?php echo base_url('index.php/validation/questionList'); ?>', // json datasource
                type: "post", // method  , by default get
                error: function() { // error handling
                    jQuery("." + table + "-error").html("");
                    jQuery("#" + table + "_processing").css("display", "none");
                }
            }
        });
        jQuery("#" + table + "_filter").css("display", "none");
        $('.search-input-text').on('keyup click', function() { // for text boxes
            var i = $(this).attr('data-column'); // getting column index
            var v = $(this).val(); // getting search input value
            dataTable.columns(i).search(v).draw();
        });
        $('.search-input-select').on('change', function() { // for select box
            var i = $(this).attr('data-column');
            var v = $(this).val();
            dataTable.columns(i).search(v).draw();
        });
    });
    $(document).ready(function() {
        $('#first_dropdown').select2({
            theme: "classic",
            width: 'resolve',
            allowClear: true,
            templateResult: showImage,
            // minimumInputLength:3,

            ajax: {
                url: '<?php echo base_url('index.php/validation/get_subjects'); ?>',
                method: 'POST',
                dataType: 'json',
                data: function(params) {
                    return {
                        search: params.term // Send the user's input as 'search' parameter
                    };
                },
                processResults: function(data) {
                    if (data && data.length > 0) {
                        return {
                            results: data.map(function(subject) {
                                return {
                                    id: subject.id,
                                    text: subject.name,
                                    image: subject.image
                                };
                            })
                        };
                    } else {
                        return {
                            results: []
                        };
                    }
                },
                cache: true
            }
        });

        function showImage(option) {
            if (!option.id) {
                return option.text;
            }

            // Use option.image to extract the image URL
            var imageUrl = option.image;

            var $option = $(
                `<span><img src="${imageUrl}" class="img-icon" />  ${option.id}. ${option.text}</span>`
            );

            return $option;
        }
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
        $("#second_dropdown").select2({
            theme: "classic"
        });
    });
    $(document).ready(function() {
        $("#save").submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/validation/addnewQuestion",
                dataType: "json",
                data: formData,
                success: function(res) {
                    console.log(res);
                    if (res == 1) {
                        $('#myModal').hide();
                        $('#user_data').DataTable().ajax.reload();
                        // window.location.reload();
                        alert("Data inserted Successfully");


                    } else {
                        $('#myModal').hide();
                        // window.location.reload();
                        $('#user_data').DataTable().ajax.reload();
                        alert("Data inserted Unsuccessful");

                    }
                }

            });
        });
    });
</script>


<?php include('application/views/template/footer.php'); ?>