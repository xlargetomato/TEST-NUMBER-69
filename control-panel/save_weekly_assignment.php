<?php
include("sql.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $subject = isset($_POST['subject']) ? $MM->real_escape_string($_POST['subject']) : '';
    $endDate = isset($_POST['endDate']) ? $MM->real_escape_string($_POST['endDate']) : '';
    $content = isset($_POST['content']) ? $MM->real_escape_string($_POST['content']) : '';

    // Check for null or empty values
    if (empty($subject) || empty($endDate) || empty($content)) {
        echo "Missing information.";
    } else {
        // Check if an assignment for the subject already exists
        $checkQuery = $MM->prepare("SELECT * FROM weekly WHERE `subj` = ?");
        $checkQuery->bind_param("s", $subject);
        $checkQuery->execute();
        $result = $checkQuery->get_result();

        if ($result->num_rows > 0) {
            // Assignment for the subject already exists
            echo "Assignment for this subject already exists.";
        } else {
            // Use prepared statement to prevent SQL injection
            $insertQuery = $MM->prepare("INSERT INTO weekly (`subj`, `date-to`, `content`) VALUES (?, ?, ?)");
            $insertQuery->bind_param("sss", $subject, $endDate, $content);

            if ($insertQuery->execute()) {
                echo "success";
            } else {
                echo "Error: " . $insertQuery->error;
            }

            $insertQuery->close();
        }

        $checkQuery->close();
    }
}
?>
