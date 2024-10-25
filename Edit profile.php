<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Establish a database connection
    $conn = new mysqli("localhost", "root", "", "Abirami");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $Username = $_GET['username'];

    // Fetch user's ticket bookings from the database
    $sql = "SELECT * FROM accounts WHERE Username = '$Username'";
    $result = $conn->query($sql);

    $profileData = [];

    if ($result->num_rows > 0) {
        $profileData = $result->fetch_assoc();
    }

    // Close the database connection
    $conn->close();
?>

<!DOCTYPE html>
<html>
    <head>     
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <title>Previous Bus Ticket Bookings</title>

        <style>
            body {
                font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                background-color: whitesmoke;

				--bkg: #5eb3fd;
				--white: #e7e6e6;

				background-color: var(--white);
				background-image: url("https://www.transparenttextures.com/patterns/concrete-wall.png");
                margin: 0;
                padding: 0;
            }

            form {
                background-color: white;
                padding: 40px;
                border-radius: 20px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.3);
                width: 550px;
                margin: 50px auto;
            }

            h1 {
                font-size: 40pt;
                padding-top: 30px;
                text-align: center;
                font-weight: 1000;
            }

            label {
                display: block;
                margin-top: 20px;
                font-size: 18px;
                font-weight: bold;
                color: #333;
            }

            input {
                display: block;
                width: 100%;
                padding: 10px;
                border: none;
                border-radius: 20px;
                background-color: #f2f2f2;
                font-size: 16px;
                color: #666;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            }

            select {
                display: block;
                width: 100%;
                padding: 10px;
                border: 0.1px solid #999;
                border-radius: 5px;
                background-color: #f2f2f2;
                font-size: 16px;
                color: #666;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                margin-bottom: 40px;
            }

            input[type="text"],
            input[type="password"] {
                width: 100%;
                padding: 12px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
                margin-bottom: 20px;
                font-size: 16px;
            }

            input[type="submit"] {
                background-color: #4CAF50;
                color: black;
                padding: 12px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: large;
                width: 100%;
                margin-bottom: 20px;
            }

            input[type="submit"]:hover {
                background-color: black;
                color: white;
            }
        </style>

        <!-- Load and inject the external footer.html using JavaScript -->
        <script>
            $(document).ready(function () {
                $("#footerContainer").load("Footer.html");
            });
        </script>
    </head>

    <body>
        <h1>Edit your profile</h1>
        
        <form onsubmit="return validateForm();" method="post" action="Update account.php">
            <input type="hidden" id="userid" name="userid" value="<?php echo $profileData['UserID']; ?>">

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $profileData['Name']; ?>">
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $profileData['Username']; ?>">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo $profileData['Password']; ?>">

            <label for="nic">NIC:</label>
            <input type="text" id="nic" name="nic" value="<?php echo $profileData['NIC']; ?>">

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?php echo $profileData['Email']; ?>">

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $profileData['Phone']; ?>">

            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php echo $profileData['City']; ?>">

            <label for="gender">Gender:</label>
            <select id="gender" name="gender">
                <option value="Male" <?php if ($profileData['Gender'] === 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($profileData['Gender'] === 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if ($profileData['Gender'] === 'Other') echo 'selected'; ?>>Other</option>
            </select>

            <input type="submit" value="Save changes">
        </form>
        
        <script>
            // Function to validate the form
            function validateForm() {
                var name = document.getElementById("name").value;
                var nicNumber = document.getElementById("nic").value;
                var email = document.getElementById("email").value;
                var username = document.getElementById("username").value;
                var password = document.getElementById("password").value;
                var phone = document.getElementById("phone").value;
                var city = document.getElementById("city").value;
                var gender = document.getElementById("gender").value;
        
                // Validation for name: Should contain only letters and spaces
                var namePattern = /^[a-zA-Z\s]+$/;
                if (!name.match(namePattern)) {
                    alert("Please enter a valid name.");
                    return false;
                }

                // Validation for NIC Number: Should be in a specific format (adjust as needed)
                var nicPattern = /^[0-9]{10}$/;
                if (!nicNumber.match(nicPattern)) {
                    alert("Please enter a valid NIC Number (e.g., 1234567890).");
                    return false;
                }

                // Validation for email: Should be a valid email address
                var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!email.match(emailPattern)) {
                    alert("Please enter a valid email address.");
                    return false;
                }

                // Validation for username: Should contain only letters and numbers
                var usernamePattern = /^[a-zA-Z0-9]+$/;
                if (!username.match(usernamePattern)) {
                    alert("Username should contain only letters and numbers.");
                    return false;
                }

                // Validation for password: You can define your own password requirements
                // Here, we're checking that the password is at least 8 characters long
                if (password.length < 8) {
                    alert("Password must be at least 8 characters long.");
                    return false;
                }

                // Validation for phone number: Should be in a specific format (adjust as needed)
                var phonePattern = /^\d{10}$/;
                if (!phone.match(phonePattern)) {
                    alert("Please enter a valid 10-digit phone number.");
                    return false;
                }

                // Validation for the "From" field: You can define your own validation rules
                if (city.length < 3) {
                    alert("Please enter a valid source location.");
                    return false;
                }

                // Validation for the Gender field: Make sure it's not empty
                if (gender === "") {
                    alert("Please select your gender.");
                    return false;
                }

                // If all validations pass, return true to submit the form
                return true;
            }


        </script>

        <div id="footerContainer"></div>
    </body>
</html>