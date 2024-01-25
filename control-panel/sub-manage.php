<?php
// Include your SQL connection file
session_start();
include("sql.php");

if ($_SESSION["level"] == "3") {
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
    href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;500;600;800;900;1000&display=swap"
      rel="stylesheet"
      />
    <link rel="stylesheet" href="sub.css">
</head>
<body>
<a href='/index' class='btn btn-secondary'style="position: absolute; top: 10px; left: 10px;">رجوع</a>
<div class="container">
    <h3 class="text-center mb-4">إدارة المقررات</h3>

    <!-- إضافة مقرر button -->
    <div class="mb-4 text-right">
    <button class='btn btn-success ml-auto' id="toggleFormBtn">إضافة مقرر جديد</button>
</div>


<!-- Add Course Form -->
<form id="addCourseForm">
    <div class="form-group">
        <label for="courseName">اسم المقرر:</label>
        <input type="text" class="form-control" id="courseName" name="courseName">
    </div>
    <div class="form-group">
        <label for="courseDoctor">دكتور المقرر:</label>
        <input type="text" class="form-control" id="courseDoctor" name="courseDoctor">
    </div>
    <div class="form-group">
        <label for="courseCode">كود المقرر:</label>
        <input type="number" class="form-control" id="courseCode" name="courseCode">
    </div>
    <div class="form-group text-right">
        <button type="button" class="btn btn-secondary" id="cancelBtn">إلغاء</button>
        <button type="button" class="btn btn-success" id="addCourseBtn">إضافة مقرر</button>
    </div>
</form>



    <!-- مقررات List -->
    <?php
    $fetchQuery = "SELECT * FROM subjects";
    $result = $MM->query($fetchQuery);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
    ?>
    <div class="course-form">
        <h5 class="card-title">اسم المقرر: <?php echo $row['name']; ?></h5>
        <p class="card-text">دكتور المقرر: <?php echo $row['doctor']; ?></p>
        <p class="card-text">كود المقرر: <?php echo $row['code']; ?></p>
        <div class="action-buttons">
            <button class='btn btn-danger delete-course-btn' data-course-id="<?=$row['code']?>">حذف</button>
        </div>
    </div>
    <?php
        }
    } else {
        echo "<p class='text-muted text-center'>لا يوجد مقررات حالياً.</p>";
    }
    $MM->close();
    ?>
</div>

<script>
    // Toggle show/hide of the add course form
    $("#toggleFormBtn").on("click", function () {
        $("#addCourseForm").toggle();
    });

    // AJAX for adding course
    $("#addCourseBtn").on("click", function () {
        // Get form data
        var formData = $("#addCourseForm").serializeArray();

        // Send AJAX request to add-course.php
        $.ajax({
            type: "POST",
            url: "add-course.php", // Update with the correct path to your PHP file
            data: formData,
            success: function (response) {
                response = response.replace("</p>", "");
                // Handle the response (you may show a success message or perform any other action)
                Swal.fire({
                    title: response.includes('بنجاح') ? 'تمت الإضافة بنجاح' : 'فشل :(',
                    text: response,
                    icon: response.includes('بنجاح') ? 'success' : 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 2000,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
                // Reload the page to update the courses list
                setTimeout(() => {  location.reload(); }, 3000);                
            },
            error: function (error) {
                // Handle the error
                console.log("Error:", error);
            }
        });
    });

    // AJAX for deleting course
    $(".delete-course-btn").on("click", function (event) {
    // Prevent the default button action
    event.preventDefault();

    // Get the course code to be deleted
    var courseCode = $(this).data("course-id");

    // Confirm deletion with the user
    Swal.fire({
        title: 'هل أنت متأكد أنك تريد حذف هذا المقرر؟',
        text: 'لن يكون بإمكانك التراجع عن هذا الإجراء!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'نعم، قم بالحذف!',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            // Send AJAX request to delete-course.php
            $.ajax({
                type: "POST",
                url: "delete-course.php", // Update with the correct path to your PHP file
                data: { courseCode: courseCode },
                success: function (response) {
                    response = response.replace(/<\/?script[^>]*>/g, "");
                    response = response.replace("</p>", "");
                    // Handle the response (you may show a success message or perform any other action)
                    Swal.fire({
                        title: response.includes('بنجاح') ? 'تم الحذف بنجاح' : 'فشل :(',
                        text: response,
                        icon: response.includes('بنجاح') ? 'success' : 'error',
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 2000,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    // Reload the page to update the courses list
                    setTimeout(() => { location.reload(); }, 3000);
                },
                error: function (error) {
                    // Handle the error
                    console.log("Error:", error);
                }
            });
        }
    });
});

// Cancel button for hiding the add course form
$("#cancelBtn").on("click", function () {
    $("#addCourseForm").hide();
});
</script>
</body>
</html>

<?php
} else {
    header('Location: /index');
}
?>
