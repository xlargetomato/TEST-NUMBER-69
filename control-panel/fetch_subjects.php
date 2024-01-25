<?php
include("sql.php");

$query = "SELECT * FROM subjects";
$result = $MM->query($query);

$options = '<option value="" disabled selected>اختر المقرر</option>';

if ($result) {
    // Check if the query execution was successful
    while ($row = $result->fetch_assoc()) {
        $options .= '<option value="' . htmlspecialchars($row['name']) . '">' . htmlspecialchars($row['name']) . '</option>';
    }
} else {
    // Handle query execution error
    $options = '<option value="" disabled selected>خطأ في جلب المقررات</option>';
}

echo $options;
?>
