<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(45deg, #ff0000 25%, transparent 25%, transparent 75%, #0000ff 75%);
            background-size: 20px 20px;
        }

        #Reset {
            border: 1px solid #ccc;
            width: 80%;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 10px 10px 0px 0px red, -10px -10px 0px 0px blue; /* Custom shadow pattern */
            background-color: #f9f9f9; /* Background color for the reset form */
        }

        .container {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div id="Reset">
        <div class="container">
            <label for="email">Enter Your Email:</label>
            <input type="email" id="email" name="email">
        </div>
        <div class="container">
            <label for="password">Enter Your New Password:</label>
            <input type="password" id="password" name="password">
        </div>
        <div class="container">
            <label for="cpassword">Confirm Password:</label>
            <input type="password" id="cpassword" name="cpassword">
        </div>
    </div>
</body>
</html>
