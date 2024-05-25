<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Call</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">

    <style>
        /* Custom styles for animated navbar */
        .navbar {
            transition: all 0.3s ease-in-out;
        }

        .navbar-collapse {
            transition: all 0.3s ease-in-out;
        }

        .navbar-toggler-icon {
            transition: all 0.3s ease-in-out;
        }

        .navbar-dark .navbar-toggler-icon {
            background-color: rgba(255, 255, 255, 0.5);
        }

        .navbar-dark .navbar-toggler-icon:hover {
            background-color: rgba(255, 255, 255, 0.8);
        }

        .navbar-nav .nav-link {
            transition: all 0.3s ease-in-out;
        }

        .navbar-nav .nav-link:hover {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .dropdown-menu {
            transition: all 0.3s ease-in-out;
        }

        .dropdown-menu .dropdown-item {
            transition: all 0.3s ease-in-out;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        /* Add rounded corners to table cells */
        .table-rounded td {
            border-radius: 10px;
        }
        #recognizedText {
            margin-top: 20px;
            font-size: 18px;
            width: 80%;
            border: 1px solid #ccc;
            padding: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Amitab 😁</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!--<ul class="navbar-nav mr-auto">-->
            <!--    <li class="nav-item active">-->
            <!--        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>-->
            <!--    </li>-->
            <!--    <li class="nav-item">-->
            <!--        <a class="nav-link" href="#">Link</a>-->
            <!--    </li>-->
            <!--</ul>-->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        User Profile
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <!--<h2>Schedule a Call</h2>-->
        <br><br>
        <form action="index.php" method="post">
            <div class="form-group">
                <label for="datepicker">Date:</label>
                <input type="text" class="form-control datepicker" id="datepicker" name="date" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label for="timepicker">Time:</label>
                <input type="text" class="form-control timepicker" id="timepicker" name="time" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label for="inputMethod">Input Method:</label>
                <select class="form-control" id="inputMethod" name="inputMethod" required>
                    <option value="text">Text</option>
                    <option value="voice">Voice</option>
                </select>
            </div>

            <div class="form-group" id="textInputGroup">
                <label for="text">Text:</label>
                <input type="text" class="form-control" id="text" name="text">
            </div>

            <div class="form-group" id="voiceInputGroup" style="display: none;">
                <label for="recognizedText">Recognized Text:</label>
                <input type="text" class="form-control" id="recognizedText" name="recognizedText" readonly>
                <button type="button" id="startButton" class="btn btn-secondary">Start Recognition</button>
                <button id="stopButton" class="btn btn-secondary" style="display: none;">Stop Recognition</button>
                <button id="playButton" class="btn btn-secondary" style="display: none;">Play Text</button>
            </div>

            <button type="submit" class="btn btn-primary">Schedule Call</button>
        </form>

        <h2>Scheduled Calls</h2>
        <table class="table table-bordered table-rounded">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Text</th>
                    <th>Voice Text</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
<?php
require_once 'vendor/autoload.php';

use Twilio\Rest\Client;

// Database connection settings
$db_host = 'localhost';
$db_username = ''; // Replace with your actual username
$db_password = '';   // Replace with your actual password
$db_name = '';


// Establishing database connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $userDate = $_POST['date'];
    $userTime = $_POST['time'];
    $inputMethod = $_POST['inputMethod'];
    $text = $_POST['text'];
    $recognizedText = $_POST['recognizedText'];

    // Determine the call text based on the selected input method
    $callText = $inputMethod === 'voice' ? $recognizedText : $text;

    // Combine date and time to a single string
    $userDateTimeString = $userDate . ' ' . $userTime;

    // Create DateTime object with user's timezone (assuming it's in Indian Standard Time)
    $dateTime = new DateTime($userDateTimeString, new DateTimeZone('Asia/Kolkata'));

    // Convert the DateTime object to UTC
    $dateTime->setTimezone(new DateTimeZone('UTC'));
    $utcDateTimeString = $dateTime->format('Y-m-d H:i:s');

    // Insert the user's date, time, text, recognized text, and UTC datetime into the database
    $sql = "INSERT INTO scheduled_calls (user_date, user_time, user_text, recognized_text, utc_datetime, call_status) VALUES (?, ?, ?, ?, ?, 'pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $userDate, $userTime, $text, $recognizedText, $utcDateTimeString);
    $stmt->execute();
    $stmt->close();

    echo "Call scheduled successfully!";
    //  sleep(1); 
}


// Retrieve data from the database in descending order based on ID
$sql = "SELECT * FROM scheduled_calls ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["user_date"] . "</td>";
        echo "<td>" . $row["user_time"] . "</td>";
        echo "<td>" . $row["user_text"] . "</td>";
        echo "<td>" . $row["recognized_text"] . "</td>";
        echo "<td><form action='delete_record.php' method='post'><input type='hidden' name='record_id' value='" . $row["id"] . "'><input type='submit' value='Delete'></form></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No scheduled calls found</td></tr>";
}

