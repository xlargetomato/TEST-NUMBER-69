<?php
$doctorName = isset($_POST['doctorName']) ? $_POST['doctorName'] : null;
$lectureNumber = isset($_POST['lectureNumber']) ? $_POST['lectureNumber'] : null;
$notes = isset($_POST['notes']) && !empty($_POST['notes']) ? $_POST['notes'] : 'لا يوجد';

// Check if any required input is null
if ($doctorName === null || $lectureNumber === null) {
    echo "خطأ: يجب توفير جميع البيانات المطلوبة.";
    exit();
}

// Check if lecture number is not a number
if (!is_numeric($lectureNumber)) {
    echo "خطأ: رقم المحاضرة يجب أن يكون قيمة رقمية صحيحة.";
    exit();
}

// Check if a file is attached
if (empty($_FILES["lectureFile"]["name"])) {
    echo "خطأ: لا يوجد ملف مرفق.";
    exit();
}

$targetDir = "uploads/";
$originalFileName = $_FILES["lectureFile"]["name"];
$fileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

// Check if file type is allowed
$allowedTypes = array("pdf", "doc", "docx");
if (!in_array($fileType, $allowedTypes)) {
    echo "خطأ: يُسمح فقط بالملفات بصيغة PDF، DOC، و DOCX.";
    exit();
}

// Generate a random filename to avoid duplication
$newFileName = generateRandomFilename($targetDir, $originalFileName);
$targetFile = $targetDir . basename($newFileName);

// Include the MySQL connection file
include 'sql.php';

// Check if subcode is NULL
if ($doctorName === 'nothing') {
    echo "خطأ: يجب أختيار مقرر";
    exit();
}

// Check for duplicate lectnum before uploading the file
$duplicateCheckQuery = "SELECT * FROM content WHERE lectnum = '$lectureNumber' AND subcode = '$doctorName'";
$result = $MM->query($duplicateCheckQuery);

if ($result->num_rows == 0) {
    // Move the uploaded file if lectnum is not a duplicate
    if (move_uploaded_file($_FILES["lectureFile"]["tmp_name"], $targetFile)) {
        // Database insertion
        $pdfUrl = $targetFile; // Assuming you want to store the file path

        // Prepare and bind parameters to avoid SQL injection
        $insertQuery = $MM->prepare("INSERT INTO content (pdfurl, subcode, lectnum, note) VALUES (?, ?, ?, ?)");
        $insertQuery->bind_param("ssss", $pdfUrl, $doctorName, $lectureNumber, $notes);

        if ($insertQuery->execute()) {
            echo "تم رفع الملف بنجاح.";
        } else {
            echo "خطأ في إدراج البيانات في قاعدة البيانات: " . $MM->error;
        }

        // Close the prepared statement
        $insertQuery->close();
    } else {
        echo "خطأ في رفع الملف.";
    }
} else {
    echo "خطأ: رقم المحاضرة موجود بالفعل في قاعدة البيانات.";
}

// Function to generate a random filename
function generateRandomFilename($targetDir, $originalFileName) {
    $newFileName = md5(uniqid(rand(), true)) . '_' . $originalFileName;
    return $newFileName;
}
?>
