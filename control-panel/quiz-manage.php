<?php
include("sql.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if ($_SESSION["level"] != "") {
    ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة الاختبار</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <style>
        .card {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin: 10px;
            padding: 15px;
            max-width: 300px;
        }

        .add-btn {
            margin-top: 10px;
        }
    </style>
</head>
<body class="container" style="text-align:right;">

<?php
if (isset($_GET['subj']) && isset($_GET['name'])) {
    $subj = $_GET['subj'];
    $_SESSION['subj'] = $_GET['subj'];
    $name = $_GET['name'];
    $_SESSION['name'] = $_GET['name'];

    $stmt = $MM->prepare("SELECT id, ques, opt1, opt2, opt3, opt4, ans, corr FROM quiz WHERE subj = ? AND name = ?");
    $stmt->bind_param("ss", $subj, $name);
    $stmt->execute();
    $result = $stmt->get_result();
?>

    <h1 class="mt-4 mb-4">قائمة الأسئلة</h1>
    <button class="btn btn-success add-btn" data-toggle="modal" data-target="#exampleModalCenter" onclick="showAddForm()">إضافة سؤال جديد</button>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="card">
            <p><strong>السؤال :</strong> <?php echo $row['ques']; ?></p>
            <button class="btn btn-warning edit-btn" data-toggle="modal" data-target="#editModalCenter" onclick='showEditForm("<?=$row["id"]?>","<?=$row["ques"]?>","<?=$row["opt1"]?>","<?=$row["opt2"]?>","<?=$row["opt3"]?>","<?=$row["opt4"]?>","<?=$row["ans"]?>","<?php if($row["corr"] != "null"){ echo $row["corr"];}else{echo "null";} ?>")'>تعديل</button><br>
            <button class="btn btn-danger delete-btn" data-question-id="<?php echo $row['id']; ?>">حذف</button>
        </div>
    <?php } ?>
    <!-- Add Question Form Popup -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">إضافة سؤال</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="text-align:right;">
        <form id="question-form">
            <div class="form-group">
                <label for="ques">السؤال:</label>
                <input type="text" class="form-control" name="ques" required>
            </div>

            <div class="form-group">
                <input type="radio" name="ans" value="opt1" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>الخيار 1:</label>
                <input type="text" class="form-control" name="opt1" required>
            </div>

            <div class="form-group">
                <input type="radio" name="ans" value="opt2" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>الخيار 2:</label>
                <input type="text" class="form-control" name="opt2" required>
            </div>

            <div class="form-group">
                <input type="radio" name="ans" value="opt3" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>الخيار 3:</label>
                <input type="text" class="form-control" name="opt3" required>
            </div>

            <div class="form-group">
                <input type="radio" name="ans" value="opt4" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>الخيار 4:</label>
                <input type="text" class="form-control" name="opt4" required>
            </div>

            <div class="form-group">
                <input type="checkbox" name="check" id="ischecked" class="form-check-input">&nbsp;&nbsp;&nbsp;
                <label>التصحيح :</label>
                <input type="text" id="corr" class="form-control" name="corr" disabled>
            </div>
           
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
            <button type="submit" class="btn btn-primary">إضافة السؤال</button>
            </form>
        </div>
        </div>
    </div>
    </div>

<!-- 
    <div id="add-question-form" class="modal-body" style="display: none;">
        <form id="question-form">
            <div class="form-group">
                <label for="ques">السؤال:</label>
                <input type="text" class="form-control" name="ques" required>
            </div>

            <div class="form-group">
                <label>الخيار 1:</label>
                <input type="text" class="form-control" name="opt1" required>
            </div>

            <div class="form-group">
                <label>الخيار 2:</label>
                <input type="text" class="form-control" name="opt2" required>
            </div>

            <div class="form-group">
                <label>الخيار 3:</label>
                <input type="text" class="form-control" name="opt3" required>
            </div>

            <div class="form-group">
                <label>الخيار 4:</label>
                <input type="text" class="form-control" name="opt4" required>
            </div>

            <div class="form-group">
                <label for="ans">الإجابة الصحيحة:</label>
                <input type="text" class="form-control" name="ans" required>
            </div>

            <button type="button" class="btn btn-primary" onclick="addQuestion()">إضافة السؤال</button>
        </form>
    </div> -->

    <!-- Edit Question Form Popup -->
    <div class="modal fade" id="editModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">تحديث سؤال</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="text-align:right;">
        <div id="edit-question-form" style="display: none;">
        <form id="edit-form">
            <div class="form-group">
                <label for="edit-ques">السؤال:</label>
                <input type="text" class="form-control" id="edit-ques" name="ques" required>
            </div>

            <div class="form-group">
                <input type="radio" name="ans" value="opt1" class="ans1" id="edit-ans" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>الخيار 1:</label>
                <input type="text" class="form-control" id="edit-opt1" name="opt1" required>
            </div>

            <div class="form-group">
                <input type="radio" name="ans" value="opt2" class="ans2" id="edit-ans" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>الخيار 2:</label>
                <input type="text" class="form-control" id="edit-opt2" name="opt2" required>
            </div>

            <div class="form-group">
                <input type="radio" name="ans" value="opt3" class="ans3" id="edit-ans" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>الخيار 3:</label>
                <input type="text" class="form-control" id="edit-opt3" name="opt3" required>
            </div>

            <div class="form-group">
                <input type="radio" name="ans" value="opt4" class="ans4" id="edit-ans" class="form-check-input" required>&nbsp;&nbsp;&nbsp;
                <label>الخيار 4:</label>
                <input type="text" class="form-control" id="edit-opt4" name="opt4" required>
            </div>
            <input type="hidden" id="edit-question-id" name="id">
            <div class="form-group">
                <input type="checkbox" name="check" id="edit-ischecked" class="form-check-input">&nbsp;&nbsp;&nbsp;
                <label>التصحيح :</label>
                <input type="text" id="edit-corr" class="form-control" name="corr" disabled>
            </div>
    </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
            <button type="submit" class="btn btn-primary">تحديث السؤال</button>
            </form>
        </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        // Show add question form
        function showAddForm() {
            $('#add-question-form').show();
        }

        // Show edit question form
        function showEditForm(questionId, ques, opt1, opt2, opt3, opt4, ans, corr) {
            $('#edit-question-form #edit-question-id').val(questionId);
            $('#edit-question-form #edit-ques').val(ques);
            $('#edit-question-form #edit-opt1').val(opt1);
            $('#edit-question-form #edit-opt2').val(opt2);
            $('#edit-question-form #edit-opt3').val(opt3);
            $('#edit-question-form #edit-opt4').val(opt4);
            var cor = corr.replace('"',"");
            switch(cor){
                case "null":
                    $("#edit-ischecked").prop('checked', false);
                    $("#edit-corr").prop('required',false);
                    $("#edit-corr").prop('disabled',true);
                    break;
                default:
                    $("#edit-corr").prop('required',true);
                    $("#edit-corr").prop('disabled',false);
                    $("#edit-ischecked").prop('checked', true);
                    $('#edit-question-form #edit-corr').val(corr);
                    break;
            }

            switch (ans){
                case "opt1":
                    $('.ans1').attr('checked', true);
                    break;
                case "opt2":
                    $('.ans2').attr('checked', true);
                    break;
                case "opt3":
                    $('.ans3').attr('checked', true);
                    break;
                case "opt4":
                    $('.ans4').attr('checked', true);
                    break;
                    
            }
            $('#edit-question-form').show();
        }
        $("#edit-ischecked").change(function(){
            var editcheck = $('#edit-ischecked').is(":checked");
        if(editcheck == 1){
            $("#edit-corr").prop('required',true);
            $("#edit-corr").prop('disabled',false);
        }else{
            $("#edit-corr").prop('required',false);
            $("#edit-corr").prop('disabled',true);
            $("#edit-corr").val("");
        }
        });
        $("#ischecked").change(function(){
            var check = $('#ischecked').is(":checked");
            if (check == 1) {
                $("#corr").prop('required', true);
                $("#corr").prop('disabled', false);
            } else {
                $("#corr").prop('required', false);
                $("#corr").prop('disabled', true);
                $("#corr").val(""); // Clear the input value when disabled
            }
        });

        
        // Add new question using AJAX
        $('#question-form').on("submit",function(e){
            // Get form data
            e.preventDefault();
            var formData = $('#question-form').serialize();

            // AJAX request to add question
            $.ajax({
                type: 'POST',
                url: 'add_question.php', // Replace with the actual file handling AJAX requests
                data: formData,
                success: function(response) {
                    response = response.replace("</p>","");
                    var result = JSON.parse(response);
                    if (result.success) {
                        // Display success message
                        Swal.fire({
                            icon: 'success',
                            title: 'تمت إضافة السؤال بنجاح!',
                        }).then(function () {
                            // Reload the page to refresh the question list
                            location.reload();
                        });
                    } else {
                        // Display error message
                        Swal.fire({
                            icon: 'error',
                            title: 'حدث خطأ أثناء إضافة السؤال',
                        });
                    }
                },
                error: function() {
                    // Display error message
                    Swal.fire({
                        icon: 'error',
                        title: 'فشلت الطلب عبر AJAX',
                    });
                }
            });
        });

        // Update question using AJAX
        $('#edit-form').on("submit",function(e){
            e.preventDefault();
            // Get form data
            var formData = $('#edit-form').serialize();

            // AJAX request to update question
            $.ajax({
                type: 'POST',
                url: 'update_question.php', // Replace with the actual file handling AJAX requests
                data: formData,
                success: function(response) {
                    response = response.replace("</p>","");
                    var result = JSON.parse(response);
                    if (result.success) {
                        // Display success message
                        Swal.fire({
                            icon: 'success',
                            title: 'تم تحديث السؤال بنجاح!',
                        }).then(function () {
                            // Reload the page to refresh the question list
                            location.reload();
                        });
                    } else {
                        // Display error message
                        Swal.fire({
                            icon: 'error',
                            title: 'حدث خطأ أثناء تحديث السؤال',
                        });
                    }
                },
                error: function() {
                    // Display error message
                    Swal.fire({
                        icon: 'error',
                        title: 'فشلت الطلب عبر AJAX',
                    });
                }
            });
        });

        // Delete question using AJAX
        $(document).on('click', '.delete-btn', function() {
            var questionId = $(this).data('question-id');

            // AJAX request to delete question
            $.ajax({
                type: 'POST',
                url: 'delete_question.php', // Replace with the actual file handling AJAX requests
                data: { action: 'deleteQuestion', id: questionId },
                success: function(response) {
                    response = response.replace("</p>","");
                    var result = JSON.parse(response);
                    if (result.success) {
                        // Display success message
                        Swal.fire({
                            icon: 'success',
                            title: 'تم حذف السؤال بنجاح!',
                        }).then(function () {
                            // Reload the page to refresh the question list
                            location.reload();
                        });
                    } else {
                        // Display error message
                        Swal.fire({
                            icon: 'error',
                            title: 'حدث خطأ أثناء حذف السؤال',
                        });
                    }
                },
                error: function() {
                    // Display error message
                    Swal.fire({
                        icon: 'error',
                        title: 'فشلت الطلب عبر AJAX',
                    });
                }
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
}else{ header("Location: quiz-step-1");}} else {
    header("Location: /index");
}
?>