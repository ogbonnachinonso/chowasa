<?php
require_once "../db/connect.php";
?>
 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chowasa-<?php echo $title?></title>
   <!-- Res CSS Files -->
   <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
   <link href="../assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
   <link href="../assets/vendor/ionicons/css/ionicons.min.css" rel="stylesheet">
   <link href="../assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
   <link href="../assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
   <link href="../assets/vendor/venobox/venobox.css" rel="stylesheet">
   <link href="../assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Folio Main CSS File -->
  <link rel="stylesheet" href="../assets/css/admin.css">
 

</head>
 
<body>
<nav class="navbar navbar-b navbar-trans navbar-expand-md fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll" href="#page-top">
      <img src="../assets/img/logo.png" alt="Chowasa Logo">
      </a>
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <div class="navbar-collapse collapse justify-content-end" id="navbarDefault">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link js-scroll activ" href="../admin/home.php">Home</a>
          </li>
          
          <li class="nav-item">
              <a href="../admin/logout.php" class="nav-link js-scroll ">Logout</a>
            </li>
        </ul>
      </div>
    </div>
  </nav>