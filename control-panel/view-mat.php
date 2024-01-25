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
  <title>عرض وحذف المحاضرات</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="sub.css">
<link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
    href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;500;600;800;900;1000&display=swap"
      rel="stylesheet"
      />
</head>
<body>
<a href="/index" class="btn btn-secondary back-btn">رجوع</a>
<br>
<div class="container-two-mat">
  <h2 class="mb-4 text-right">عرض وحذف المحاضرات</h2>

  <?php
  // Fetch PDF files from the database, ordered by subcode and lectnum
  $fetchQuery = "SELECT * FROM content ORDER BY subcode, lectnum";
  $result = $MM->query($fetchQuery);

  if ($result->num_rows > 0) {
    $currentSubcode = null;

    while ($row = $result->fetch_assoc()) {
      $lectnum = $row['lectnum'];
      $subcode = $row['subcode'];
      $nn = "SELECT * FROM subjects WHERE `code`='$subcode'";
      $res = $MM->query($nn);
      $ren = $res->fetch_assoc();
      $subcode = $ren['name'];
      $pdfUrl = $row['pdfurl'];

      // Check if a new subject code is encountered
      if ($subcode != $currentSubcode) {
        // Close the previous list if not the first iteration
        if ($currentSubcode !== null) {
          echo '</ul>';
        }

        // Start a new list for the current subject code
        echo '<h3 class="mt-4 text-right">' . $subcode . '</h3>';
        echo '<ul class="list-group">';
        $currentSubcode = $subcode;
      }

      echo '<li class="list-group-item">';
      echo '<div class="d-flex justify-content-between align-items-center">';
      echo '<div>';
      echo '<p class="mb-0 text-right">المحاضرة رقم : <strong>' . $lectnum . '</strong></p>';
      echo '</div>';
      echo '<div>';
      echo '<a href="' . $pdfUrl . '" class="btn btn-primary btn-sm" target="_blank">عرض</a>';
      echo '<button class="btn btn-danger btn-sm delete-btn" data-pdfurl="' . $pdfUrl . '">حذف</button>';
      echo '</div>';
      echo '</div>';
      echo '</li>';
    }

    // Close the last list
    echo '</ul>';
  } else {
    echo '<p class="text-muted text-right">لا توجد محاضرات لعرضها حالياً.</p>';
  }

  // Close the MySQL connection
  $MM->close();
  ?>

</div>

<script>
// Handle delete button click using SweetAlert for confirmation
$('.delete-btn').click(function() {
  var pdfUrlToDelete = $(this).data('pdfurl');
  // Show confirmation alert before proceeding with deletion
  Swal.fire({
    title: 'هل أنت متأكد؟',
    text: 'سيتم حذف هذه المحاضرة نهائياً!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'نعم، حذف',
    cancelButtonText: 'إلغاء'
  }).then((result) => {
    if (result.isConfirmed) {
      // Proceed with the deletion using AJAX
      $.ajax({
        url: 'delete_mat_ajax.php',
        type: 'POST',
        data: { pdfurl: pdfUrlToDelete },
        success: function(response) {
          // Remove </p> tag from the response
          response = response.replace("</p>", "");
          
          // Display success message using SweetAlert
          Swal.fire({
            icon: 'success',
            title: 'تم الحذف بنجاح!',
            showCancelButton: false,
            showConfirmButton: false,
            timer: 2000,
            text: response,
          }).then(() => {
            // Refresh the list after successful deletion
            location.reload();
          });
        },
        error: function(error) {
          // Display error message using SweetAlert
          Swal.fire({
            icon: 'error',
            title: 'خطأ',
            showCancelButton: false,
            showConfirmButton: false,
            timer: 2000,
            text: 'حدث خطأ أثناء إجراء العملية.',
          });
          console.log(error);
        }
      });
    }
  });
});
</script>

</body>
</html>

<?php } else {
    header('Location: login?target=view-mat');
} ?>
