
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="<?= base_url('assets') ?>/libs/jquery/dist/jquery.min.js "></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url('assets') ?>/libs/popper.js/dist/umd/popper.min.js "></script>
    <script src="<?= base_url('assets') ?>/libs/bootstrap/dist/js/bootstrap.min.js "></script>
    <script src="<?= base_url('assets') ?>/libs/sweetalert.min.js"></script>
    <script src="<?= base_url('assets') ?>/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
        $(".preloader ").fadeOut();
        $("#email_register").blur(function() {
            var value = $(this).val();
            $.ajax({
                type: 'post',
                url: `<?= base_url('auth/checkEmail') ?>`,
                data: `user_email=${value}`,
                success: function(result) {
                    var data = JSON.parse(result);
                    if(data.status == 'error') {
                        $('.email-alert').text(data.message);
                        $('.email-alert').css('visibility', 'visible');
                        $('.btn-register').prop('disabled', true);
                    } else {
                        $('.email-alert').text('');
                        $('.email-alert').css('visibility', 'hidden');
                        $('.btn-register').prop('disabled', false);
                    }
                }       
            })
        })

        $("#pass_register").blur(function() {
            var conf = $(this).val();
            var pass = $('#input-pass').val()
            if(conf == pass) {
                $('.pass-alert').text('');
                $('.pass-alert').css('visibility', 'hidden');
                $('.btn-register').prop('disabled', false);
            } else {
                $('.pass-alert').text('Password confirmation mismatch');
                $('.pass-alert').css('visibility', 'visible');
                $('.btn-register').prop('disabled', true);
            }
        })
    </script>
</body>

</html>