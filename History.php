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
    $sql = "SELECT * FROM booking WHERE UserID = (SELECT UserID FROM accounts WHERE Username = '$Username')";
    $result = $conn->query($sql);

    $ticketBookings = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ticketBookings[] = $row;
        }
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

            table {
                border-collapse: collapse;
                width: 80%;
                margin: 20px auto;
                background-color: white;
                margin-bottom: 50px;
            }

            th, td {
                padding: 10px;
                border: 1px solid #4CAF50;
                text-align: left;
                text-align: center;
            }

            th {
                background-color: #4CAF50;
            }

            h1 {
                font-size: 40pt;
                padding-top: 30px;
                text-align: center;
                font-weight: 1000;
            }

            .no {
                text-align: center;
                font-size: 20pt;
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
        <h1>Bookings history of <?php echo $Username; ?></h1>
        
        <table>
            <?php
                if (empty($ticketBookings)) {
                    echo "<p class='no'>You do not have any previous bookings with Abirami Travels!</p>";
                } 
                else {
            ?>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>No. of Tickets</th>
                        <th>Seat No.</th>
                        <th>Total Ticket Price</th>
                    </tr>

                    <?php
                        // Loop through each ticket booking and display it in the table
                        foreach ($ticketBookings as $booking) {
                            echo "<tr>";
                            echo "<td>" . $booking['Departure point'] . "</td>";
                            echo "<td>" . $booking['Destination point'] . "</td>";
                            echo "<td>" . $booking['Date'] . "</td>";
                            echo "<td>" . $booking['Time'] . "</td>";
                            echo "<td>" . $booking['No of Seats'] . "</td>";
                            echo "<td>" . $booking['Seat no'] . "</td>";
                            echo "<td> Rs. " . $booking['Ticket'] . "</td>";
                            echo "</tr>";
                        }
                    ?>
        </table>
        <?php } ?>

        <div id="footerContainer"></div>
    </body>
</html>