$sid = ' ';
$token = ' ';

try {
    // Create Twilio client
    $twilio = new Client($sid, $token);

    // Schedule the call
    $now = new DateTime('now', new DateTimeZone('UTC'));
    $sql = "SELECT * FROM scheduled_calls WHERE utc_datetime <= ? AND call_status = 'pending'";
    $stmt = $conn->prepare($sql);
    $nowString = $now->format('Y-m-d H:i:s');
    $stmt->bind_param("s", $nowString);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Use the recognized text if available, otherwise use the entered text
            $callText = !empty($row['recognized_text']) ? $row['recognized_text'] : $row['user_text'];

            // Make the call
            $call = $twilio->calls->create(
                "", // to
                "", // from
                ["twiml" => "<Response><Say>$callText</Say></Response>"]
            );

            // Update call_status to 'completed'
            $updateSql = "UPDATE scheduled_calls SET call_status = 'completed' WHERE id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("i", $row['id']);
            $updateStmt->execute();
            $updateStmt->close();

            echo "Call initiated<br>";
        }
    } else {
        echo "No scheduled call found";
    }
    $stmt->close();
} catch (Exception $e) {
    echo 'Caught exception: ' . $e->getMessage() . "\n";
}

// Close database connection
$conn->close();
?>


            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
    <script>
        $(function () {
            // Date picker
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd',
                startDate: '+0d',
                todayHighlight: true
            });

            // Time picker
            $('#timepicker').timepicker({
                minuteStep: 1,
                secondStep: 1,
                showSeconds: true,
                showMeridian: false,
                explicitMode: true,
                showInputs: false
            });

            // Show/hide input fields based on selected input method
            $('#inputMethod').change(function() {
                if ($(this).val() === 'voice') {
                    $('#textInputGroup').hide();
                    $('#voiceInputGroup').show();
                } else {
                    $('#textInputGroup').show();
                    $('#voiceInputGroup').hide();
                }
            });
        });

        var recognition;
        var recognizedTextInput = document.getElementById('recognizedText');

        function startSpeechRecognition() {
            recognition = new webkitSpeechRecognition();
            recognition.lang = 'en-US';

            recognition.onresult = function(event) {
                var result = event.results[event.results.length - 1][0].transcript;
                recognizedTextInput.value = result;
                document.getElementById('playButton').style.display = 'inline';
            };

            recognition.onerror = function(event) {
                console.error('Speech recognition error:', event.error);
            };

            recognition.start();
            document.getElementById('startButton').style.display = 'none';
            document.getElementById('stopButton').style.display = 'inline';
        }

        function stopSpeechRecognition() {
            if (recognition) {
                recognition.stop();
                document.getElementById('startButton').style.display = 'inline';
                document.getElementById('stopButton').style.display = 'none';
            }
        }

        function playRecognizedText() {
            var text = recognizedTextInput.value;
            var msg = new SpeechSynthesisUtterance();
            msg.text = text;
            window.speechSynthesis.speak(msg);
        }

        document.getElementById('startButton').addEventListener('click', startSpeechRecognition);
        document.getElementById('stopButton').addEventListener('click', stopSpeechRecognition);
        document.getElementById('playButton').addEventListener('click', playRecognizedText);
    </script>
</body>
</html>
