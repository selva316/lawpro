<?php 
class Notationmodel extends CI_Model {

	public function fetchCourtType()
	{
		$str = "select * from law_courttype";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function fetchTypeOfCitation()
	{
		$str = "select * from law_type_of_citation where disable='N'";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	public function fetchStatus()
	{
		$str = "select * from law_status";
		$query = $this->db->query($str);
		return $query->result_array();
	}

	function createNotation($data)
	{
		$this->db->insert('law_notation', $data); 
		$autoid = $this->db->insert_id();
		
		$this->db->where('id', $autoid);
		$nid = 'NT'.$autoid;
		$hashnid = md5($nid.time());
		$this->db->set('NOTATIONID', $nid);
		$this->db->set('HASHNOTATIONID', $hashnid);
		
		$this->db->set('CREATED_BY', $this->session->userdata('userid'));
		$this->db->set('CREATED_ON', time());

		$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
		$this->db->set('UPDATED_ON', time());

		$this->db->update('law_notation');

		/* Statuate , Sub Section and Concept */
		$number_of_entries = count($this->input->post('statuate'));
		$statuate = $this->input->post('statuate');
		$subsection = $this->input->post('subsection');
		$concept = $this->input->post('concept');

		if($number_of_entries >= 0)
		{
			for ($i=0; $i <$number_of_entries ; $i++) { 
				
				$itemlist = array();

				if(($statuate[$i] == "") && ($concept[$i] == "") && ($nid == ""))
					continue;

				$itemlist['STATUATE'] = $statuate[$i];
				$itemlist['SUB_SECTION'] = $subsection[$i];
				$itemlist['CONCEPT'] = $concept[$i];
				$itemlist['NOTATIONID'] = $nid;

				$this->db->insert('law_notation_statuate', $itemlist); 
			}
		}

		/* Statuate , Sub Section and Concept */

		$number_of_citation = count($this->input->post('citationNumber'));
		$citationNumber = $this->input->post('citationNumber');
		$typeCitation = $this->input->post('typeCitation');

		if($number_of_citation >= 0)
		{
			for ($i=0; $i <$number_of_citation ; $i++) { 
				
				$itemlist = array();

				if(($typeCitation[$i] == "")  && ($nid == ""))
					continue;

				$itemlist['CITATION'] = $citationNumber[$i];
				$itemlist['ACTUAL_CITATION'] = $citationNumber[$i];
				$itemlist['TYPE_OF_CITATION'] = $typeCitation[$i];
				$itemlist['NOTATIONID'] = $nid;

				$this->db->insert('law_citation_notation_link', $itemlist); 
			}
		}
		return true;
	}

	function updateNotation($data)
	{
		$nid = $this->input->post('ntype');
		$this->auditNotationStatuate($nid);
		$this->auditNotationCitation($nid);
		$this->auditNotation($nid);

		$this->db->where('NOTATIONID', $this->input->post('ntype'));
		
		$this->db->set('CASENAME', $this->input->post('casename'));
		$this->db->set('CITATION', $this->input->post('citation'));
		$this->db->set('COURT_TYPE', $this->input->post('court_type'));
		$this->db->set('COURT_NAME', $this->input->post('court_name'));
		$this->db->set('YEAR', $this->input->post('year'));
		$this->db->set('BENCH', $this->input->post('bench'));
		$this->db->set('FACTS_OF_CASE', $this->input->post('facts_of_case'));
		$this->db->set('TYPE', $this->input->post('status'));

		$this->db->set('UPDATED_BY', $this->session->userdata('userid'));
		$this->db->set('UPDATED_ON', time());

		$this->db->update('law_notation');

		/* Statuate , Sub Section and Concept */
		$number_of_entries = count($this->input->post('statuate'));
		$statuate = $this->input->post('statuate');
		$subsection = $this->input->post('subsection');
		$concept = $this->input->post('concept');

		if($number_of_entries >= 0)
		{
			for ($i=0; $i <$number_of_entries ; $i++) { 
				
				$itemlist = array();

				if(($statuate[$i] == "") && ($concept[$i] == "") && ($nid == ""))
					continue;

				$itemlist['STATUATE'] = $statuate[$i];
				$itemlist['SUB_SECTION'] = $subsection[$i];
				$itemlist['CONCEPT'] = $concept[$i];
				$itemlist['NOTATIONID'] = $nid;

				$this->db->insert('law_notation_statuate', $itemlist); 
			}
		}

		/* Statuate , Sub Section and Concept */

		$number_of_citation = count($this->input->post('citationNumber'));
		$citationNumber = $this->input->post('citationNumber');
		$typeCitation = $this->input->post('typeCitation');

		if($number_of_citation >= 0)
		{
			for ($i=0; $i <$number_of_citation ; $i++) { 
				
				$itemlist = array();

				if(($typeCitation[$i] == "")  && ($nid == ""))
					continue;

				$itemlist['CITATION'] = $typeCitation[$i];
				$itemlist['ACTUAL_CITATION'] = $citationNumber[$i];
				$itemlist['TYPE_OF_CITATION'] = $citationNumber[$i];
				$itemlist['NOTATIONID'] = $nid;

				$this->db->insert('law_citation_notation_link', $itemlist); 
			}
		}
		return true;
	}

	function auditNotation($notationid)
	{
		$this->db->select('*');
		$this->db->from('law_notation');
		$this->db->where('NOTATIONID', $notationid);
		$itemdata = array();
		$itemquery = $this->db->get();
		$productdata = array();
		if($itemquery->num_rows() > 0)
		{
			$itemresult = $itemquery->result_array();
			$i = 0;
			foreach($itemresult as $itemrow)
			{
				$itemdata['NOTATIONID'] = $notationid;
				$itemdata['HASHNOTATIONID'] = $itemrow['HASHNOTATIONID'];
				$itemdata['CASENAME'] = $itemrow['CASENAME'];
				$itemdata['CITATION'] = $itemrow['CITATION'];

				$itemdata['COURT_TYPE'] = $itemrow['COURT_TYPE'];
				$itemdata['COURT_NAME'] = $itemrow['COURT_NAME'];
				$itemdata['YEAR'] = $itemrow['YEAR'];
				$itemdata['BENCH'] = $itemrow['BENCH'];
				$itemdata['FACTS_OF_CASE'] = $itemrow['FACTS_OF_CASE'];
				$itemdata['TYPE'] = $itemrow['TYPE'];

				$itemdata['CREATED_BY'] = $itemrow['CREATED_BY'];
				$itemdata['CREATED_ON'] = $itemrow['CREATED_ON'];
				$itemdata['UPDATED_BY'] = $itemrow['UPDATED_BY'];
				$itemdata['UPDATED_ON'] = $itemrow['UPDATED_ON'];

				$itemdata['MODIFIED_ON'] = time();
				$itemdata['MODIFIED_BY'] = $this->session->userdata('userid');
				
				$this->db->insert('audit_law_notation', $itemdata); 
				
			}
			
		}
	}

	function auditNotationStatuate($notationid)
	{
		$this->db->select('*');
		$this->db->from('law_notation_statuate');
		$this->db->where('NOTATIONID', $notationid);
		$itemdata = array();
		$itemquery = $this->db->get();
		$productdata = array();
		if($itemquery->num_rows() > 0)
		{
			$itemresult = $itemquery->result_array();
			$i = 0;
			foreach($itemresult as $itemrow)
			{
				$itemdata['NOTATIONID'] = $notationid;
				$itemdata['STATUATE'] = $itemrow['STATUATE'];
				$itemdata['SUB_SECTION'] = $itemrow['SUB_SECTION'];
				$itemdata['CONCEPT'] = $itemrow['CONCEPT'];
				$itemdata['MODIFIED_ON'] = time();
				$itemdata['MODIFIED_BY'] = $this->session->userdata('userid');
				
				$this->db->insert('audit_law_notation_statuate', $itemdata); 
				
			}
			$this->db->where('NOTATIONID', $notationid);
			$this->db->delete('law_notation_statuate'); 
		}
	}

	function auditNotationCitation($notationid)
	{
		$this->db->select('*');
		$this->db->from('law_citation_notation_link');
		$this->db->where('NOTATIONID', $notationid);
		$itemdata = array();
		$itemquery = $this->db->get();
		$productdata = array();
		if($itemquery->num_rows() > 0)
		{
			$itemresult = $itemquery->result_array();
			$i = 0;
			foreach($itemresult as $itemrow)
			{
				$itemdata['NOTATIONID'] = $notationid;
				$itemdata['CITATION'] = $itemrow['CITATION'];
				$itemdata['ACTUAL_CITATION'] = $itemrow['ACTUAL_CITATION'];
				$itemdata['TYPE_OF_CITATION'] = $itemrow['TYPE_OF_CITATION'];
				$itemdata['DESCRPITION'] = $itemrow['DESCRPITION'];
				$itemdata['MODIFIED_ON'] = time();
				$itemdata['MODIFIED_BY'] = $this->session->userdata('userid');
				
				$this->db->insert('audit_law_citation_notation_link', $itemdata); 
				
			}
			$this->db->where('NOTATIONID', $notationid);
			$this->db->delete('law_citation_notation_link'); 
		}
	}

	function fetchStatusNotation($status)
	{
		$this->db->select('*');
		$this->db->from('law_notation');
		$this->db->where('type', $status);

		$itemdata = array();
		$itemquery = $this->db->get();
		if($itemquery->num_rows() > 0)
		{
			return $itemquery->result_array();
		}
	}

	function fetchAllNotation()
	{

		$this->db->select('*');
		$this->db->from('law_notation');
		$this->db->where('type !=', 'draft');
		
		$itemdata = array();
		$itemquery = $this->db->get();
		if($itemquery->num_rows() > 0)
		{
			return $itemquery->result_array();
		}
	}

	public function fetchHashNotation()
	{
		$nid = $this->input->get('nid');
		//echo "Notation Id: ".$nid;
		$this->db->select('*');
		$this->db->from('law_notation');
		$this->db->where('HASHNOTATIONID', $nid);		

		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			$result = $query->result_array();
			//print_r($result);
			$data = array();
			foreach($result as $row)
			{
				$notationid = $row['NOTATIONID'];
				$data['notationid'] = $row['NOTATIONID'];
				$data['hashnotationid'] = $row['HASHNOTATIONID'];
				$data['casename'] = $row['CASENAME'];
				$data['citation'] = $row['CITATION'];
				$data['court_type'] = $row['COURT_TYPE'];
				$data['court_name'] = $row['COURT_NAME'];
				$data['year'] = $row['YEAR'];
				$data['bench'] = $row['BENCH'];
				$data['facts_of_case'] = $row['FACTS_OF_CASE'];
				
				$data['created_by'] = $row['CREATED_BY'];
				$data['created_on'] = $row['CREATED_ON'];
				$data['type'] = $row['TYPE'];
				
				$this->db->select('*');
				$this->db->from('law_notation_statuate');
				$this->db->where('notationid', $notationid);
				$statuateData = array();
				$statuatequery = $this->db->get();
				
				/*
				$casedata = array();
				print "select * from ips_case where ordertrackingid='".$row['ordertrackingid']."'";
				$casequery = $this->db->query("select * from ips_case where ordertrackingid='".$row['ordertrackingid']."'");
				*/
				if($statuatequery->num_rows() > 0)
				{
					$statuateresult = $statuatequery->result_array();
					$i = 0;
					foreach($statuateresult as $statuaterow)
					{
						$statuateData[$i]['statuate'] = $statuaterow['STATUATE'];
						$statuateData[$i]['sub_section'] = $statuaterow['SUB_SECTION'];
						$statuateData[$i]['concept'] = $statuaterow['CONCEPT'];
						$i++;
					}
				}
				$data['statuatedetails'] = $statuateData;
							
				
				$this->db->select('*');
				$this->db->from('law_citation_notation_link');
				$this->db->where('notationid', $notationid);
				$notationdata = array();
				$notationquery = $this->db->get();
				
				if($notationquery->num_rows() > 0)
				{
					$notationresult = $notationquery->result_array();
					$i = 0;
					foreach($notationresult as $notationrow)
					{
						$notationdata[$i]['citation'] = $notationrow['CITATION'];
						$notationdata[$i]['actual_citation'] = $notationrow['ACTUAL_CITATION'];
						$notationdata[$i]['type_of_citation'] = $notationrow['TYPE_OF_CITATION'];
						$notationdata[$i]['description'] = $notationrow['DESCRPITION'];
						$i++;
					}
				}
				$data['citationdetails'] = $notationdata;
				return $data;
			}
			
		}
	}
}
/* End of file Logindetailsmodel.php */
/* Location: ./application/models/Logindetailsmodel.php */