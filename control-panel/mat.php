<?php 
include("sql.php");
session_start();
if($_SESSION["level"] != ""){
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>وحدة التحكم | رفع وتعديل المقررات</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="sub.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
    href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;500;600;800;900;1000&display=swap"
      rel="stylesheet"
      />
</head>

<body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
function uploadFile() {
    var lectt = $("#lectureNumber").val();
    var code = $("#doctorName").val();
    var form = $('#uploadForm')[0];
    var formData = new FormData(form);

    $.ajax({
        url: 'ajax_duplicate_check.php',
        type: 'POST',
        data: { lectnum: lectt, code: code },
        success: function(response) {
            response = response.replace("</p>", "");
            if (response === "exists") {
                Swal.fire({
                    title: 'خطأ',
                    text: 'المحاضرة موجودة بالفعل',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else if (response === "!exists") {
                // Show loading SweetAlert with animated spinner
                Swal.fire({
                    title: 'برجاء الإنتظار جاري رفع الملف ....',
                    imageUrl: 'loading.gif',  // Replace with the actual path to your loading GIF
                    imageAlt: 'جاري الرفع...',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    onBeforeOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: 'upload.php',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(uploadResponse) {
                        // Close loading SweetAlert
                        Swal.close();
                        uploadResponse = uploadResponse.replace("</p>", "");
                        // Display response with SweetAlert
                        Swal.fire({
                            title: uploadResponse.includes('بنجاح') ? 'كلو ميه ميه' : 'فشل :(',
                            text: uploadResponse,
                            icon: uploadResponse.includes('بنجاح') ? 'success' : 'error',
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 2000,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            } else {
                Swal.fire({
                    title: 'خطأ',
                    text: 'حدث خطأ أثناء التحقق من رقم المحاضرة',
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 2000,
                    });
            }
        },
        error: function(error) {
            alert('Error checking duplicate lecture number.');
            console.log(error);
        }
    });
}

function goBack() {
    window.location.href = '/index';
}
</script>

<body>
<button type="button" class="btn btn-secondary" onclick="goBack()" style="position: absolute; top: 10px; left: 10px;">رجوع</button>
<div class="container mt-5 position-relative">
  <!-- Back button at the top left -->
  <form id="uploadForm" enctype="multipart/form-data">
    <div class="form-group row">
      <label for="doctorName" class="col-sm-3 col-form-label text-right">اسم المقرر</label>
      <div class="col-sm-9">
        <select class="form-control" id="doctorName" name="doctorName">
        <!-- Add options dynamically if needed -->
        <?php $num = 0; foreach(mysqli_query($MM,"Select * FROM `subjects`") as $x){ $num++; ?>
        <option value="<?=$x['code']?>"><?=$x['name']?></option>
        <?php }if($num == 0){ ?>
        <option value="nothing">لم يتم العثور علي مقررات</option>
        <?php } ?>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="lectureNumber" class="col-sm-3 col-form-label text-right">رقم المحاضرة</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" id="lectureNumber" name="lectureNumber">
      </div>
    </div>
    <div class="form-group row">
      <label for="lectureFile" class="col-sm-3 col-form-label text-right">رفع المحاضرة</label>
      <div class="col-sm-9">
        <input type="file" class="form-control-file" id="lectureFile" name="lectureFile">
      </div>
    </div>
    <div class="form-group row">
      <label for="notes" class="col-sm-3 col-form-label text-right">ملاحظات</label>
      <div class="col-sm-9">
        <textarea class="form-control" id="notes" name="notes"></textarea>
      </div>
    </div>
    <div class="form-group row">
  <div class="col-sm-9 offset-sm-3 text-right">
    <button type="button" class="btn btn-primary" onclick="uploadFile()">إرسال</button>
  </div>
</div>
  </form>
  <div id="response"></div>
</div>

</body>
</html>

<?php }else{
    header('Location: login?target=mat');
} ?>
