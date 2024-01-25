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
    $ques = sanitizeInput($_POST['ques']);
    $opt1 = sanitizeInput($_POST['opt1']);
    $opt2 = sanitizeInput($_POST['opt2']);
    $opt3 = sanitizeInput($_POST['opt3']);
    $opt4 = sanitizeInput($_POST['opt4']);
    $ans = sanitizeInput($_POST['ans']);
    $corr = sanitizeInput($_POST['corr']);
    
    if(empty($corr)){$corr = "null";}

    // Check for null inputs
    if (empty($id) || empty($ques) || empty($opt1) || empty($opt2) || empty($opt3) || empty($opt4) || empty($ans) || empty($corr)) {
        echo json_encode(array("success" => false, "error" => "All fields are required"));
        exit();
    }

    $stmt = $MM->prepare("UPDATE quiz SET ques = ?, opt1 = ?, opt2 = ?, opt3 = ?, opt4 = ?, ans = ?, corr = ? WHERE id = ?");
    $stmt->bind_param("sssssssi", $ques, $opt1, $opt2, $opt3, $opt4, $ans, $corr, $id);
    $result = $stmt->execute();
    $stmt->close();

    if ($result) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, "error" => "Database error"));
    }
}
?>
