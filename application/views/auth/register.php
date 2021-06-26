<div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative">
            <div class="auth-box row text-center">
                <div class="col-lg-7 col-md-5 modal-bg-img" style="background-image: url(<?= base_url('assets') ?>/images/img4.jpg);">
                </div>
                <div class="col-lg-5 col-md-7 bg-white">
                    <div class="p-3">
                        <img src="<?= base_url('assets') ?>/home/images/logo-b.png" width="100">
                        <h3 class="mt-3 text-center">Register an Account</h3>
                        <form class="mt-4" action="<?= base_url('auth/userRegister') ?>" method="post">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="user_name" placeholder="Full Name" required="">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group reg-email">
                                        <input class="form-control" id="email_register" type="email" name="user_email" placeholder="Email" required="">
                                        <div class="text-danger email-alert my-1" style="font-size:12px;text-align: left;visibility: hidden;"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input class="form-control" type="password" id="input-pass" name="user_pass" placeholder="Password" required="">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input class="form-control" type="password" id="pass_register" name="k_pass" placeholder="Password Confirmation" required="">
                                        <div class="text-danger pass-alert my-1" style="font-size:12px;text-align: left;visibility: hidden;"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="btn btn-block btn-primary btn-register">Register</button>
                                </div>
                                <div class="col-lg-12 text-center mt-5">
                                    Already have an account? <a href="<?= base_url('login') ?>" class="text-danger">Login</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
    </div>