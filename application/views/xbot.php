<!-- ============================================================== --> -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper ml-0">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-sm-12 col-md-6 my-1 col-lg-9 align-self-center">
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">X-Bot</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><span href="javascript:void(0)" class="text-muted">Create your own Bot</span></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <?php if($bot_count > 0) { ?>
                        <div class="col-sm-6 col-md-6 col-lg-3 my-1 align-self-center text-right">
                            <div class="customize-input">
                                <button style="width:100%" data-toggle="modal" data-target="#addbot" class="btn btn-primary">Create a new Bot</button>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- basic table -->
                <?php if($bot_count == 0) { ?>
                    <div class="text-center mt-5">
                        <h5 class="card-subtitle">You have no Bot yet..</h5>
                        <div class="text-center my-3">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addbot">Create a new one</button>
                        </div>
                    </div>
                <?php }?>
                <div class="row">
                    <?php foreach($bot_data as $data) { ?>
                        <div class="col-md-6 col-lg-4 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <img src="<?= base_url('assets/images/bot_photo/'.$data->bot_id.'/'.$data->bot_photo) ?>" alt="user" class="rounded-circle mr-2 align-self-center" width="40" height="40">
                                        <div class="bot-info">
                                            <h4 class="card-title"><?= $data->bot_name ?></h4>
                                            <h6 class="card-subtitle mb-0"><?= $data->bot_desc ?></h6>
                                        </div>
                                    </div>
                                    <div class="dropdown sub-dropdown text-right">
                                        <button class="btn btn-link text-muted dropdown-toggle" type="button" id="dd1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i data-feather="more-horizontal"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1">
                                            <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#renamebot" data-id="<?= $data->bot_id ?>">Rename</a>
                                            <a class="dropdown-item" href="<?= base_url('app/bot/'.$data->bot_id) ?>">Edit</a>
                                            <a class="dropdown-item text-danger" href="javascript:void(0)" data-toggle="modal" data-target="#deletebot" data-id="<?= $data->bot_id ?>">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center text-muted">All Rights Reserved by qolbudr. Designed and Developed by <a href="https://www.instagram.com/qolbudr/">qolbudr</a>.</footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

    <!-- Center modal content -->
    <div class="modal fade" id="addbot" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Add a new Bot</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="<?= base_url('bot/addBot') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12 text-center">
                            <label for="upload_photo" style="cursor: pointer;"><img src="<?= $this->session->userdata('user_photo') ?>" alt="user" class="rounded-circle" width="80"></label>
                            <input type="file" id="upload_photo" name="bot_photo" style="visibility: hidden;position: absolute;z-index: -1" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Bot Name</label>
                            <input class="form-control" type="text" placeholder="Bot Name" name="bot_name" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Bot Description</label>
                            <textarea class="form-control" placeholder="This bot require to handle customer request" name="bot_desc" rows="5" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Center modal content -->
    <div class="modal fade" id="renamebot" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Rename Bot</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="<?= base_url('bot/renameBot') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="bot_id_rename">
                        <div class="form-group col-md-12 text-center">
                            <label for="upload_photo_rename" style="cursor: pointer;"><img src="<?= $this->session->userdata('user_photo') ?>" alt="user" class="rounded-circle bot_photo_rename" width="80"></label>
                            <input type="file" id="upload_photo_rename" name="bot_photo_rename" style="visibility: hidden;position: absolute;z-index: -1">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Bot Name</label>
                            <input class="form-control" type="text" placeholder="Bot Name" name="bot_name_rename" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Bot Description</label>
                            <textarea class="form-control" placeholder="This bot require to handle customer request" name="bot_desc_rename" rows="5" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Center modal content -->
    <div class="modal fade" id="deletebot" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Delete Bot</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Are you sure want to delete this Bot ?</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <a href="javascript:void(0)" class="btn btn-primary bot_delete">Delete</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->