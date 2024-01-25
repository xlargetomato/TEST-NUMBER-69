<?php
// Include your SQL connection file
include("sql.php");

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the course code from the POST data
    $courseCode = $_POST["courseCode"];

    // Prepare the delete query with a placeholder
    $deleteQuery = "DELETE FROM subjects WHERE code = ?";
    $stmt = $MM->prepare($deleteQuery);

    // Bind the parameter
    $stmt->bind_param("s", $courseCode);

    // Execute the delete query
    if ($stmt->execute()) {
        // Now, fetch related content records
        $selectQuery = "SELECT * FROM content WHERE subcode = ?";
        $stmtSelect = $MM->prepare($selectQuery);
        $stmtSelect->bind_param("s", $courseCode);
        $stmtSelect->execute();
        $result = $stmtSelect->get_result();

        // Loop through the result and delete associated records and files
        while ($row = $result->fetch_assoc()) {
            $pdfUrlToDelete = urldecode($row['pdfurl']);

            // Delete the record from the database
            $deleteContentQuery = "DELETE FROM content WHERE pdfurl = ?";
            $stmtDeleteContent = $MM->prepare($deleteContentQuery);
            $stmtDeleteContent->bind_param("s", $pdfUrlToDelete);

            if ($stmtDeleteContent->execute()) {
                // Delete the actual file from the server
                unlink($pdfUrlToDelete);
            }
        }

        $stmtSelect->close();
        echo "تم الحذف بنجاح.";
    } else {
        echo "خطأ أثناء الحذف: " . $MM->error;
    }

    // Close the prepared statement
    $stmt->close();

    // Close the database connection
    $MM->close();
}
?>
