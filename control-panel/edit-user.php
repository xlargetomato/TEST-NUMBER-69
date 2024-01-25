<?php
include("sql.php"); // Make sure to replace with your actual database connection file
session_start();

if ($_SESSION["level"] == "3") {
    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the data from the AJAX request
        $editUsername = isset($_POST["editUsername"]) ? $_POST["editUsername"] : null;
        $editName = isset($_POST["editName"]) ? $_POST["editName"] : null;
        $editPassword = isset($_POST["editPassword"]) ? $_POST["editPassword"] : null;
        $editLevel = isset($_POST["editLevel"]) ? $_POST["editLevel"] : null;

        // Check if any of the inputs is null
        if ($editUsername === null || $editName === null || $editPassword === null || $editLevel === null) {
            echo "يرجى توفير جميع البيانات المطلوبة.";
            exit();
        }

        // Prepare the update query with placeholders
        $updateQuery = "UPDATE usr SET name=?, password=?, level=? WHERE username=?";
        $stmt = $MM->prepare($updateQuery);

        // Bind parameters
        $stmt->bind_param("ssss", $editName, $editPassword, $editLevel, $editUsername);

        // Execute the update query
        if ($stmt->execute()) {
            echo "تم تحديث معلومات المستخدم بنجاح";
        } else {
            echo "حدث خطأ أثناء تحديث معلومات المستخدم: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // If the request method is not POST, redirect to the main page
        header('Location: index');
    }
    $MM->close();
} else {
    // If the user does not have the required level, redirect to the main page
    header('Location: index');
}
?>
