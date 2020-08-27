<?php
 /**
  *
  */
 class ChatModel extends CI_Model{
   public function getUsers($cur_email){
    $row = $this->db->query("select * from user where email <> '$cur_email'")->result_array();
    return $row;
   }
   public function onlineStatus($opp_id)
   {
     $row= $this->db->query("select id,online_status from user where id = '$opp_id'")->result_array();
     return $row;
   }

   public function getUserId($email){
    $row = $this->db->query("select id from user where email='$email'")->result_array();
    $id = $row[0]['id'];
    return $id;
   }

   public function updateMsg($my_id, $opp_id, $msg, $date){
     $data = array(
       "receiver_id" => $opp_id,
       "sender_id" => $my_id,
       "msg" => $msg,
       "show_time" => $date,
     );
     $data = array_filter($data);
     $this->db->insert("chat", $data);
     return true;
   }

   public function getMsgs($my_id, $opp_id){
     $row = $this->db->query("select * from chat where (sender_id='$my_id' and receiver_id='$opp_id') or (sender_id='$opp_id' and receiver_id='$my_id') order by msg_time")->result_array();
     return $row;
   }


 }


?>
