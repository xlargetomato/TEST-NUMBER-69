<?php
// Include your SQL connection file
include("sql.php");

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the course details from the POST data
    $courseName = isset($_POST["courseName"]) ? $_POST["courseName"] : null;
    $courseDoctor = isset($_POST["courseDoctor"]) ? $_POST["courseDoctor"] : null;
    $courseCode = isset($_POST["courseCode"]) ? $_POST["courseCode"] : null;

    // Check if any of the inputs is null
    if ($courseName === null || $courseDoctor === null || $courseCode === null) {
        echo "يرجى توفير جميع البيانات المطلوبة.";
        exit();
    }

    // Prepare the insert statement with placeholders
    $insertQuery = $MM->prepare("INSERT INTO subjects (name, doctor, code) VALUES (?, ?, ?)");

    // Bind the parameters
    $insertQuery->bind_param("sss", $courseName, $courseDoctor, $courseCode);

    // Execute the insert statement
    if ($insertQuery->execute()) {
        echo "تمت الإضافة بنجاح.";
    } else {
        echo "خطأ أثناء الإضافة: " . $MM->error;
    }

    // Close the prepared statement
    $insertQuery->close();

    // Close the database connection
    $MM->close();
} else {
    echo "Invalid request.";
}
?>
