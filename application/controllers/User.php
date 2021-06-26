<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('UserDB');
		$this->load->model('BotDB');
	}

	public function index() {
		$this->load->view('xbot_home');
	}

	public function bitbot() {
		if($this->session->userdata('user_status') != 'SIGNED') {
			return redirect(base_url());
		}
		$user_id = $this->session->userdata("user_id");
		$where = [ "user_id" => $user_id ];
		$bot_count = $this->BotDB->getData($where)->num_rows();
		$bot_data = $this->BotDB->getData($where)->result();
		$data = [ "bot_count" => $bot_count, "bot_data" => $bot_data ];
		$this->load->view('include/head');
		$this->load->view('include/topbar');
		$this->load->view('xbot', $data);
		$this->load->view('include/foot');
	}
}