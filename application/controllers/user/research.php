<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Research extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
		
		$this->load->database();
		$this->load->helper('url');
		
		ob_start();
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0', FALSE);
		header('Pragma: no-cache');
		ob_clean();
		//$this->output->nocache();
	}
	
	public function index()
	{
		$this->load->model('researchmodel');
		$data = array();
		
		$data['researchTopic'] = $this->researchmodel->fetchResearchTopic();
		
		$this->load->view('user/research',$data);
	}
	
	public function fetchResearchTopic()
	{
		$this->load->model('researchmodel');
		$result = $this->researchmodel->fetchResearchTopic();
		
		if($result)
		{
			$detailsList = array();
			foreach($result as $r)
			{	
				if($r['DISABLE'] == 'N')
				$statusStr = '<button type="button" class="btn btn-small btn-success editCourtType" value="'.$r['RID'].'"  >Edit</button>'.'<button type="button" style="margin-left:25px;" class="btn btn-small btn-danger disableCourtType" value="'.$r['RID'].'" >Disable</button>';
			else
				$statusStr = '<button type="button" class="btn btn-small btn-success editCourtType" value="'.$r['RID'].'"  >Edit</button>'.'<button type="button" style="margin-left:25px;" class="btn btn-small btn-warning disableCourtType" value="'.$r['RID'].'" >Enable</button>';

				$details = array(
					'rid'=>$r['RID'],
					'topic'=>$r['TOPIC'],
					'belongs_to'=>$r['BELONGS_TO'],
					'timestamp' => date("d-m-Y", $r['TIMESTAMP']),
					'assign' => $r['ASSIGN_TO'],
					'action' => $statusStr
				);
				
				array_push($detailsList, $details);
			}
			
			$collectionDetails= array('data'=>$detailsList);

			echo json_encode($collectionDetails);
	
		}
		else
		{
			$detailsList = array();
			$collectionDetails= array('data'=>$detailsList);
			echo json_encode($collectionDetails);		
		}

	}

	public function checkTopicAvailable()
	{
		$this->load->model('researchmodel');
		$data =  $this->researchmodel->checkTopicAvailable($this->input->post('topicname'));
		echo json_encode($data);
	}

	public function fetchUsers()
	{
		$this->load->model('researchmodel');
		$result =  $this->researchmodel->fetchUsers();
		//echo json_encode($data);
		$detailsList = array();	
		foreach($result as $r)
		{
			$details = array(
					'userid'=>$r['USERID'],
					'firstname'=>$r['FIRSTNAME'],
					'lastname'=>$r['LASTNAME']
				);
			array_push($detailsList, $details);
		}

		$collectionDetails= array('data'=>$detailsList);

		echo json_encode($detailsList);
	}

	public function insertReseaarchTopic()
	{
		$topicname = $this->input->post('topicname');
		$assignTo = $this->input->post('assignTo');
		$data = array();

		$data['TOPIC'] = $topicname;
		$data['BELONGS_TO'] = $this->session->userdata('userid');
		$data['TIMESTAMP'] = time();
		$data['ASSIGN_TO'] = $assignTo;

		$this->load->model('researchmodel');
		$result =  $this->researchmodel->createResearchGroup($data);
			
		//echo json_encode();
	}
}

/* End of file homepage.php */
/* Location: ./application/controllers/admin/homepage.php */