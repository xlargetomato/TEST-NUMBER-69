<?php
session_start();
include("sql.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SESSION["level"] != "") {
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>اختيار المقرر واسم الاختبار</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .btn {
            margin: 10px;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
    </style>
</head>
<script>
    function submitForm() {
    var selectedSubject = document.getElementById("subj").value;
    var quizName = document.getElementById("name").value;

    if (selectedSubject && quizName) {
        window.location.href = "quiz-manage?subj=" + encodeURIComponent(selectedSubject) + "&name=" + encodeURIComponent(quizName);
    } else {
        alert("يرجى اختيار المقرر وإدخال اسم الاختبار");
    }
}
</script>
<body>
    <div class="container">
        <h2 style="text-align: center;">اختيار المقرر واسم الاختبار</h2>

        <label for="subj">اختر المقرر:</label>
        <select class="form-control" id="subj" name="subj" required>
        <option disabled selected value="">اسم المقرر</option>
            <?php
            $subjects = mysqli_query($MM, "SELECT * FROM `subjects`");
            foreach ($subjects as $subject) {
                echo "<option value='" . $subject['name'] . "'>" . $subject['name'] . "</option>";
            }
            ?>
        </select>
        <div id="hidden"><br>
        <label for="name">اسم الاختبار:</label>
        <input type="text" class="form-control" id="name" name="name" required>

        <div class="btn-container">
            <button type="button" class="btn btn-primary" onclick="submitForm()">التالي</button>
        </div>
        </div>
    </div>
</body>

<script>
    $(document).ready(function () {
        $('#hidden').hide();

        $('#subj').on('change', function () {
            $('#hidden').show();
        });
    });
</script>

</body>
</html>
<?php
} else {
    header("Location: /index");
}
?>
