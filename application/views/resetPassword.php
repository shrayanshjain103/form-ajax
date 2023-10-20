<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(45deg, #00f, #0ff, #f0f, #00f);
            background-size: 400% 400%;
            animation: gradient 60s ease infinite;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        #Reset {
            border: 1px solid #ccc;
            width: 80%;
            max-width: 400px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2);
            background-color: #fff;
            text-align: center;
            margin: 0 auto;
        }

        .container {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            color: #007BFF;
            /* Label text color */
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
            box-sizing: border-box;
            /* Prevents input fields from going out of the border */
        }

        /* Style the submit button */
        button#changePassword {
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button#changePassword:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div id="Reset" style="border: 1px solid black; border-radius:10px;">
        <form id="form" action="" method="post">
            <div class="container">
                <label for="currentPassword">Enter Current Password</label>
                <input type="password" id="currentPassword" name="currentPassword">
                <span id="Cpassword-error" style="color:#f00"></span>
            </div>
            <div class="container">
                <label for="newPassword">Enter New Password:</label>
                <input type="password" id="newPassword" name="newPassword">
                <span id="Npassword-error" style="color:#f00"></span>
            </div>
            <div class="container">
                <label for="confirmPassword">Confirm New Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword">
                <span id="Confirmpassword-error" style="color:#f00"></span>
            </div>
            <br>
            <div id="responseDiv" style="color:black"></div>
            <br>
            <button type="submit" id="changePassword">Change New Password</button>
        </form>

    </div>
</body>

<script>
    $(document).ready(function() {
        $('#form').submit(function(event) {
            event.preventDefault();
            if (!validateForm()) {
                return;
            }
            var formData = $(this).serialize();
            $.ajax({
                method: 'POST',
                url: "<?php echo base_url('index.php/Validation/updatePassword'); ?>",
                data: formData,
                dataType: "json",
                success: function(res) {
                    if(res==1){
                        alert('Password has  been changed');
                      window.location.href="dashboard";
                    }
                    else if(res==0){
                        alert('Password has not been changed');
                    } else{
                        alert('Current Password Does not match');
                    }
                },
                error: function(res) {
                    alert('error');
                }
            });
        });
    });

    function validateForm() {
        $('#Cpassword-error').text('');
        $('#Npassword-error').text('');
        $('#Confirmpassword-error').text('');
        var current_pass = $("#currentPassword").val();
        var new_pass = $("#newPassword").val();
        var confirmPassword = $("#confirmPassword").val();
        var isValid = true;
        if (current_pass.trim() === "") {
            document.getElementById("Cpassword-error").textContent = "Current Password is required";
            isValid = false;
        }
        if (new_pass.trim() == "") {
            document.getElementById("Npassword-error").textContent = "Please Enter New Password";
            isValid = false;
        }
        if (confirmPassword.trim() == "") {
            document.getElementById("Confirmpassword-error").textContent = "Re-Enter Your New Password";
            isValid = false;
        }

        if (isValid == true) {
            if ((new_pass == confirmPassword) && (new_pass != "")) {
                document.getElementById("responseDiv").textContent = "Password Matched";
                isValid = true;
            } else {
                document.getElementById("responseDiv").textContent = "Password Did Not Matched";
                isValid = false;
            }
        }

        return isValid;
    }
    document.getElementById('form').addEventListener('submit', function() {
        if (!validateForm()) {
            event.preventDefault();
        }
    });
</script>

</html>