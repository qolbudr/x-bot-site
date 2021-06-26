<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BotDB extends CI_Model {
	private $table = 'tb_bot';

	public function getData($where) {
		$this->db->where($where);
		$this->db->order_by('bot_timestamp', 'asc');
		return $this->db->get($this->table);
	}

	public function insertData($data) {
		return $this->db->insert($this->table, $data);
	}

	public function updateData($where, $data) {
		$this->db->where($where);
		return $this->db->update($this->table, $data);
	}

	public function deleteData($where) {
		$this->db->where($where);
		return $this->db->delete($this->table);
	}
}
