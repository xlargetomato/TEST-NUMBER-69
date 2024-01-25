<?php
include("sql.php");
session_start();
if ($_SESSION["level"] == "3") {
    ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة المستخدمين</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .user-card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: right;
        }

        .action-buttons {
            text-align: left;
        }

        .action-buttons a {
            font-size: 18px;
            font-weight: bold;
            margin-left: 10px;
            border-radius: 10px;
        }

        .action-buttons2 {
            text-align: right;
        }

        .action-buttons2 a {
            font-size: 18px;
            font-weight: bold;
            margin-right: 10px;
            border-radius: 10px;
        }

        .btn-primary {
            background-color: #007bff; /* Blue */
            color: #ffffff; /* White */
            border: 2px solid #0056b3; /* Dark Blue */
        }

        .btn-danger {
            background-color: #dc3545; /* Red */
            color: #ffffff; /* White */
            border: 2px solid #c82333; /* Dark Red */
        }

        .btn-info {
            background-color: #17a2b8; /* Teal */
            color: #ffffff; /* White */
            border: 2px solid #117a8b; /* Dark Teal */
        }

        .text-muted {
            color: #6c757d; /* Gray */
        }

        h3 {
            color: #007bff; /* Blue */
        }

        .mb-4 {
            margin-bottom: 2rem;
        }

        /* Added styles for the edit form */
        #editForm {
            display: none;
            margin-top: 20px;
        }

        .form-group {
            text-align: right;
        }

        .edit-form-btn {
        }

    </style>
</head>
<body>
<a href='/index' class='btn btn-secondary'style="position: absolute; top: 10px; left: 10px;">رجوع</a>

<div class="container">
    <h3 class="text-center mb-4">إدارة المستخدمين</h3>

    <!-- إضافة button -->
    <div class="action-buttons2 mb-4">
        <button href='add-user' class='bnn btn btn-success'> + إضافة</button>
            <!-- Add User Form -->
            <div style="display: none;" class="hide">
    <form id="addUserForm" >
        <div class="form-group">
            <label for="addUsername">اسم المستخدم:</label>
            <input type="text" class="form-control" id="addUsername" name="addUsername">
        </div>
        <div class="form-group">
            <label for="addName">الاسم:</label>
            <input type="text" class="form-control" id="addName" name="addName">
        </div>
        <div class="form-group">
            <label for="addPassword">كلمة السر:</label>
            <input type="password" class="form-control" id="addPassword" name="addPassword">
        </div>
        <div class="form-group">
            <label for="addLevel">مستوى الصلاحية:</label>

            <select class="form-control" id="addLevel" name="addLevel">
                <option value="2">مشرف</option>
                <option value="1">محرر</option>
            </select>
            
        </div>
    </form>
    <button class="btn btn-success add-btn">إضافة المستخدم</button>
    </div>
    </div>

    <?php
    $fetchQuery = "SELECT * FROM usr";
    $result = $MM->query($fetchQuery);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['level'] == 1 OR $row['level'] == 2) {
                ?>
                <div class="card user-card">
                    <h5 class="card-title">اسم المستخدم : <?php echo $row['username']; ?></h5>
                    <p class="card-text">الاسم : <?php echo $row['name']; ?></p>
                    <p class="card-text">الصلاحية : <?php if($row['level'] == 2){echo "مشرف";}else{echo "محرر";} ?></p>
                    <div class="action-buttons">
                        <button class='btn btn-primary edit-form-btn' data-password="<?=$row['password']?>" data-name="<?=$row['name']?>" data-level="<?=$row['level']?>" data-username="<?php echo $row['username']; ?>">تحرير</button>
                        <button class='btn btn-danger delete-btn' data-username="<?php echo $row['username']; ?>">حذف</button>
                    </div>

                    <!-- Edit Form -->
                    <form id="editForm-<?php echo $row['username']; ?>" method="post" style="display: none;">
                        <div class="form-group">
                            <label for="editUsername">اسم المستخدم:</label>
                            <input type="text" class="form-control" value="<?=$row['username']?>" id="editUsername" name="editUsername">
                        </div>
                        <div class="form-group">
                            <label for="editName">الاسم:</label>
                            <input type="text" class="form-control" id="editName" name="editName">
                        </div>
                        <div class="form-group">
                            <label for="editPassword">كلمة السر:</label>
                            <input type="password" class="form-control" id="editPassword" name="editPassword">
                        </div>
                        <div class="form-group">
                        <label for="editLevel">مستوى الصلاحية:</label>
                            <select class="form-control" id="editLevel" name="editLevel">
                                <option value="2">مشرف</option>
                                <option value="1">محرر</option>
                            </select>
                            <!-- <input type="number" min="1" max="2" class="form-control" id="editLevel" name="editLevel"> -->
                        </div>
                        <button class="btn btn-primary sub" data-username="<?=$row['username']?>">حفظ التغييرات</button>

                    </form>
                </div>
                <?php
            }
        }
    } else {
        echo "<p class='text-muted text-center'>لا يوجد مستخدمين حالياً.</p>";
    }
    $MM->close();
    ?>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<!-- jQuery for AJAX and toggling edit form visibility -->
