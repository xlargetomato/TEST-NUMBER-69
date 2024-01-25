<?php
include 'sql.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if lectnum is set and not empty
if (isset($_POST['lectnum']) && !empty($_POST['lectnum']) && !empty($_POST['code'])) {
    $lectnum = $_POST['lectnum'];
    $code = $_POST['code'];

    // Prepare the query with placeholders
    $duplicateCheckQuery = "SELECT * FROM content WHERE lectnum = ? AND subcode = ?";
    $stmt = $MM->prepare($duplicateCheckQuery);

    // Bind the parameters
    $stmt->bind_param("ss", $lectnum, $code);

    // Execute the query
    $stmt->execute();

    // Get the result
    $stmt->store_result();

    // Check for duplicate lectnum in the database
    if ($stmt->num_rows == 0) {
        // Lectnum already exists
        echo "!exists";
    } else {
        // Lectnum doesn't exist
        echo "exists";
    }

    // Close the prepared statement
    $stmt->close();
} else {
    // Invalid or missing lectnum parameter
    echo "error";
}

// Close the MySQL connection
$MM->close();
?>
