<?php
// Database connection settings
$db_host = 'localhost';
$db_username = ' '; // Replace with your actual username
$db_password = '';   // Replace with your actual password
$db_name = ' ';

// Establishing database connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the record ID is set
if(isset($_POST['record_id'])) {
    // Sanitize the record ID
    $record_id = $conn->real_escape_string($_POST['record_id']);
    
    // Delete the record from the database
    $sql = "DELETE FROM scheduled_calls WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $record_id);
    
    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    echo "Record ID not provided";
}

// Close database connection
$conn->close();
?>
