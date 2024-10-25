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
    $userid = $_POST['userid'];
    $username = $_POST['username'];
    $from = $_POST['from'];
    $to = $_POST['to'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $noOfSeats = $_POST['no-of-seats'];
    $selectedSeat = $_POST['selectedSeat'];
    $ticketPrice = $_POST['ticket'];

    // Insert data into the database
    $sqlInsertBooking = "INSERT INTO booking (`UserID`, `Departure point`, `Destination point`, `Date`, `Time`, `No of Seats`, `Seat no`, `Ticket`) 
                        VALUES ('$userid', '$from', '$to', '$date', '$time', '$noOfSeats', '$selectedSeat', '$ticketPrice')";

    // Insert data into the database
    $sqlInsertPayment = "INSERT INTO payment (`UserID`, `Departure point`, `Destination point`, `Amount`) 
                        VALUES ('$userid', '$from', '$to', '$ticketPrice')";

    if (($conn->query($sqlInsertBooking) === TRUE) && ($conn->query($sqlInsertPayment) === TRUE)) {
        echo '<script>alert("Ticket booked successfully. Enjoy your journey!");</script>';
        echo '<script>window.location.href = "Book seat.html?username=' . urlencode($username) . '";</script>';
        exit();
    } 
    else {
        echo '<script>alert("Error: ' . $sql . '\n' . $conn->error . '");</script>';
        echo '<script>window.location.href = "Book seat.html?username=' . urlencode($username) . '";</script>';
        exit();
    }

    // Close the database connection
    $conn->close();
?>