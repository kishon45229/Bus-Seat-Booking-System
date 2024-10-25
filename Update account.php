<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Establish a database connection
    $conn = new mysqli("localhost", "root", "", "Abirami");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle the form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userid = $_POST["userid"];
        $name = $_POST["name"];
        $nicNumber = $_POST["nic"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $city = $_POST["city"];
        $gender = $_POST["gender"];
        
        // Check if the username is unique
        $checkUsernameQuery = "SELECT * FROM accounts WHERE Username = '$username' AND UserID != $userid";
        $usernameResult = $conn->query($checkUsernameQuery);

        // Check if the email is unique
        $checkEmailQuery = "SELECT * FROM accounts WHERE Email = '$email' AND UserID != $userid";
        $emailResult = $conn->query($checkEmailQuery);

        if ($usernameResult->num_rows > 0) {
            $errorMessage = "Username already exists. Please choose a different one.";
            header("Location: Edit profile.php");
            exit();
        }

        if ($emailResult->num_rows > 0) {
            $errorMessage = "Email address is already registered. Please use a different email.";
            header("Location: Edit profile.php");
            exit();
        }

        // If both username and email are unique, update the data in the database
        $sql = "UPDATE accounts 
                SET `Name` = '$name', 
                    `NIC` = '$nicNumber', 
                    `Email` = '$email', 
                    `Password` = '$password', 
                    `Phone` = '$phone', 
                    `City` = '$city', 
                    `Gender` = '$gender'
                WHERE `Username` = '$username'";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Details updated.");</script>';
            // Set the username as a query parameter
            $username = "?username=" . urlencode($username);
            
            // Redirect to "Book seat.html" with the username parameter
            header("Location: Book seat.html" . $username);
            exit();
        } 
        else {
            echo '<script>alert(""Error: " . $sql . "<br>" . $conn->error");</script>';
            header("Location: Edit profile");
            exit();
        }
    }

    // Close the database connection
    $conn->close();
?>