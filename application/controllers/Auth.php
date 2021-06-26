<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('google');
		$this->load->model('UserDB');
	}

	public function checkLogin() {
		if($this->session->userdata('user_status') == 'SIGNED') {
			return redirect(base_url('app'));
		}
	}

	public function login() {
		$this->checkLogin();
		$data['loginURL'] = $this->google->createAuthUrl();
		$this->load->view('auth/head');
		$this->load->view('auth/login', $data);
		$this->load->view('auth/foot');
	}

	public function register() {
		$this->checkLogin();
		$this->load->view('auth/head');
		$this->load->view('auth/register');
		$this->load->view('auth/foot');
	}

	public function google()
	{
		if(isset($_GET['code'])){
			// Otentikasi pengguna dengan google
			$client = $this->google;
			$client->authenticate($_GET['code']);
			$optParams = [ 'personFields' => 'names,emailAddresses,addresses,phoneNumbers,photos' ];
			// ambil profilenya
			$people = new Google_Service_PeopleService( $client );
			$profile = $people->people->get(
			  'people/me', $optParams
			);

			$name = $profile->getNames()[0]->getDisplayName();
			$email = $profile->getEmailAddresses()[0]->getValue();
			$photo = $profile->getPhotos()[0]->getUrl();
			$data = [
				"user_name" => $name,
				"user_email" => $email,
				"user_photo" => $photo,
				"user_login" => "google"
			];

			if($this->UserDB->countGoogle($email) == 0) {
				$id = $this->UserDB->insert($data);
				$data["user_id"] = $id;
			} else {
				$row = $this->UserDB->getData($email);
				$data["user_id"] = $row->user_id;
			}
			$data["user_status"] = "SIGNED";
			print_r($data);
			$this->session->set_userdata($data);
			redirect(base_url('app'));
		}
	}

	public function authLogin() {
		$email = $_POST['user_email'];
		$pass = $_POST['user_pass'];
		$where = array(
			"user_email" => $email,
			"user_pass" => $pass,
			"user_login" => "email"
		);
		$count = $this->UserDB->getUser($where)->num_rows();
		$row = $this->UserDB->getUser($where)->row();

		if($count > 0) {
			$this->setSession($row);
		} else {
			$this->session->set_flashdata('login_status', 'failed');
			redirect(base_url('login'));
		}
	}

	public function userRegister() {
		$user_name = $_POST['user_name'];
		$user_pass = $_POST['user_pass'];
		$user_email = $_POST['user_email'];
		$data = [
			"user_name" => $user_name,
			"user_email" => $user_email,
			"user_pass" => $user_pass,
			"user_login" => "email"
		];

		$user_id = $this->UserDB->insertData($data);
		$row = $this->UserDB->getUser($data)->row();
		return $this->setSession($row);
	}

	public function setSession($row) {
		$session = array(
			"user_id" => $row->user_id,
			"user_name" => $row->user_name,
			"user_email" => $row->user_email,
			"user_photo" => $row->user_photo,
			"user_login" => $row->user_login,
			"user_status" => "SIGNED"
		);
		$this->session->set_userdata($session);
		redirect(base_url('app'));
	}

	public function checkEmail() {
		$where = ['user_email' => $_POST['user_email']];
		$row = $this->UserDB->getUser($where)->num_rows();
		if($row > 0) {
			$data = [
				"status" => "error",
				"message" => "Email already registered"
			];
		} else {
			$data = [ "status" => "OK" ];
		}

		return print_r(json_encode($data));
	}

	public function userLogout() {
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
