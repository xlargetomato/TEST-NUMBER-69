<?php
session_start();
include("sql.php");

if ($_SESSION["level"] != "") {
    $conn = $MM;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST['action'];

        switch ($action) {
            case 'add':
                $subj = $_SESSION['subj'];
                $name = $_SESSION['name'];
                $ques = $_POST['ques'];
                $opt1 = $_POST['opt1'];
                $opt2 = $_POST['opt2'];
                $opt3 = $_POST['opt3'];
                $opt4 = $_POST['opt4'];
                $ans = $_POST['ans'];

                $stmt = $conn->prepare("INSERT INTO quiz (subj, name, ques, opt1, opt2, opt3, opt4, ans) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssss", $subj, $name, $ques, $opt1, $opt2, $opt3, $opt4, $ans);
                $result = $stmt->execute();
                $stmt->close();
                break;

            case 'edit':
                $editId = $_POST['editId'];
                $ques = $_POST['ques'];
                $opt1 = $_POST['opt1'];
                $opt2 = $_POST['opt2'];
                $opt3 = $_POST['opt3'];
                $opt4 = $_POST['opt4'];
                $ans = $_POST['ans'];

                $stmt = $conn->prepare("UPDATE quiz SET ques = ?, opt1 = ?, opt2 = ?, opt3 = ?, opt4 = ?, ans = ? WHERE id = ?");
                $stmt->bind_param("ssssssi", $ques, $opt1, $opt2, $opt3, $opt4, $ans, $editId);
                $result = $stmt->execute();
                $stmt->close();
                break;

            case 'delete':
                $deleteId = $_POST['deleteId'];

                $stmt = $conn->prepare("DELETE FROM quiz WHERE id = ?");
                $stmt->bind_param("i", $deleteId);
                $result = $stmt->execute();
                $stmt->close();
                
                break;
        }

        $conn->close();
    }
}
?>
