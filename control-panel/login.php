<?php
include "sql.php";
include "encdec.php";
ob_start();
session_start();
$prvkey = $_COOKIE['PHPSESSID'] . "sakgddgdsgsdgdg3441252";
$enckey = enc($prvkey, "elgmeza");
echo "<script>var key = '$enckey';</script>";
if (isset($_SESSION["level"]) == "") {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="login.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <!-- SweetAlert library -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
    href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;500;600;800;900;1000&display=swap"
      rel="stylesheet"
      />
        <title>وحدة التحكم | تسجيل الدخول</title>
    </head>
    <body>
        <div class="full">
            
            <canvas id="canvas" class="canvas"></canvas>
        </div>

        <div class="form-container">
            <h1>تسجيل الدخول</h1>
            <input type="text" placeholder="أسم المستخدم" style="text-align:center;" class="in form-control user" /><br>
            <input type="password" placeholder="كلمة السر" style="text-align:center;" class="in form-control pass" /><br>
            <a class="sub btn btn-success">تسجيل الدخول</a>
            <script>
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                const searchParams = urlParams.get('target');
                $(".sub").on("click", function () {
                    var user = $(".user").val();
                    var pass = $(".pass").val();
                    $.ajax({
                        url: "query.php",
                        type: "POST",
                        data: {
                            user: user,
                            pass: pass,
                            key: key
                        },
                        success: function (response) {
                            response = response.replace("</p>", "");
                            var a = response.split("-");
                            switch (a[0]) {
                                case "success":

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'تم تسجيل الدخول بنجاح',
                                        html: '<pre>اهلا ' + a[1] + '<br>حمدالله ع سلامة</pre>',
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                        timer: 2000,
                                        customClass: 'textsss',
                                        
                                    }).then(() => {
                                        window.location = "/index";
                                    });
                                    break;
                                case "database connection error please contact the developer.":
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'حدث خطأ',
                                        text: 'برجاء التواصل مع أحد المسئولين\nError code 220',
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                        timer: 2000,
                                    });
                                    break;
                                case "Missing info.":
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'خطأ',
                                        text: 'برجاء إدخال المعلومات كاملة',
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                        timer: 2000,
                                    });
                                    break;
                                case "Enc Error.":
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'حدث خطأ',
                                        text: 'برجاء التواصل مع أحد المسئولين\nError code 958',
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                        timer: 2000,
                                    });
                                    break;
                                case "failed":
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'خطأ',
                                        text: 'البيانات غير صحيحة',
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                        timer: 2000,
                                    });
                                    break;
                            }
                        }
                    });
                });
                </script>
                <script src="login.js"></script>
            <?php } else { ?>
                <script>
                    window.location = "/index";
                </script>
            <?php } ?>
    </body>

    </html>
