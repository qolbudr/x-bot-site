        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper m-0">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-sm-12 col-md-6 my-1 col-lg-9 align-self-center">
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Edit Bot</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="<?= base_url('app') ?>" class="text-muted">My Bot</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Edit Bot</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3 my-1 align-self-center text-right">
                        <div class="customize-input">
                            <button style="width:100%" data-toggle="modal" data-target="#addelement" class="btn btn-primary">Add a new element</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="row no-gutters">
                                <div class="col-lg-5 col-xl-4 border-right">
                                    <div class="card-body border-bottom d-flex" style="justify-content: space-between;">
                                        <h3>Coleca Bot</h3>
                                        <a class="font-12" href="<?= base_url('app/bot/preview/'.$bot_id) ?>" target="_blank"><i data-feather="external-link" class="feather-icon"></i></a>
                                    </div>
                                    <div class="element-box" id="element-box" style="height: calc(100vh - 111px);">
                                        <ul class="mailbox list-style-none">
                                            <li>
                                                <div class="message-center">
                                                    <!-- Message -->
                                                    <?php foreach ($element as $data) { ?>
                                                    <?php $idx = explode("#", $data->element_id); ?>
                                                    <a href="javascript:void(0)" data-id="<?= $data->element_id ?>" class="element-item d-flex align-items-center border-bottom px-3 py-2">
                                                        <div class="icon-element mr-3">
                                                            <i data-feather="cpu" class="feather-icon"></i>
                                                        </div>
                                                        <div class="w-75 d-inline-block v-middle pl-2">
                                                            <h6 class="element-text mb-0 mt-1"><?= ucwords($idx[0]) ?></h6>
                                                            <span class="font-12 text-nowrap d-block text-muted text-truncate"><?= $data->element_desc ?></span>
                                                            <span class="font-12 text-nowrap d-block text-muted"><?= $data->element_id ?></span>
                                                        </div>
                                                    </a>
                                                    <?php } ?>
                                                    
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-4  col-xl-5 border-right">
                                    <form action="<?= base_url('bot/editElement') ?>" method="post">
                                        <div class="element-edit py-4 px-4" style="height: calc(100vh - 111px);">
                                            <div class="row element-edit-row">
                                                <div class="text-center col-12" style="padding-top: 20%">
                                                    <img src="<?= base_url('assets/images/img5.jpg') ?>" class="v-middle" style="width: 300px">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-3  col-xl-3 px-4 py-4">
                                    <div class="img-box text-center">
                                        <a href="https://flex-vps.epizy.com" target="_blank">
                                            <img src="<?= base_url('assets/images/ads-v.jpg') ?>">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

        <!-- Center modal content -->
    <div class="modal fade" id="addelement" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Add a new Element</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="<?= base_url('bot/addElement') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Element Type</label>
                            <input type="hidden" name="bot_id" value="<?= $bot_id ?>">
                            <select class="form-control" name="element_tipe" required>
                                <option>Choose One</option>
                                <option value="option">Option</option>
                                <option value="question">Question</option>
                                <option value="text">Text</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Caption</label>
                            <input class="form-control" type="text" placeholder="Element Caption" name="element_capt" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Element Description</label>
                            <textarea class="form-control" placeholder="This element to ask about customer email" name="element_desc" rows="5" required></textarea>
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

    <div class="modal fade" id="delete-element" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Delete Element</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Are you sure want to delete this element ?</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <a href="javascript:void(0)" class="btn btn-primary element_delete">Delete</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->