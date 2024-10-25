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
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        // Query the database to check if the username and password match
        $sql = "SELECT * FROM accounts WHERE Username = '$username' AND Password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            echo '<script>alert("Login success. Welcome!");</script>';
            $username = htmlspecialchars($username); // Sanitize the username for safe URL use
            echo '<script>window.location.href = "Book seat.html?username=' . urlencode($username) . '";</script>';
            exit();
        } 
        else {
            echo '<script>alert("Incorrect username or password.");</script>';
            echo '<script>window.location.href = "Index.html";</script>'; // Redirect to the sign-in page with an error message
            exit();
        }
    }
    else {
        echo '<script>alert("Error.");</script>';
        echo '<script>window.location.href = "Index.html";</script>'; // Redirect to the sign-in page with an error message
        exit();
    }

    // Close the database connection
    $conn->close();
?>
