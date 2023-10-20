<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title> <!-- Link to your external CSS file -->
</head>
<style>
    /* Reset some default browser styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Apply a colorful background gradient */
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, skyblue, #FF495E);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    /* Style the form container */
    .container {
        text-align: center;
    }

    /* Style form elements */
    .form {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .form-title {
        font-size: 24px;
        margin-bottom: 20px;
        color: #FF5C8E;
        /* Title color */
    }

    .form-group {
        margin: 15px 0;
        position: relative;
    }

    .form-label {
        position: absolute;
        top: 0;
        left: 0;
        transition: all 0.3s ease;
        color: #FF495E;
        /* Label text color */
        background-color: transparent;
        /* Label background color */
        padding: 0 5px;
        transform: translateY(-20px);
        opacity: 0;
    }

    .form-input {
        width: 100%;
        padding: 12px;
        border: 1px solid #FF5C8E;
        /* Input border color */
        border-radius: 5px;
        font-size: 16px;
        background-color: rgba(255, 255, 255, 0.8);
        transition: all 0.3s ease;
        color: #333;
        /* Input text color */
    }

    .form-input:focus {
        border-color: #FF495E;
        /* Input border color on focus */
    }

    .form-input:focus+.form-label {
        transform: translateY(-30px);
        opacity: 1;
    }

    .form-button {
        background-color: #FF5C8E;
        /* Button background color */
        color: #fff;
        /* Button text color */
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 10px;
        margin-left: -116px;
    }

    .form-button:hover {
        background-color: #FF495E;
        /* Change button color on hover */
    }

    .form-links {
        margin-top: 10px;
    }

    .form-link {
        text-decoration: none;
        color: #333;
        /* Link text color */
        margin: 0 10px;
        transition: color 0.3s ease;
    }

    .form-link:hover {
        color: #FF5C8E;
        /* Change link color on hover */
    }
</style>

<body>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration Page</title> <!-- Link to your external CSS file -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    </head>
    <style>
        /* Reset some default browser styles */
        /* ... Your existing CSS styles ... */
    </style>

    <body>
        <div class="container">
            <form class="form" id="form" method="post" onsubmit="return validateInputs()">
                <div id="form-message"></div>
                <h2 class="form-title">Registration</h2>
                <div class="form-group">
                    <label for="username" class="form-label">Name</label>
                    <input type="text" id="username" name="name" class="form-input" placeholder="Enter your name">
                    <div class="formerr"></div> <!-- Error display container -->
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email">
                    <div class="formerr"></div> <!-- Error display container -->
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password">
                    <div class="formerr"></div> <!-- Error display container -->
                </div>
                <div class="form-group">
                    <label for="cpassword" class="form-label">Confirm Password</label>
                    <input type="password" id="cpassword" name="cpassword" class="form-input" placeholder="Confirm your password">
                    <div class="formerr"></div> <!-- Error display container -->
                </div>
                <input type="Submit" value="Submit" id='Submit' class="form-button">
                <div class="form-links">
                    <br>
                    <a href="Login" class="form-button" style="text-decoration: none;">Login</a>
                </div>
            </form>
        </div>
        <script type='text/javascript' src="<?= base_url(); ?>assests/validation.js"></script>
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#form").submit(function(event) {
                    event.preventDefault();
                    var formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/validation/ajax_process_registration",
                        dataType: "json",
                        data: formData,
                        success: function(res) {
                            if (res.status == 'true') {
                                alert("Data inserted Successfully");
                            } else {
                                alert("Data inserted Unsuccessful");

                            }
                        }

                    });
                });
            });
        </script>


    </body>

    </html>