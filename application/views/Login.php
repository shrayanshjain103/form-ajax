<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    /* Reset some default browser styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Apply colorful background pattern and center the form */
    body {
        font-family: Arial, sans-serif;
        background-image: linear-gradient(135deg, skyblue, #ffa7a7);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-size: 200% 200%;
        animation: gradient 10s ease infinite;
    }

    @keyframes gradient {
        0% {
            background-position: 0% 50%;
        }

        100% {
            background-position: 100% 50%;
        }
    }

    /* Style the form container */
    .container {
        text-align: center;
    }

    /* Style form elements */
    .login-form {
        background-color: rgba(221, 172, 175, 0.9);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        width: 300px;
    }

    .login-form h2 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }

    .form-group {
        margin: 15px 0;
    }

    label {
        display: block;
        text-align: left;
        margin-bottom: 5px;
        color: #333;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    .button {
        background-color: #007BFF;
        color: #fff;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .button:hover {
        background-color: #0056b3;
    }
</style>

<body>
    <div class="container">
        <form id="form" class="login-form" method="post">
            <h2>Login</h2>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
            </div>
            <input type="submit" id="login" class="button">
            <!-- <button type="button" class="button">Sign Up</button> -->
            <a href="<?=base_url()?>index.php/Validation/process_registration" class="button" style="text-decoration:none">Sign Up</a>
            <div id="msg"></div>
        </form>
    </div>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // $(document).ready(function(){})
            $('#form').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url:"<?php echo base_url();?>index.php/validation/ajax_login",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 'true') {
                            // $("#msg").text("Login success");
                            // window.open('<!?php echo base_url();?>index.php/validation/dashboard')
                            window.location.href='<?php echo base_url();?>index.php/validation/dashboard';
                        } else {
                            $("#msg").text("Login failed!");
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>