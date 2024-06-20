<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Systeme Commerciale</title>
    <link rel="shortcut icon" type="image/png"
        href="https://uploads.turbologo.com/uploads/design/hq_preview_image/3107965/draw_svg20210709-18787-1c4fiyb.svg.png" />
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <aside class="left-sidebar">
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="<?php echo base_url('Welcome/index') ?>" class="text-nowrap logo-img">
                        <img src="https://t4.ftcdn.net/jpg/05/10/43/31/360_F_510433198_5wwRWSeKjQkW58r0reyRMBwPtSqRFop4.jpg"
                            width="180" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <?php if ($idprofil == 2) { ?>
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">GESTION</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="<?php echo base_url('FrontController/load_page_devis') ?>"
                                    aria-expanded="false">
                                    <span>
                                        <i class="ti ti-file"></i>
                                    </span>
                                    <span class="hide-menu">Devis</span>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">Home</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link"
                                    href="<?php echo base_url('BackController/load_page_tableau_de_bord') ?>"
                                    aria-expanded="false">
                                    <span>
                                        <i class="ti ti-dashboard"></i>
                                    </span>
                                    <span class="hide-menu">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">SUIVI</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link"
                                    href="<?php echo base_url('BackController/load_page_devis_encours') ?>"
                                    aria-expanded="false">
                                    <span>
                                        <i class="ti ti-file"></i>
                                    </span>
                                    <span class="hide-menu">Devis en cours</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link"
                                    href="<?php echo base_url('BackController/load_page_import_travaux') ?>"
                                    aria-expanded="false">
                                    <span>
                                        <i class="ti ti-file"></i>
                                    </span>
                                    <span class="hide-menu">Import Travaux-Devis</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link"
                                    href="<?php echo base_url('BackController/load_page_import_paie') ?>"
                                    aria-expanded="false">
                                    <span>
                                        <i class="ti ti-file"></i>
                                    </span>
                                    <span class="hide-menu">Import Paiement</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link"
                                    href="<?php echo base_url('BackController/load_page_liste_travaux') ?>"
                                    aria-expanded="false">
                                    <span>
                                        <i class="ti ti-file"></i>
                                    </span>
                                    <span class="hide-menu">Types Travaux</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="<?php echo base_url('BackController/load_liste_finition') ?>"
                                    aria-expanded="false">
                                    <span>
                                        <i class="ti ti-file"></i>
                                    </span>
                                    <span class="hide-menu">Types Finitions</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="body-wrapper">
            <header class="app-header">

                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                                <i class="ti ti-bell-ringing"></i>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                        </li>
                    </ul>
                    <h3>Bienvenue nº <?php echo $numero ?></h3>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="<?php echo base_url() ?>/assets/images/profile/user-1.jpg" alt=""
                                        width="35" height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">My Profile</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-mail fs-6"></i>
                                            <p class="mb-0 fs-3">My Account</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-list-check fs-6"></i>
                                            <p class="mb-0 fs-3">My Task</p>
                                        </a>
                                        <a href="<?php echo base_url('Connexion/disconnect') ?>"
                                            class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <div class="container-fluid">


                <script src="<?php echo base_url() ?>/assets/libs/jquery/dist/jquery.min.js"></script>
                <script src="<?php echo base_url() ?>/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
                <script src="<?php echo base_url() ?>/assets/js/sidebarmenu.js"></script>
                <script src="<?php echo base_url() ?>/assets/js/app.min.js"></script>
                <script src="<?php echo base_url() ?>/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
                <script src="<?php echo base_url() ?>/assets/libs/simplebar/dist/simplebar.js"></script>
                <script src="<?php echo base_url() ?>/assets/js/dashboard.js"></script>