<?php 
class Researchmodel extends CI_Model {

	public function fetchResearchTopic()
	{
		$str = "select * from law_research_group";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function checkTopicAvailable($topic){
				
		$query = $this->db->query("select count(topic) as cntname from law_research_group  where (UPPER(TOPIC) = '".strtoupper($topic)."')");
		
		$data = array();
		
		$count = 0;
		$result = $query->result_array();
		foreach($result as $row)
		{
			$count = $row['cntname'];//i am not want item code i,eeeeeeeeeeee
		}

		if ($count == 0)
		{
			array_push($data, true);
		}
		else{
			array_push($data, false);
		}
		
		return $data;
	}

	public function fetchUsers(){
		$str = "select * from law_login where role='2'";
		$query = $this->db->query($str);
		return $query->result_array();	
	}

	function createResearchGroup($data)
	{
		$this->db->insert('law_research_group', $data); 
		$autoid = $this->db->insert_id();
		
		$this->db->where('id', $autoid);
		$rid = 'RID'.$autoid;

		$this->db->set('RID', $rid);
		$this->db->update('law_research_group');
	}
}
/* End of file Logindetailsmodel.php */
/* Location: ./application/models/Logindetailsmodel.php */