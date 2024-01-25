<?php
session_start();
include("sql.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["level"])) {
        // Get form data
        $subject = mysqli_real_escape_string($MM, $_POST['selectedSubject']);
        $quizName = mysqli_real_escape_string($MM, $_POST['name']);

        // Insert quiz information into the database
        $insertQuizQuery = "INSERT INTO quiz (subj, name) VALUES ('$subject', '$quizName')";
        mysqli_query($MM, $insertQuizQuery);

        // Get the last inserted quiz ID
        $quizId = mysqli_insert_id($MM);

        // Loop through the submitted questions
        foreach ($_POST['questions'] as $question) {
            $quesText = mysqli_real_escape_string($MM, $question['text']);
            $opt1 = mysqli_real_escape_string($MM, $question['opt1']);
            $opt2 = mysqli_real_escape_string($MM, $question['opt2']);
            $opt3 = mysqli_real_escape_string($MM, $question['opt3']);
            $opt4 = mysqli_real_escape_string($MM, $question['opt4']);
            $correctAnswer = mysqli_real_escape_string($MM, $question['correctAnswer']);

            // Insert question into the database
            $insertQuestionQuery = "INSERT INTO quiz (id, subj, name, opt1, opt2, opt3, opt4, ans) VALUES ('$quizId', '$subject', '$quesText', '$opt1', '$opt2', '$opt3', '$opt4', '$correctAnswer')";
            mysqli_query($MM, $insertQuestionQuery);
        }

        // Return a success response
        echo "success";
    } else {
        // Return an error response
        header('HTTP/1.1 403 Forbidden');
        echo "Access Denied";
    }
} else {
    // Return an error response for non-POST requests
    header('HTTP/1.1 400 Bad Request');
    echo "Bad Request";
}
?>
