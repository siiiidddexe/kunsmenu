
<?php ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title> Admin Dashboard | Kun Roll</title>
  <link rel="icon" href="../kunrolltext.png" type="image/x-icon">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css" />
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
  <!-- MDB -->
  <link rel="stylesheet" href="css/mdb.min.css" />
  <!-- Custom styles -->
  <link rel="stylesheet" href="css/admin.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
    crossorigin="anonymous"></script>
</head>

<body style=" overflow: hidden">
  <!--Main Navigation-->
  <header style="margin-bottom: 50px;">
    <!-- Sidebar -->
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
      <div class="position-sticky">
        <div class="list-group list-group-flush mx-3 mt-4">
          <a href="index.php" class="list-group-item list-group-item-action py-4 " >
            <i class="fa-solid fa-cart-shopping fa-fw me-3"></i><span>Place an Order</span>
          
          </a>

          <a href="incoming.php" class="list-group-item list-group-item-action py-4 active " >
            <i class="fa-solid fa-paper-plane fa-fw me-3"></i><span>Incoming Orders</span>
          
          </a>

          <a href="kdsadmin.php" class="list-group-item list-group-item-action py-4 " >
            <i class="fa-brands fa-codepen fa-fw me-3"></i><span>KDS System</span>
          
          </a>

          <a href="order.php" class="list-group-item list-group-item-action py-4" >
            <i class="fas fa-chart-area fa-fw me-3"></i><span>Upload Product</span>
          </a>
        </div>
      </div>
    </nav>
    <!-- Sidebar -->

    <!-- Navbar -->
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
      <!-- Container wrapper -->
      <div class="container-fluid">
        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-mdb-collapse-init data-mdb-target="#sidebarMenu"
          aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>

        <!-- Brand -->
        <a class="navbar-brand" href="index.php">
            <img src="web-logo-02.png" height="50px" alt="" loading="lazy" />
        </a>

        <!-- Right links -->
        <ul class="navbar-nav ms-auto d-flex flex-row">
          <!-- Notification dropdown -->

          <!-- Icon -->
          <li class="nav-item me-3 me-lg-0">
          <a class="dropdown-item" href="https://intern-website-amber.vercel.app/"><i class="fa-solid fa-code" style="padding-right:5px; padding-top:12px;"></i>WebSoft Technologies</a>
          </li>

          <!-- Icon dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link me-3 me-lg-0 dropdown-toggle arrow" href="#" id="navbarDropdown" role="button"
              data-mdb-dropdown-init aria-expanded="false">
              <i class="united kingdom flag m-0"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
 
              <li>
                <hr class="dropdown-divider" />
              </li>
              <li>
                <a class="dropdown-item" href="https://intern-website-amber.vercel.app/"><i class="fa-solid fa-code" style="padding-right:5px;"></i>WebSoft Technologies</a>
          
              </li>
              <li>
              <a class="dropdown-item" href="https://www.instagram.com/siiiddd.exe/"><i class="fa-brands fa-instagram" style="padding-right:10px; margin-left:2px;"></i> Instagram</a>
             
              </li>
              <li>
              <a class="dropdown-item" href="mailto:websoft.enquiry@gmail.com" style="text-decoration: none; color: inherit;">
        <i class="fas fa-envelope" style="padding-right: 10px; margin-left: 2px;"></i> Email Us
    </a>
              </li>

              <li>
              <a class="dropdown-item" href="https://wa.me/p/7552813751452466/918549013115" style="text-decoration: none; color: inherit;">
        <i class="fab fa-whatsapp" style="padding-right: 10px; margin-left: 2px;"></i> WhatsApp Us
    </a>
              </li>
              <li>
              <a class="dropdown-item" href="https://github.com/siiiidddexe" style="text-decoration: none; color: inherit;">
        <i class="fab fa-github" style="padding-right: 10px; margin-left: 2px;"></i> GitHub
    </a>
              </li>
              <li>
              <a class="dropdown-item" href="https://www.facebook.com/SiddhantSundar/" style="text-decoration: none; color: inherit;">
        <i class="fab fa-facebook" style="padding-right: 10px; margin-left: 2px;"></i> Facebook
    </a>
              </li>
              <li>
              <a class="dropdown-item" href="tel:+918549013115" style="text-decoration: none; color: inherit;">
        <i class="fas fa-phone" style="padding-right: 10px; margin-left: 2px;"></i> Call Us
    </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
  </header>
  <!--Main Navigation-->

  <!--Main layout-->
  <main style="padding-top: 20px">
    <div class="container-fluid"  >
      <!-- Your container content here -->
      <iframe  src="orderstatus.php" ></iframe>
    </div>
  </main>
  <!--Main layout-->
  
  <!-- MDB -->
  <script type="text/javascript" src="js/mdb.umd.min.js"></script>
  <!-- Custom scripts -->
  <script type="text/javascript" src="js/admin.js"></script>
</body>

</html>
