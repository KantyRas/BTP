<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>Login</title>
  <link rel="shortcut icon" type="image/png" href="<?php echo base_url() ?>assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/styles.min.css" />
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="<?php echo base_url() ?>assets/images/logos/dark-logo.svg" width="180" alt="">
                </a>
                <p class="text-center">Your Social Campaigns</p>
                <form action="<?php echo base_url('Connexion/validLogin') ?>" method="post">
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                      name="email">
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">password</label>
                    <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                      name="password">
                  </div>
                  <input type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" value="Sign In">
                  <div class="d-flex align-items-center justify-content-center">
                    <a class="text-primary fw-bold ms-2" href="<?php echo base_url('Welcome/index') ?>">Se connecter en
                      tant que client.</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?php echo base_url() ?>assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>