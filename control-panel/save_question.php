<?php
session_start();
include("sql.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SESSION["level"] != "") {
    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve data from the Ajax request
        $subject = $_POST["subject"];
        $name = $_POST["name"];
        $question = $_POST["question"];
        $option1 = $_POST["option1"];
        $option2 = $_POST["option2"];
        $option3 = $_POST["option3"];
        $option4 = $_POST["option4"];
        $answer = $_POST["answer"];

        // Insert the question into the database
        $stmt = $MM->prepare("INSERT INTO quiz (subj, `name`, ques, opt1, opt2, opt3, opt4, ans) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $subject, $name,$question, $option1, $option2, $option3, $option4, $answer);

        // Check if the insertion was successful
        if ($stmt->execute()) {
            $response = 'success';
        } else {
            $response = 'error';
        }

        // Close the database connection
        $stmt->close();
        mysqli_close($MM);

        // Send the JSON response
        echo $response;
        exit;
    }
} else {
    header("Location: /index");
}
?>
