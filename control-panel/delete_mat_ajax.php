<?php
if (isset($_POST['pdfurl'])) {
    $pdfUrlToDelete = urldecode($_POST['pdfurl']);

    // Include the MySQL connection file
    include 'sql.php';

    // Prepare the delete query with a placeholder
    $deleteQuery = "DELETE FROM content WHERE pdfurl = ?";
    $stmt = $MM->prepare($deleteQuery);

    // Bind the parameter
    $stmt->bind_param("s", $pdfUrlToDelete);

    // Execute the delete query
    if ($stmt->execute()) {
        // Delete the actual file from the server
        unlink($pdfUrlToDelete);
        echo "تم حذف الملف والسجل بنجاح.";
    } else {
        echo "حدث خطأ أثناء حذف الملف والسجل: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
    // Close the MySQL connection
    $MM->close();
} else {
    echo "لم يتم تحديد ملف لحذفه.";
}
?>
