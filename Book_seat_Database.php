<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    // Establish a database connection
    $conn = new mysqli("localhost", "root", "", "Abirami");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $username = $_POST['username'];
    $from = $_POST['From'];
    $to = $_POST['TO'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $noOfSeats = $_POST['no-of-seats'];
    $ticketPrice = $_POST['totalPrice'];

    $sqlGet = "SELECT * FROM accounts WHERE Username = '$username'";
    $results = $conn->query($sqlGet); 

    // Fetch the result
    if ($results->num_rows > 0) {
        $row = $results->fetch_assoc()['UserID'];
        $userID = $row;

        if (isset($_POST['selectedSeat']) && !empty($_POST['selectedSeat'])) {
            $selectedSeat = $_POST['selectedSeat'];
        
            $userID = htmlspecialchars($userID); // Sanitize the username for safe URL use
            // Construct the URL with multiple query parameters
            $redirectURL = "Payment.html?userid=$userID&username=$username&from=$from&to=$to&date=$date&time=$time&noOfSeats=$noOfSeats&selectedSeat=$selectedSeat&ticket=$ticketPrice";
        
            // Output JavaScript code to display an alert
            echo '<script>alert("Make payment to continue");</script>';
            // Redirect the user to the payment page
            echo "<script>window.location.href='$redirectURL';</script>";
            exit();
        } 
        
        else {
            echo '<script>alert("Please select a seat.");</script>';
        }
    } 
    else {
        echo '<script>alert("Username not found");</script>';
    }

    // Close the database connection
    $conn->close();
?>