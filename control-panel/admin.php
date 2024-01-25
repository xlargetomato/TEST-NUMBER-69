<?php
include("sql.php");
session_start();
if ($_SESSION["level"] == "3") {
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
    href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;500;600;800;900;1000&display=swap"
      rel="stylesheet"
      />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/CSS/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
</head>

<body>
    <a href='/index' class='btn btn-secondary' style="position: absolute; top: 10px; left: 10px;">رجوع</a>

    <div class="container">
        <h2 class="text-center mb-4">Control Panel</h2>

        <!-- Sections Container -->
        <div class="section-container">
            <!-- Section 1: Lectures -->
            <div class="section bl">
                <div class="section-title">المقررات</div>
                <i class="fa-solid fa-gear"></i>                <div class="action-buttons">
                    <button onclick="window.location = 'sub-manage'" class="btn">إدارة المقررات</button>
                </div>
            </div>

            <!-- Section 2: Users Management -->
            <div class="section pu">
                <div class="section-title">إدارة المستخدمين</div>
                <i class="fa-solid fa-gear"></i>                <div class="action-buttons">
                    <button onclick="window.location = 'manage-users';" class="btn">إدارة المستخدمين</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between" style="position: absolute; top: 10px; right: 10px; left: 10px;">
        <button onclick="window.location = 'logout';" class="btn logout-btn">تسجيل الخروج</button>
        <?php if($_SESSION['level'] == 3){?>
        <?php }?>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
<?php
} else {
    header('Location: /index');
}
?>
