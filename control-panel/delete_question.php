<?php
session_start();
include("sql.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a function to sanitize user inputs
    function sanitizeInput($data) {
        // Implement your sanitization logic here
        return htmlspecialchars(strip_tags(trim($data)));
    }

    $id = sanitizeInput($_POST['id']);

    // Check for null inputs
    if (empty($id)) {
        echo json_encode(array("success" => false, "error" => "Question ID is required"));
        exit();
    }

    $stmt = $MM->prepare("DELETE FROM quiz WHERE id = ?");
    $stmt->bind_param("s", $id);
    $result = $stmt->execute();
    $stmt->close();

    if ($result) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, "error" => "Database error"));
    }
}
?>
