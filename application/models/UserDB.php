<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserDB extends CI_Model {
	private $table = 'tb_user';

	public function insertData($data) {
		$this->db->insert($this->table, $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function countGoogle($email) {
		$this->db->where('user_email', $email);
		return $this->db->get($this->table)->num_rows();
	}

	public function getData($email) {
		$this->db->where('user_email', $email);
		return $this->db->get($this->table)->row();
	}

	public function getUser($where) {
		$this->db->where($where);
		return $this->db->get($this->table);
	}
}
