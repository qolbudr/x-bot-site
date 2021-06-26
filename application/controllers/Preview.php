<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Preview extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('BotDB');
		$this->load->model('ElementDB');
	}

	public function preview($bot_id) {
		$row = $this->BotDB->getData(["bot_id" => $bot_id])->row();
		$data['row'] = $row;
		$this->load->view('preview', $data);
	}
}

?>