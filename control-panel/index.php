<?php 
include("sql.php");
session_start();
if($_SESSION["level"] != ""){
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>Control Panel</title>

    <!-- Bootstrap CSS -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
    href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;500;600;800;900;1000&display=swap"
      rel="stylesheet"
      />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/CSS/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<br>
    <div class="section-container">
        <!-- Section 1: Lectures -->
        <div class="section ss" >
            <div class="section-title"> محاضرات </div>
            <i class="fa-solid fa-gear"></i> 
            <div class="action-buttons">
                <button onclick="window.location = 'view-mat';" class="btn lectures-btn">عرض المحاضرات</button>
                <button onclick="window.location = 'mat';" class="btn lectures-btn">إضافة محاضرة</button>
            </div>
        </div>

        <!-- Section 2: Quizzes -->
        <div class="section sa">
            <div class="section-title"> Soon @ver 0.2</div>
            <i class="fa-solid fa-gear"></i> 
            <div class="action-buttons">
                <button class="btn quizzes-btn">Quiz System</button>
            </div>
        </div>
    </div>

    <!-- Logout and Admin CPANEL Buttons -->
    <div class="d-flex justify-content-between" style="position: absolute; top: 10px; right: 10px; left: 10px;">
        <button onclick="window.location = 'logout';" class="btn logout-btn">تسجيل الخروج</button>
        <?php if($_SESSION['level'] == 3){?>
        <button onclick="window.location = 'admin';" class="btn admin-btn ml-2">Admin CPANEL</button>
        <?php }?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>

<?php }else{
    header('Location: login?target=index');
} ?>
