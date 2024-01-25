<?php
include("sql.php");

$query = "SELECT * FROM weekly";
$result = $MM->query($query);

if ($result) {
    // Check if the query execution was successful
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="card user-card">';
            echo '<h3 class="text-right card-title">' . htmlspecialchars($row['subj']) . '</h3>';
            echo '<p class="text-right card-text"><strong>تاريخ الانتهاء :</strong> ' . htmlspecialchars($row['date-to']) . '</p>';
            echo '<p class="text-right card-text"><strong>التكليف :</strong> ' . htmlspecialchars($row['content']) . '</p>';
            echo '<div class="btn2"><button type="button" class="btn1 btn btn-danger" onclick="deleteAssignment('. "'" . $row['subj'] . "'" .')">حذف</button></div>';
            echo '</div>';
        }
    } else {
        echo '<p class="text-muted text-right">لا توجد تكليفات لعرضها حاليًا.</p>';
    }
} else {
    // Handle query execution error
    echo '<p class="text-danger text-right">حدث خطأ أثناء استعلام قاعدة البيانات.</p>';
}
?>
