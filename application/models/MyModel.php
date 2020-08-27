<?php
 /**
  *
  */
 class MyModel extends CI_Model{

   public function addRow($fname, $lname, $email, $password){
     $data = array(
     "name" => $fname." ".$lname,
     "email" => $email,
     "password" => $password
     );
     $this->db->insert("user",$data);
     return true;
   }
   public function checkCred($email, $pass){
    $query = $this->db->query("select email, password from user where email='$email' and password='$pass'");
    $var1 = $query->result();
    if(count($var1) > 0){
      return TRUE;
    } else{
      return FALSE;
    }
  }

   public function checkAdminCred($email, $pass){
    $query = $this->db->query("select username, password from admin where username='$email' and password='$pass'");
    $var1 = $query->result();
    if(count($var1) > 0){
      return TRUE;
    } else{
      return FALSE;
    }
  }

  public function getUserId($tablename, $email){
    $row = $this->db->query("select id from $tablename where username='$email'")->result_array();
		$user_id = $row[0]['id'];
    return $user_id;
  }

  public function checkCourseId($u_id, $c_id){
    $row = $this->db->query("select count(user_id), course_id from user_courses where user_id='$u_id' and  course_id='$c_id' group by course_id having count(user_id) > 0")->result_array();

    if (count($row) > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function updateRow($u_id, $c_id){
    $data = array(
      "user_id" => $u_id,
      "course_id" => $c_id
    );
    $data = array_filter($data);
    $this->db->insert("user_courses", $data);
    return true;
  }


 }


?>
