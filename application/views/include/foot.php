<!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?= base_url('assets') ?>/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url('assets') ?>/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?= base_url('assets') ?>/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="<?= base_url('dist') ?>/js/app-style-switcher.js"></script>
    <script src="<?= base_url('dist') ?>/js/feather.min.js"></script>
    <script src="<?= base_url('assets') ?>/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?= base_url('dist') ?>/js/sidebarmenu.js"></script>
    <script src="<?= base_url('dist') ?>/js/prism.js"></script>
    <!--Custom JavaScript -->
    <script src="<?= base_url('dist') ?>/js/custom.min.js"></script>
    <script src="<?= base_url('dist') ?>/js/slimscroll.js"></script>
    <!--This page JavaScript -->
    <script src="<?= base_url('assets') ?>/extra-libs/c3/d3.min.js"></script>
    <script src="<?= base_url('assets') ?>/extra-libs/c3/c3.min.js"></script>
    <script src="<?= base_url('assets') ?>/libs/sweetalert.min.js"></script>
    <script src="<?= base_url('assets') ?>/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    

    <?php if($this->uri->segment(2) == "") { ?>
    <script>
        $("#renamebot").on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('id');
            $.ajax({
                type: 'post',
                url: `<?= base_url('bot/fetchBot')?>`,
                data: `bot_id=${id}`,
                success: function(result) {
                    result = JSON.parse(result);
                    $("[name=bot_id_rename]").val(result.bot_id)
                    $(".bot_photo_rename").attr('src', result.bot_photo)
                    $("[name=bot_name_rename]").val(result.bot_name)
                    $("[name=bot_desc_rename]").val(result.bot_desc)
                }       
            })
        })

        $("#deletebot").on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('id');
            $('.bot_delete').attr('href', `<?= base_url('bot/deleteBot/') ?>${id}`);
        })
    </script>
    <?php } elseif($this->uri->segment(2) == "bot") { ?>
    <script>
        $("#element-box").slimScroll({height:'calc(100vh - 110px)'});
        $(".element-edit").slimScroll({height:'calc(100vh)'});
        $(".element-item").click(function() {
            var element_id = $(this).attr('data-id');
            var bot_id = `<?= $bot_id ?>`;
            $.ajax({
                type: 'post',
                url: `<?= base_url('bot/fetchElement')?>`,
                data: `bot_id=${bot_id}&element_id=${element_id}`,
                success: function(result) {
                    $(".element-edit-row").html(result);
                    $(".button-element-delete").click(function() {
                        var button_id = $(this).attr('data-delete');
                        $(`#${button_id}`).remove();
                    })
                    $(".btn-add-button").click(function() {
                        var length = $('[name=button_capt\\[\\]]').length;
                        var lengths = length + 1;
                        $(".btn-area").append(`
                            <div class="form-group col-md-12 button-element" id="button-element-${lengths}">
                                <div class="d-flex" style="justify-content: space-between">
                                    <input type="hidden" name="button_id[]" value="none">
                                    <input class="form-control" value="" placeholder="Button Caption" name="button_capt[]" required> 
                                    <select class="form-control mx-1" name="button_goto[]">';
                                    <?php foreach ($element as $data) { ?>
                                        <option value="<?= $data->element_id ?>"><?= $data->element_desc ?></option>
                                    <?php } ?>
                                    <option value="end">end</option> 
                                    </select>
                                    <a href="javascript:void(0)" data-delete="button-element-${lengths}" class="btn btn-danger button-element-delete"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                        `);
                        $(".button-element-delete").click(function() {
                            var button_id = $(this).attr('data-delete');
                            $(`#${button_id}`).remove();
                        })
                    })
                    $("#delete-element").on('show.bs.modal', function(e) {
                        var id = $(e.relatedTarget).data('id');
                        id = encodeURIComponent(id);
                        $('.element_delete').attr('href', `<?= base_url('bot/deleteElement/'.$bot_id.'/') ?>${id}`);
                    })
                }       
            })
        })
    </script>
    <?php } ?>
</body>

</html>