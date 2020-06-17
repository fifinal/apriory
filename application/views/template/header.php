<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Satumart - <?= $title ?>
  </title>
  <!-- Favicon -->
  <link href="<?= base_url() ?>assets/img/brand/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="<?= base_url() ?>assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="<?= base_url() ?>assets/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/css/datatables.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    .overlay {
      position: absolute;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, .4);
      z-index: 9;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .loader {

      position: absolute;
      /* border: 16px solid #f3f3f3; */
      /* Light grey */
      /* border-top: 16px solid #3498db; */
      /* Blue */
      border-radius: 50%;
      width: 100px;
      height: 100px;
      animation: spin 2s linear infinite;
      border-top: 16px solid blue;
      border-right: 16px solid green;
      border-bottom: 16px solid red;
      border-left: 16px solid pink;
    }

    p {
      margin: 0;
      padding: 0;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }
  </style>
  <script src="<?= base_url() ?>assets/js/plugins/jquery/dist/jquery.min.js"></script>
  <script src="<?= base_url() ?>assets/js/datatables.min.js"></script>
  <script src="<?= base_url() ?>assets/js/pdfmake-0.1.36/pdfmake.min.js"></script>
  <script src="<?= base_url() ?>assets/js/pdfmake-0.1.36/vfs_fonts.js"></script>
  <script src="<?= base_url() ?>assets/js/JSZip-2.5.0/jszip.min.js"></script>
  <!--   Core   -->
  <script src="<?= base_url() ?>assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!--   Optional JS   -->
  <script src="<?= base_url() ?>assets/js/plugins/chart.js/dist/Chart.min.js"></script>
  <script src="<?= base_url() ?>assets/js/plugins/chart.js/dist/Chart.extension.js"></script>
  <!--   Argon JS   -->
  <script src="<?= base_url() ?>assets/js/argon-dashboard.min.js?v=1.1.0"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

</head>

<body class="">
  <div class="overlay" id="overlay">
    <div class="loader">

    </div>
  </div>

  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Brand -->
      <a class="navbar-brand pt-0" href="./index.html">
        <img src="<?= base_url() ?>assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
      </a>

      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ni ni-bell-55"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" src="<?= base_url() ?>assets/img/theme/team-1-800x800.jpg">
              </span>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
            <div class=" dropdown-header noti-title">
              <h6 class="text-overflow m-0">Welcome!</h6>
            </div>
            <a href="<?= base_url() ?>admin/" class="dropdown-item">
              <i class="ni ni-single-02"></i>
              <span>My profile</span>
            </a>
            <a href="<?= base_url() ?>admin/" class="dropdown-item">
              <i class="ni ni-settings-gear-65"></i>
              <span>Settings</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#!" class="dropdown-item">
              <i class="ni ni-user-run"></i>
              <span>Logout</span>
            </a>
          </div>
        </li>
      </ul>

      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">

        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="./index.html">
                <img src="<?= base_url() ?>assets/img/brand/blue.png">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>

        <!-- Navigation -->
        <h6 class="navbar-heading">
          <a class="" href="<?= base_url() ?>dashboard">
            <i class="ni ni-tv-2 mr-3"></i> Dashboard
          </a>
        </h6>
        <!-- Divider -->
        <hr class="my-3">
        <ul class="navbar-nav">
          <li class="nav-item">
            <div class="" id="master">
              <ul class=" nav-collapse">
                <li class="nav-item <?= ($nav == "produk") ? "active" : "" ?>">
                  <a class="nav-link <?= ($nav == "produk") ? "active" : "" ?>" href="<?= base_url() ?>produk">
                    Produk
                  </a>
                </li>
                <li class="nav-item <?= ($nav == "transaksi") ? "active" : "" ?>">
                  <a class="nav-link <?= ($nav == "transaksi") ? "active" : "" ?>" href="<?= base_url() ?>transaksi">
                    Transaksi
                  </a>
                </li>
                <li class="nav-item <?= ($nav == "apriori") ? "active" : "" ?>">
                  <a class="nav-link" <?= ($nav == "apriori") ? "active" : "" ?> href="<?= base_url() ?>apriori">
                    Apriori
                  </a>
                </li>
                <li class="nav-item <?= ($nav == "rule") ? "active" : "" ?>">
                  <a class="nav-link <?= ($nav == "rule") ? "active" : "" ?>" href="<?= base_url() ?>rule">
                    Rule
                  </a>
                </li>
                <li class="nav-item <?= ($nav == "laporan") ? "active" : "" ?>">
                  <a class="nav-link <?= ($nav == "laporan") ? "active" : "" ?>" href="<?= base_url() ?>laporan">
                    Laporan
                  </a>
                </li>

              </ul>
            </div>
          </li>

        </ul>

      </div>

    </div>
  </nav>

  <div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <!-- <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="./index.html">Dashboard</a> -->
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Dashboards</a></li>
            <li class="breadcrumb-item active" aria-current="page">Default</li>
          </ol>
        </nav>
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img alt="Image placeholder" src="<?= base_url() ?>assets/img/theme/team-4-800x800.jpg">
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm  font-weight-bold">Jessica Jones</span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
              <div class=" dropdown-header noti-title">
                <h6 class="text-overflow m-0">Welcome!</h6>
              </div>
              <a href="<?= base_url() ?>admin/" class="dropdown-item">
                <i class="ni ni-single-02"></i>
                <span>My profile</span>
              </a>
              <a href="<?= base_url() ?>admin/" class="dropdown-item">
                <i class="ni ni-settings-gear-65"></i>
                <span>Settings</span>
              </a>
              s <div class="dropdown-divider"></div>
              <a href="#!" class="dropdown-item">
                <i class="ni ni-user-run"></i>
                <span>Logout</span>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->