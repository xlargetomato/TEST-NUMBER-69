<?php
include("sql.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["username"])) {
    $username = $_POST["username"];

    // Prepare the delete query with a placeholder
    $deleteQuery = "DELETE FROM usr WHERE username = ?";
    $stmt = $MM->prepare($deleteQuery);

    // Bind the parameter
    $stmt->bind_param("s", $username);

    // Execute the delete query
    if ($stmt->execute()) {
        echo "تم الحذف بنجاح.";
    } else {
        echo "فشل في عملية الحذف: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
    $MM->close();
} else {
    echo "Invalid request.";
}
?>