<script>
    // Show the add user form when the "+ إضافة" button is clicked
    $(".bnn").click(function () {
        $(".hide").toggle();
    });

    // AJAX for adding user
    $(".add-btn").on("click", function (event) {
        // Prevent the default button action
        event.preventDefault();
        // Get form data
        var formData = $("#addUserForm").serializeArray();
        var level = parseInt($("#addLevel").val()); // Parse to ensure it's an integer
        var username = $("#addUsername").val();
        var name = $("#addName").val();
        var password = $("#addPassword").val();
        if(username.length >= 4 && password.length >= 6 && name.length >= 4){
        if (level === 1 || level === 2) {
        // Send AJAX request to add-user.php
        $.ajax({
            type: "POST",
            url: "add-user.php", // Update with the correct path to your PHP file
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
                });
                setTimeout(() => {  location.reload(); }, 3000);                
            },
            error: function (error) {
                // Handle the error
                console.log("Error:", error);
            }
        });
    } else {
                Swal.fire({
                    title: 'فشل :(',
                    text: 'يجب أن يكون مستوى الصلاحية بين 1 و 2',
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 2000,
                });
    }
}else{
    Swal.fire({
                    title: 'فشل :(',
                    html: 'يوجد بضعة شروط لإضافة مستخدم : <br> - أسم المستخدم لا يقل عن 4 أحرف <br> - الأسم لا يقل عن 4 أحرف <br> - كلمة السر لا تقل عن 6 أحرف',
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 2000,
                });
}
    });
</script>
<!-- AJAX for deleting user -->
<script>
    $(".delete-btn").on("click", function (event) {
        // Prevent the default button action
        event.preventDefault();

        // Get the username to be deleted
        var username = $(this).data("username");
        var userCard = $("#editForm-" + username).closest('.user-card'); // Find the parent user card

        // Confirm deletion with user
        Swal.fire({
            title: 'هل أنت متأكد أنك تريد حذف هذا المستخدم؟',
            text: 'لن يكون بإمكانك التراجع عن هذا الإجراء!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، قم بالحذف!',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to delete-user.php
                $.ajax({
                    type: "POST",
                    url: "delete-user.php", // Update with the correct path to your PHP file
                    data: { username: username },
                    success: function (response) {
                        response = response.replace("</p>", "");
                        // Handle the response (you may show a success message or perform any other action)
                        Swal.fire({
                            title: response.includes('بنجاح') ? 'تم الحذف بنجاح' : 'فشل :(',
                            text: response,
                            icon: response.includes('بنجاح') ? 'success' : 'error',
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 2000,
                        });

                        // Optionally, you can remove the deleted user card from the UI
                        userCard.remove();
                    },
                    error: function (error) {
                        // Handle the error
                        console.log("Error:", error);
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        // Toggle the edit form when any "تحرير" (Edit) button is clicked
        $(".edit-form-btn").click(function () {
            var username = $(this).data("username");
            var name = $(this).data("name");
            var password = $(this).data("password");
            var level = $(this).data("level");
            var editForm = $("#editForm-" + username);

            // Populate the form fields with user data
            editForm.find("#editUsername").val(username);
            editForm.find("#editName").val(name);
            editForm.find("#editPassword").val(password);
            editForm.find("#editLevel").val(level);
            // Toggle the edit form visibility
            editForm.toggle();
        });

        // AJAX for updating user information
        $(".sub").on("click", function (event) {
            // Prevent the default form submission
            event.preventDefault();

            // Get form data
            var form = $("#editForm-" + $(this).data("username"));
            var formData = form.serializeArray();
            var level = parseInt(form.find("#editLevel").val()); // Parse to ensure it's an integer

            // Check if the user level is 1 or 2 before sending the update request
            if (level === 1 || level === 2) {
                $.ajax({
                    type: "POST",
                    url: "edit-user.php", // Update with the correct path to your PHP file
                    data: formData,
                    success: function (response) {
                        response = response.replace("</p>", "");
                        // Handle the response (you may show a success message or perform any other action)
                        Swal.fire({
                            title: response.includes('بنجاح') ? 'كلو ميه ميه' : 'فشل :(',
                            text: response,
                            icon: response.includes('بنجاح') ? 'success' : 'error',
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 2000,
                        });
                    },
                    error: function (error) {
                        // Handle the error
                        console.log("Error:", error);
                    }
                });
            } else {
                Swal.fire({
                    title: 'فشل :(',
                    text: 'يجب أن يكون مستوى الصلاحية بين 1 و 2',
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 2000,
                });
            }
        });
    });
</script>

</body>
</html>
<?php
} else {
    header('Location: /index');
}
?>
