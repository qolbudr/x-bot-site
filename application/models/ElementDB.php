<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ElementDB extends CI_Model {
	public function getAllElement($bot_id) {
		$element = ["option", "question", "text"];
		$i = 0;
		$data = '';
		foreach ($element as $tipe) {
			$this->db->select($tipe.'_id as element_id, '.$tipe.'_desc as element_desc, '.$tipe.'_timestamp as element_timestamp');
			$this->db->where('bot_id', $bot_id);
			$this->db->from('tb_'.$tipe);
			$string = $this->db->get_compiled_select();	
			if($i == count($element)-1) {
				$data .= $string;
			} else {
				$data .= $string.' UNION ';
			}
			$i++;
		}

		$query = $this->db->query($data.' ORDER BY `element_timestamp` ASC');
		return $query;
	}

	public function deleteAllElement($bot_id) {
		$data = $this->getAllElement($bot_id)->result();
		foreach ($data as $element) {
			$idx = explode("#", $element->element_id);
			$tipe = $idx[0];
			if($idx[0] = 'option') {
				$query1 = $this->db->query("DELETE FROM `tb_button` WHERE `option_id` = '".$element->element_id."'");
			}
			$query2 = $this->db->query("DELETE FROM `tb_".$tipe."` WHERE `".$tipe."_id` = '".$element->element_id."'");
		}
	}

	public function fetchElement($bot_id, $element_id) {
		$idx = explode("#", $element_id);
		$tipe = $idx[0];
		$this->db->where([$tipe.'_id' => $element_id, 'bot_id' => $bot_id]);
		$data = $this->db->get('tb_'.$tipe)->row_array();

		if($tipe = "option") {
			$this->db->select('button_capt, button_goto, button_id');
			$this->db->where(['option_id' => $element_id]);
			$this->db->order_by('button_timestamp', 'DESC');
			$row = $this->db->get('tb_button')->result();
			$i = 0;
			foreach($row as $button) {
				$data['button'][$i]['button_id'] = $button->button_id;
				$data['button'][$i]['button_capt'] = $button->button_capt;
				$data['button'][$i]['button_goto'] = $button->button_goto;
				$i++;
			}
		}

		return $data;
	}

	public function deleteElement($element_id) {
		$idx = explode("#", $element_id);
		$tipe = $idx[0];
		if($idx[0] = 'option') {
			$query1 = $this->db->query("DELETE FROM `tb_button` WHERE `option_id` = '".$element_id."'");
		}
		$query2 = $this->db->query("DELETE FROM `tb_".$tipe."` WHERE `".$tipe."_id` = '".$element_id."'");
	}

	public function queryElement($element_id, $bot_id) {
		$idx = explode("#", $element_id);
		$tipe = $idx[0];
		$this->db->where([$tipe.'_id' => $element_id, 'bot_id' => $bot_id]);
		$data = $this->db->get('tb_'.$tipe)->row_array();
		$result = [
			"element_id" => $data[$tipe."_id"],
			"bot_id" => $bot_id,
			"style" => $tipe,
			"text" => $data[$tipe."_capt"],
			"desc" => $data[$tipe."_desc"],
		];

		if(isset($data[$tipe."_save"])) {
			$result["save"] = $data[$tipe."_save"];
		}

		if($tipe == "option") {
			$this->db->select('button_capt, button_goto, button_id');
			$this->db->where(['option_id' => $element_id]);
			$row = $this->db->get('tb_button')->result();
			$i = 0;
			foreach($row as $button) {
				$result['button'][$i]['button_id'] = $button->button_id;
				$result['button'][$i]['text'] = $button->button_capt;
				$result['button'][$i]['goto'] = $button->button_goto;
				$i++;
			}
		} else {
			$result["goto"] = $data[$tipe."_goto"];
		}

		return $result;
	}

	public function insertElement($element, $tipe) {
		return $this->db->insert("tb_".$tipe, $element);
	}

	public function editElement($tipe, $data) {
		$element_id = $data[$tipe.'_id'];
		$this->db->where([$tipe.'_id' => $element_id]);
		return $this->db->update('tb_'.$tipe, $data);
	}

	public function storeButton($element_id, $button) {
		$this->db->where(['option_id' => $element_id]);
		$this->db->delete('tb_button');
		foreach($button as $data) {
			$this->db->insert('tb_button', $data);
		}
	}

	public function insertOption($option, $button) {
		if($button != null) {
			$this->insertButton($button);
		}
		return $this->db->insert('tb_option', $option);
	}

	public function insertButton($button) {
		foreach($button as $data) {
			$this->db->insert('tb_button', $data);
		}
	}
}
