<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Query extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('BotDB');
		$this->load->model('ElementDB');
	}

	public function getResponse() {
		$element_id = $_POST['element_id'];
		$bot_id = $_POST['bot_id'];
		if($element_id != "start") {
			$result = $this->ElementDB->queryElement($element_id, $bot_id);
		} else {
			$row = $this->BotDB->getData(["bot_id" => $bot_id])->row();
			$first_element = $row->bot_goto;
			$result = $this->ElementDB->queryElement($first_element, $bot_id);
		}
		header('Content-Type: application/json');
		return print_r(json_encode($result));
	}

	public function saveData() {
		$bot_id = $_POST['bot_id'];
		$data = $_POST['data'];
		$arr = json_decode($data, true);
		$val = array_values($arr);
		$txt = '';
		$i = 0;
		foreach($val as $value) {
			if($i == count($val)-1) {
				$txt .= $value."\n";
			} else {
				$txt .= $value.',';
			}
			$i++;
		}
		if(!file_exists('assets/data/'.$bot_id.'.csv')) {
			$vals = array_keys($arr);
			$key = '';
			$i = 0;
			foreach($vals as $values) {
				if($i == count($vals)-1) {
					$key .= $values."\n";
				} else {
					$key .= $values.',';
				}
				$i++;
			}
			$file = fopen('assets/data/'.$bot_id.'.csv', 'w');
			fwrite($file, $key.$txt);
			fclose($file);
		} else {
			$file = fopen('assets/data/'.$bot_id.'.csv', 'a');
			fwrite($file, $txt);
			fclose($file);
		}
	}
}