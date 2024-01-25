<?php
// delete_quiz_ajax.php
include("sql.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quizName = $_POST["name"];

    // Check if the quiz name is provided
    if (empty($quizName)) {
        echo "اسم الاختبار مطلوب.";
        exit();
    }

    // Sanitize the input to prevent SQL injection
    $quizName = $MM->real_escape_string($quizName);

    // Perform the deletion query
    $deleteQuery = "DELETE FROM quiz WHERE name = '$quizName'";

    if ($MM->query($deleteQuery) === TRUE) {
        echo "تم حذف الاختبار بنجاح بإسم: $quizName";
    } else {
        echo "خطأ في حذف الاختبار: " . $MM->error;
    }

    $MM->close();
}
?>
