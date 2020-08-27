<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ChatController extends CI_Controller {
  public function __construct($value=''){
    parent::__construct();
    $this->load->model('ChatModel');
    if(!isset($_SESSION['loggedin'])){
      redirect(base_url('login'));
    }
  }


	public function chat(){
    $row = $this->ChatModel->getUsers($_SESSION['username']);
    $id = $this->ChatModel->getUserId($_SESSION['username']);
    // $row = $this->ChatModel->getChat();
    $data['allusers'] = $row;
    $data['myid'] = $id;
		$this->load->view('chat', $data);
	}

  public function message(){
    date_default_timezone_set('Asia/Kolkata');
    $msg = $_POST['msg'];
    $opp_id = $_POST['opp_id'];
    $date = date("h:i A");
    $my_id = $this->ChatModel->getUserId($_SESSION['username']);
    $flag = $this->ChatModel->updateMsg($my_id, $opp_id, $msg, $date);
    $msgs = $this->ChatModel->getMsgs($my_id, $opp_id);
    $data['msgs'] = $msgs;
    echo json_encode($data);
  }

  public function UpdateClientMessage()
  {
    date_default_timezone_set('Asia/Kolkata');
    $msg = $_POST['msg'];
    $opp_id=$_POST['opp_id'];
    $my_id=$_POST['my_id'];
    $date=date("h:i A");
    $this->ChatModel->updateMsg($my_id, $opp_id, $msg, $date);
    $msgs = $this->ChatModel->getMsgs($my_id, $opp_id);
    $data['test'] = $msgs;
    echo json_encode($data);

    }

  public function getAllMessage(){
    date_default_timezone_set('Asia/Kolkata');
    $opp_id = $_POST['opp_id'];

    $my_id = $this->ChatModel->getUserId($_SESSION['username']);
    $msgs = $this->ChatModel->getMsgs($my_id, $opp_id);
    $data['status'] = $this->getOnlineStatus($opp_id);
    $data['all_msgs'] = $msgs;
    echo json_encode($data);
  }

  public function getOnlineStatus($opp_id){
    $my_id = $this->ChatModel->getUserId($_SESSION['username']);
    $status = $this->ChatModel->onlineStatus($opp_id);
    return $status;
    }

}
?>
