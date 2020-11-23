<?php
class Api_model extends CI_Model
{
	function FetchAllApiM(){
		$this->db->order_by('id', 'DESC');
		return $this->db->get('tbl_sample');
	}

	function InsertApiM($arg_data){
		$this->db->insert('tbl_sample', $arg_data);
		if($this->db->affected_rows() > 0){
			return true;
		} else {
			return false;
		}
	}

	function FetchSingleApiM($arg_user_id)
	{
		$this->db->where("id", $arg_user_id);
		$query = $this->db->get('tbl_sample');
		return $query->result_array();
	}

	function UpdateApiM($arg_user_id, $arg_data)
	{
		$this->db->where("id", $arg_user_id);
		$this->db->update("tbl_sample", $arg_data);
	}
	
	function DeleteApiM($arg_user_id)
	{
		$this->db->where("id", $arg_user_id);
		$this->db->delete("tbl_sample");
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

?>