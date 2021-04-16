<?php
class Api_model extends CI_Model
{
	function OnSelAllCountry(){
		$this->db->order_by('country_name', 'ASC');
		return $this->db->get('country');
	}

	function OnSelState($arg_country_id){
		$this->db->where("country_id", $arg_country_id);
		$this->db->order_by('state_name', 'ASC');
		return $this->db->get('state');
	}

	function OnSelCity($arg_state_id){
		$this->db->where("state_id", $arg_state_id);
		$this->db->order_by('city_name', 'ASC');
		return $this->db->get('city');
	}

	function FetchAllApiM($arg_query = ''){
		if ($arg_query != '') {
			$where = '(first_name like "%' . $arg_query . '%" OR last_name like "%' . $arg_query . '%")';
       		$this->db->where($where);
		}
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