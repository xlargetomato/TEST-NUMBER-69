<?php
include("sql.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assignmentId = $_POST["assignmentId"];

    // Perform the delete operation, replace 'your_table_name' with your actual table name
    $sql = "DELETE FROM weekly WHERE `subj` = ?";
    $stmt = $MM->prepare($sql);
    $stmt->bind_param('s', $assignmentId);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>
