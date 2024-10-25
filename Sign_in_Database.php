<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    // Establish a database connection
    $conn = new mysqli("localhost", "root", "", "Abirami");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

     // Initialize variables for error and success messages
     $errorMessage = "";
     $successMessage = "";

    // Handle the form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        // Query the database to check if the username and password match
        $sql = "SELECT * FROM accounts WHERE Username = '$username' AND Password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $successMessage = "Login success. Welcome!";
            
            $username = htmlspecialchars($username); // Sanitize the username for safe URL use
            header("Location: Book seat.html?username=" . urlencode($username));
            exit();
        } 
        else {
            $errorMessage = "Incorrect username or password.";
            header("Location: Index.html"); // Redirect to the sign-in page with an error message
            exit();
        }
    }
    else {
        echo "Error";
    }

    // Close the database connection
    $conn->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Abirami Travels | Sign In</title>
        <!-- Your CSS and other HTML code here -->
    </head>

    <body>
         <!-- Display error message if login fails -->
        <?php if (!empty($errorMessage)): ?>
            <script>
                alert("<?php echo $errorMessage; ?>");
            </script>
        <?php endif; ?>

        <?php if (!empty($successMessage)): ?>
            <script>
                alert("<?php echo $successMessage; ?>");
            </script>
        <?php endif; ?>
    </body>
</html>