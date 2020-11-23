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