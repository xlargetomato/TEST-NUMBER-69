<?php
include("sql.php");
session_start();
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
        <style>
            body {
                background-color: #f8f9fa;
            }
            .container {
                margin-top: 30px;
            }
            .card {
                margin-bottom: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .card-header {
                background-color: #007bff;
                color: black;
                justify-content: center;
                border-radius: 10px 10px 0 0;
            }
            .card-body {
                padding: 20px;
            }
            .btn-edit, .btn-delete {
                border: none;
                width: 60px;
                padding: 6px;
                border-radius: 5px;
                cursor: pointer;
                font-size: 10px;
                display: block;
                margin: 0 auto; /* Center the buttons horizontally */
            }
            .btn-add {
                border: none;
                width: 40px;
                padding: 6px;
                border-radius: 5px;
                cursor: pointer;
                font-size: 10px;
                background-color: #28a745;
            }
            .btn-edit {
                background-color: #ffc107;
            }
            .btn-delete {
                background-color: #dc3545;
            }
            .quiz-name {
                font-size: 16px;
                color: #007bff;
            }
            .label {
                color: black;
                font-weight: bold;
                font-size: 14px;
            }
            .text-muted {
                color: #6c757d; /* Gray */
            }
            .counter {
                font-size: 14px;
                color: #6c757d; /* Gray */
            }
        </style>
        <title>وحدة التحكم | عرض الاختبارات</title>
    </head>
    <body>
    <div class="container">
        <div class="row">
            <div class="col-xs-6"></div>
            <div class="col-xs-6 text-right">
                <button class="btn btn-success btn-add" onclick="location.href='quiz-step-1.php'">إضافة +</button>
            </div>
        </div>

        <?php
        $subjectsQuery = $MM->query("SELECT DISTINCT subj FROM quiz");

        $quizzesExist = false;

        while ($subjectRow = $subjectsQuery->fetch_assoc()) {
            $subject = $subjectRow['subj'];
            ?>

            <h3 style="text-align:center;"><?php echo $subject; ?></h3>
                <?php
                $quizzesQuery = $MM->query("SELECT * FROM quiz WHERE subj = '$subject' GROUP BY name");

                if ($quizzesQuery->num_rows > 0) {
                    while ($quizRow = $quizzesQuery->fetch_assoc()) {
                        $quizName = $quizRow['name'];
                        $quizId = $quizRow['id'];
                        $quizSub = $quizRow['subj'];

                        // Count the number of questions for each quiz
                        $questionsCountQuery = $MM->query("SELECT * FROM quiz WHERE name = '$quizName' and subj = '$quizSub'");
                        $questionsCount = $questionsCountQuery->num_rows;

                        ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <button class="btn btn-warning btn-edit"
                                                onclick='window.location= "quiz-manage?name=<?php echo $quizName; ?>&subj=<?php echo $quizSub;?>"'>تعديل
                                        </button>
                                        <br>
                                        <button class="btn btn-danger btn-delete"
                                                onclick='deleteQuiz("<?php echo $quizName; ?>")'>حذف
                                        </button>
                                    </div>
                                    <div class="col-xs-9">
                                        <h4 class="quiz-name"><?php echo $quizName; ?></h4>
                                        <p class="label">عدد الأسئلة: <?php echo $questionsCount; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p class='text-muted' style='text-align: center; font-size: 14px;'>لا يوجد اختبارات حاليا</p>";
                }
                ?>
        <?php
        $quizzesExist = true;
    }

    if (!$quizzesExist) {
        echo "<p class='text-muted' style='text-align: center; font-size: 14px;'>لا يوجد اختبارات حاليا</p>";
    }
    ?>
            </div>
        </div>
    <script>
        function deleteQuiz(quizName) {
            // Use SweetAlert for confirmation
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "لن يمكنك التراجع عن هذا الإجراء!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'إلغاء',
                confirmButtonText: 'نعم، قم بالحذف!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, proceed with deletion
                    $.ajax({
                        url: 'delete_quiz_ajax.php',
                        type: 'POST',
                        data: {name: quizName},
                        success: function (response) {
                            response = response.replace("</p>", "");

                            // Use SweetAlert for success message
                            Swal.fire({
                                icon: 'success',
                                title: 'تم حذف الاختبار بنجاح!',
                                text: response,
                                confirmButtonColor: '#28a745',
                            }).then(() => {
                                // Remove the deleted quiz from the UI
                                $(`h4:contains('${quizName}')`).closest('.card').remove();
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        },
                        error: function (error) {
                            console.error('Error:', error);
                        }
                    });
                }
            });
        }
    </script>

    </div>
    </body>
    </html>

    <?php
} else {
    header('Location: login?target=quiz');
}
?>
