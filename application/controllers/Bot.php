<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bot extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('BotDB');
		$this->load->model('ElementDB');
		if($this->session->userdata('user_status') != 'SIGNED') {
			return redirect(base_url());
		}
	}

	public function preview($bot_id) {
		$row = $this->BotDB->getData(["bot_id" => $bot_id])->row();
		$data['row'] = $row;
		$this->load->view('preview', $data);
	}

	public function edit($bot_id) {
		$data['element'] = $this->ElementDB->getAllElement($bot_id)->result();
		$data['bot_id'] = $bot_id;
		$this->load->view('include/head');
		$this->load->view('include/topbar', $data);
		$this->load->view('edit_xbot', $data);
		$this->load->view('include/foot');
	}

	public function addBot() {
		$user_id = $this->session->userdata('user_id');
		$bot_id = $this->generateKey();
		$data = [
			"bot_id" => $bot_id,
			"user_id" => $user_id,
			"bot_name" => $_POST['bot_name'],
			"bot_desc" => $_POST['bot_desc'],
			"bot_timestamp" => time()
		];
		$filename = $_FILES["bot_photo"]["name"];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$file = $this->uploadPhoto('bot_photo', $bot_id, $ext);
		$data['bot_photo'] = $file['file_name'];
		$option_id = $this->addDefaultElement($bot_id);
		$data['bot_goto'] = $option_id;
		$this->BotDB->insertData($data);
		return redirect(base_url('app'));
	}

	public function fetchBot() {
		$bot_id = $_POST['bot_id'];
		$row = $this->BotDB->getData(['bot_id' => $bot_id])->row();
		$data = [
			"bot_id" => $row->bot_id,
			"bot_photo" => base_url('assets/images/bot_photo/'.$row->bot_id.'/'.$row->bot_photo),
			"bot_name" => $row->bot_name,
			"bot_desc" => $row->bot_desc
		];
		return print_r(json_encode($data));
	}

	public function renameBot() {
		$bot_id = $_POST['bot_id_rename'];
		$user_id = $this->session->userdata('user_id');
		$where = [ "bot_id" => $bot_id, "user_id" => $user_id ];
		$data = [ 
			"bot_name" => $_POST['bot_name_rename'],
			"bot_desc" => $_POST['bot_desc_rename']
		];

		if(!empty($_FILES['bot_photo_rename']["name"])) {
			$filename = $_FILES["bot_photo_rename"]["name"];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$file = $this->uploadPhoto('bot_photo_rename', $bot_id, $ext);
			$data['bot_photo'] = $file['file_name'];
		}

		$this->BotDB->updateData($where, $data);
		return redirect(base_url('app'));
	}

	public function deleteBot($bot_id) {
		$user_id = $this->session->userdata('user_id');
		$where = [ "bot_id" => $bot_id, "user_id" => $user_id ];
		$this->BotDB->deleteData($where);
		$this->ElementDB->deleteAllElement($bot_id);
		$this->deleteFolder('./assets/images/bot_photo/'.$bot_id.'/');
		return redirect(base_url('app'));
	}

	public function uploadPhoto($file, $name, $ext) {
		if(!is_dir('./assets/images/bot_photo/'.$name.'/')) {
			mkdir('./assets/images/bot_photo/'.$name.'/');
		}
		$config['upload_path'] = './assets/images/bot_photo/'.$name.'/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['file_name'] = $name.".".$ext;
		$this->load->library('upload', $config);
		$this->upload->do_upload($file);
		return $this->upload->data();
	}

	public function addDefaultElement($bot_id) {
		$option_id = $this->generateElementKey('option');
		$option = [
			"option_id" => $option_id,
			"bot_id" => $bot_id,
			"option_capt" => "Hello, welcome to X-Bot can i help you ?",
			"option_desc" => "First greeting to my visitor",
			"option_timestamp" => time()
		];

		$button = [
			[
				"button_id" => $this->generateElementKey('button'),
				"option_id" => $option_id,
				"button_capt" => "I want to know more about X-Bot",
				"button_goto" => "end",
				"button_timestamp" => time()
			],
			[
				"button_id" => $this->generateElementKey('button'),
				"option_id" => $option_id,
				"button_capt" => "Just browsing on your site",
				"button_goto" => "end",
				"button_timestamp" => time()
			],
		];

		$this->ElementDB->insertOption($option, $button);
		return $option_id;
	}

	public function addElement() {
		$bot_id = $_POST['bot_id'];
		$tipe = $_POST['element_tipe'];
		$capt = $_POST['element_capt'];
		$desc = $_POST['element_desc'];
		$element_id = $this->generateElementKey($tipe);
		if($tipe == 'option') {
			$option = [
				"option_id" => $element_id,
				"bot_id" => $bot_id,
				"option_capt" => $capt,
				"option_desc" => $desc,
				"option_timestamp" => time(),
			];

			$this->ElementDB->insertOption($option, null);
		} else {
			$element = [
				$tipe."_id" => $element_id,
				"bot_id" => $bot_id,
				$tipe."_capt" => $capt,
				$tipe."_desc" => $desc,
				$tipe."_timestamp" => time(),
			];

			$this->ElementDB->insertElement($element, $tipe);
		}

		return redirect(base_url('app/bot/'.$bot_id));
	}

	public function fetchElement() {
		$bot_id = $_POST['bot_id'];
		$element_id = $_POST['element_id'];
		$row = $this->ElementDB->fetchElement($bot_id, $element_id);
		$result = $this->setResult($bot_id, $element_id, $row);
		return print_r($result);
	}

	public function editElement() {
		$element_id = $_POST['element_id'];
		$bot_id = $_POST['bot_id'];
		$idx = explode("#", $element_id);
		$tipe = $idx[0];

		$val = [
			$tipe."_id" => $_POST['element_id'],
			$tipe."_capt" => $_POST[$tipe.'_capt'],
			$tipe."_desc" => $_POST[$tipe.'_desc']
		];

		if(isset($_POST[$tipe.'_save'])) {
			$val[$tipe."_save"] = $_POST[$tipe.'_save'];
		}

		if($tipe == "option") {
			$button = [];
			$button_count = $_POST['button_id'];
			$i = 0;
			foreach($button_count as $data) {
				$button[$i]['button_id'] = $this->generateKey('button');
				$button[$i]['option_id'] = $element_id;
				$button[$i]['button_capt'] = $_POST['button_capt'][$i];
				$button[$i]['button_goto'] = $_POST['button_goto'][$i];
				$button[$i]['button_timestamp'] = time();
				$i++;
			}
			$this->ElementDB->storeButton($element_id, $button);
		} else {
			$val[$tipe.'_goto'] = $_POST[$tipe.'_goto'];
		}

		$this->ElementDB->editElement($tipe, $val);
		return redirect(base_url('app/bot/'.$bot_id));
	}

	public function deleteElement($bot_id, $element_id) {
		$element_id = urldecode($element_id);
		$this->ElementDB->deleteElement($element_id);
		return redirect(base_url('app/bot/'.$bot_id));
	}

	public function random($length, $chars = '')
	{
		if (!$chars) {
			$chars = implode(range('a','f'));
			$chars .= implode(range('0','9'));
		}
		$shuffled = str_shuffle($chars);
		return substr($shuffled, 0, $length);
	}

	public function generateKey()
	{
		return $this->random(5).'-'.$this->random(3).'-'.$this->random(7).'-'.$this->random(4);
	}

	public function generateElementKey($element_type)
	{
		return $element_type."#".$this->random(5).'-'.$this->random(3).'-'.$this->random(7).'-'.$this->random(4);
	}

	public function deleteFolder($dir) {
	    $it = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
	    $it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
	    foreach($it as $file) {
	        if ($file->isDir()) rmdir($file->getPathname());
	        else unlink($file->getPathname());
	    }
	    rmdir($dir);
	}

	public function setResult($bot_id, $element_id, $row) {
		$bot = $this->BotDB->getData(["bot_id" => $bot_id])->row();
		$idx = explode("#", $element_id);
		$tipe = $idx[0];
		$element = $this->ElementDB->getAllElement($bot_id)->result();
		if($tipe == 'option') {
			$result = '<div class="form-group col-md-12">
		                    <label>Element ID</label>
		                    <input type="hidden" name="bot_id" value="'.$bot_id.'"> 
		                    <input type="hidden" name="element_id" value="'.$row['option_id'].'"> 
		                    <input type="text" value="'.$row['option_id'].'" name="option_id" class="form-control" disabled>
		                </div>
		                <div class="form-group col-md-6">
		                    <label>Type</label>
		                    <input type="text" value="'.ucwords($tipe).'" class="form-control" disabled>
		                </div>
		                <div class="form-group col-md-6">
		                    <label>Caption</label>
		                    <input type="text" placeholder="Hello, welcome to X-Bot can i help you ?" class="form-control" name="option_capt" value="'.$row['option_capt'].'" required>
		                </div>
		                <div class="form-group col-md-12">
		                    <label>Description</label>
		                    <textarea class="form-control" name="option_desc" placeholder="First greeting to my visitor" rows="5" required>'.$row['option_desc'].'</textarea>
		                </div>
		                <div class="form-group col-md-12">
		                    <label>Save answer as variable</label>
		                    <input type="text" class="form-control" name="option_save" value="'.$row['option_save'].'" placeholder="first_name">
		                </div><div class="btn-area">';
					    $i = 0;
					    if(isset($row['button'])) {
					    	foreach($row['button'] as $data) {
				            	$result .= '<div class="form-group col-md-12 button-element" id="button-element-'.$i.'">
					                <div class="d-flex" style="justify-content: space-between;">
					                	<input type="hidden" name="button_id[]" value="'.$data['button_id'].'">
					                    <input class="form-control" value="'.$data['button_capt'].'" placeholder="Button Caption" name="button_capt[]" required> 
					                    <select class="form-control mx-1" name="button_goto[]">';
					                    foreach ($element as $e) {
					                       	$result .= '<option value="'.$e->element_id.'" '.($e->element_id == $data['button_goto'] ? 'selected' : '').'>'.$e->element_desc.'</option>';
					                     }
					                    $result .= '<option value="end" '.($data['button_goto'] == 'end' ? 'selected' : '').'>end</option>';   
					                    $result .= '</select>';
					                    if($i > 0) {
					                    	$result .= '<a href="javascript:void(0)" data-delete="button-element-'.$i.'" class="btn btn-danger button-element-delete"><i class="fas fa-times"></i></a>';
					                    }
					                $result .= '</div></div>';
					            $i++;
				            }
					    }
		               
					    $result .= '</div><div class="form-group col-md-6">
					                    <a href="javascript:void(0)" class="btn btn-light btn-add-button">Add new button</a>
					                </div>';
					    $result .=  '<div class="col-md-12 text-right">';
								    if($element_id != $bot->bot_goto) {
								    	$result .= '<a href="javascript:void()" data-id="'.$element_id.'" class="btn btn-danger mr-2" data-toggle="modal" data-target="#delete-element">Delete</a>';
								    }
					    $result .= '<button type="submit" class="btn btn-primary">Save Changes</button>
					                </div>';
		} else {
			$result = '<div class="form-group col-md-12">
		                    <label>Element ID</label>
		                    <input type="hidden" name="bot_id" value="'.$bot_id.'">
		                    <input type="hidden" name="element_id" value="'.$row[$tipe.'_id'].'"> 
		                    <input type="text" value="'.$row[$tipe.'_id'].'" name="'.$tipe.'_id" class="form-control" disabled>
		                </div>
		                <div class="form-group col-md-6">
		                    <label>Type</label>
		                    <input type="text" value="'.ucwords($tipe).'" class="form-control" disabled>
		                </div>
		                <div class="form-group col-md-6">
		                    <label>Caption</label>
		                    <input type="text" placeholder="Hello, welcome to X-Bot can i help you ?" class="form-control" name="'.$tipe.'_capt" value="'.$row[$tipe.'_capt'].'" required>
		                </div>
		                <div class="form-group col-md-12">
		                    <label>Description</label>
		                    <textarea class="form-control" name="'.$tipe.'_desc" placeholder="First greeting to my visitor" rows="5" required>'.$row[$tipe.'_desc'].'</textarea>
		                </div>';
		                if($tipe !== 'text') {
		                	$result .= '<div class="form-group col-md-12">
					                    <label>Save answer as variable</label>
					                    <input type="text" class="form-control" name="'.$tipe.'_save" value="'.$row[$tipe.'_save'].'" placeholder="first_name">
					                </div>';
		                }
		                $result .= '<div class="form-group col-md-12">
		                				<label>Next Element</label>
		                				<select class="form-control" name="'.$tipe.'_goto">';
	                    foreach ($element as $e) {
	                       	$result .= '<option value="'.$e->element_id.'" '.($e->element_id == $row[$tipe.'_goto'] ? 'selected' : '').'>'.$e->element_desc.'</option>';
	                     }
	                    $result .= '<option value="end" '.($row[$tipe.'_goto'] == 'end' ? 'selected' : '').'>end</option>';   
	                    $result .= '</select></div>';
		                $result .=  '<div class="col-md-12 text-right">';
								    if($element_id != $bot->bot_goto) {
								    	$result .= '<a href="javascript:void()" data-id="'.$element_id.'" class="btn btn-danger mr-2" data-toggle="modal" data-target="#delete-element">Delete</a>';
								    }
					    $result .= '<button type="submit" class="btn btn-primary">Save Changes</button>
					                </div>';
		}

		return $result;
	}

}

?>