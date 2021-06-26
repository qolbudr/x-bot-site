<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="<?= base_url('assets/preview/assets/css') ?>/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css" integrity="sha256-8g4waLJVanZaKB04tvyhKu2CZges6pA5SUelZAux/1U=" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets') ?>/images/img5.png">
	<link rel="stylesheet" href="<?= base_url('assets/preview/assets/css') ?>/jquery.custom-scrollbar.css">
	<link rel="stylesheet" href="<?= base_url('assets/preview/assets/css') ?>/main.css">
	<title>X-Bot Bot Preview</title>
</head>
<body bot_id="<?= $row->bot_id ?>" domain="<?= base_url() ?>">
	<div class="chat-box">
		<div class="chat-header">
			<div class="chat-title">
				<?= $row->bot_name ?>
			</div>
			<div class="chat-control">
				<i class="ti ti-reload mr-4 reload-btn"></i>
				<i class="ti ti-close close-btn"></i>
			</div>
		</div>
		<div class="chat-body">
			<div class="wrapper">
				<div class="chat-button">
				</div>
				<div class="chat-text-answer">
				</div>
			</div>
		</div>
	</div>
	<div class="chat-bubble">
		<img style="border-radius: 50px" src="<?= base_url('assets/images/bot_photo/'.$row->bot_id.'/'.$row->bot_photo) ?>" width="63">
	</div>
	<div class="chat-bubble-close">
		<i class="ti ti-close"></i>
	</div>
	<script src="<?= base_url('assets/preview/assets/js') ?>/jquery-3.2.1.slim.min.js"></script>
	<script src="<?= base_url('assets/preview/assets/js') ?>/popper.min.js"></script>
	<script src="<?= base_url('assets/preview/assets/js') ?>/bootstrap.min.js"></script>
	<script src="<?= base_url('assets/preview/assets/js') ?>/typed.js"></script>
	<script src="<?= base_url('assets/preview/assets/js') ?>/slimscroll.js"></script>
	<script src="<?= base_url('assets/preview/assets/js') ?>/index.js" type="module"></script>
</body>
</html>