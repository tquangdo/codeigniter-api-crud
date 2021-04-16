<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('api_model');
		$this->load->library('form_validation');
	}

	function index()
	{
        $this->load->view('api_view'); // KO có dòng này thì link access on browser phải là "http://localhost:8000/index.php/test_api"
	}
	
	function onUploadFile()
	{
		// BASEPATH: ~~~~~~~~~~~/var/www/html/system/
		// APPPATH: ~~~~~~~~~~~/var/www/html/application/
		// __DIR__: ~~~~~~~~~~~/var/www/html/application/controllers
		// echo base_url(); // http://example.com/website
		// echo site_url(); // http://example.com/website/index.php
		$image = '';
		if(isset($_FILES['file']['name']))
		{
			$image_name = $_FILES['file']['name'];
			$valid_extensions = array("jpg","jpeg","png");
			$extension = pathinfo($image_name, PATHINFO_EXTENSION);
			if(in_array($extension, $valid_extensions))
			{
				$upload_relative_path = 'upload/' . time() . '.' . $extension;
				$upload_path = APPPATH. '../' . $upload_relative_path;
				// echo "~~~~~~~~~~~filename: ~~~~~~~~~~~" . json_encode($_FILES['file']['tmp_name']) . "\xA"; ---> "\/tmp\/phpzkelkt"
				if(move_uploaded_file($_FILES['file']['tmp_name'], $upload_path))
				{
					$message = 'Image Uploaded';
					$image = $upload_relative_path;
				}
				else
				{
					$message = 'There is an error while uploading image';
				}
			}
			else
			{
				$message = 'Only .jpg, .jpeg and .png Image allowed to upload';
			}
		}
		else
		{
			$message = 'Please select 1 image';
		}
		$output = array(
			'message'  => $message,
			'image'   => $image
		);
		echo json_encode($output);
	}
	
	function onDynamicSelBox()
	{
		$received_data = json_decode(file_get_contents("php://input"));
		if ($received_data->request_for == 'country') {
			$data = $this->api_model->OnSelAllCountry();
		} else {
			if ($received_data->request_for == 'state') {
				$data = $this->api_model->OnSelState($received_data->country_id);
			} else {
				$data = $this->api_model->OnSelCity($received_data->state_id);
			}
		}
		echo json_encode($data->result_array()); // PHP array -> JSON string
	}
	
	function onSelectAll()
	{
		$data = $this->api_model->FetchAllApiM();
		echo json_encode($data->result_array()); // PHP array -> JSON string
	}
	
	function onInsert()
	{
		$this->form_validation->set_rules("first_name_from_test", "First Name", "required");
		$this->form_validation->set_rules("last_name_from_test", "Last Name", "required");
		$array = array();
		if($this->form_validation->run())
		{
			$data = array(
				'first_name' => trim($this->input->post('first_name_from_test')),
				'last_name'  => trim($this->input->post('last_name_from_test'))
			);
			$this->api_model->InsertApiM($data);
			$array = array(
				'success'  => true
			);
		}
		else
		{
			$array = array(
				'error'    => true,
				'first_name_error' => form_error('first_name_from_test'),
				'last_name_error' => form_error('last_name_from_test')
			);
		}
		echo json_encode($array, true);
	}

	function onFetchSingle()
	{
		if($this->input->post('id_from_test'))
		{
			$data = $this->api_model->FetchSingleApiM($this->input->post('id_from_test'));
			foreach($data as $item_row)
			{
				$output['first_name'] = $item_row["first_name"];
				$output['last_name'] = $item_row["last_name"];
			}
			echo json_encode($output);
		}
	}

	function onUpdate()
	{
		$this->form_validation->set_rules("first_name_from_test", "First Name", "required");
		$this->form_validation->set_rules("last_name_from_test", "Last Name", "required");
		$array = array();
		if($this->form_validation->run())
		{
			$data = array(
				'first_name' => trim($this->input->post('first_name_from_test')),
				'last_name'  => trim($this->input->post('last_name_from_test'))
			);
			$this->api_model->UpdateApiM($this->input->post('id_from_test'), $data);
			$array = array(
				'success'  => true
			);
		}
		else
		{
			$array = array(
				'error'    => true,
				'first_name_error' => form_error('first_name_from_test'),
				'last_name_error' => form_error('last_name_from_test')
			);
		}
		echo json_encode($array, true);
	}

	function onDelete()
	{
		if($this->input->post('id_from_test'))
		{
			if($this->api_model->DeleteApiM($this->input->post('id_from_test')))
			{
				$array = array(
					'success' => true
				);
			}
			else
			{
				$array = array(
					'error' => true
				);
			}
			echo json_encode($array);
		}
	}
}

?>