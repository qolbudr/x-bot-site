
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
            <div class="auth-box row">
                <div class="col-lg-7 col-md-5 modal-bg-img" style="background-image: url(<?= base_url('assets') ?>/images/img4.jpg);">
                </div>
                <div class="col-lg-5 col-md-7 bg-white">
                    <div class="p-3">
                        <div class="text-center">
                            <img src="<?= base_url('assets') ?>/home/images/logo-b.png" width="100">
                        </div>
                        <h3 class="mt-3 text-center">Login to X-Bot</h3>
                        <?php if($this->session->flashdata('login_status') == 'failed') { ?>
                        <span class="text-danger my-2">Login failed, wrong email/password</span>
                        <?php } ?>
                        <form action="<?= base_url('auth/authLogin') ?>" method="post" class="mt-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <a href="<?= $loginURL ?>" class="btn btn-block btn-dark">Login with Google</a>
                                    <div class="text-center py-2">or</div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="uname">Email</label>
                                        <input class="form-control" id="uname" name="user_email" type="email"
                                            placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="pwd">Password</label>
                                        <input class="form-control" id="pwd" name="user_pass" type="password"
                                            placeholder="Password" required>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="btn btn-block btn-primary">Login</button>
                                </div>
                                <div class="col-lg-12 text-center mt-5">
                                    Doesn't have an account? <a href="<?= base_url('register') ?>" class="text-danger">Register</a>
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