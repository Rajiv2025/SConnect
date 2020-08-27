<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {

  public function login(){

		if (isset($_SESSION['loggedin']) ) {
			redirect(base_url('chat'));
		} else{
			$this->load->library('form_validation');
			$this->load->model('MyModel');
			$this->form_validation->set_rules("email", "anything", "required");
			$this->form_validation->set_rules("pass", "Password", "required");

			if($this->form_validation->run() !== FALSE){
				$email = $this->input->post('email');
				$password = $this->input->post('pass');
				$flag = $this->MyModel->checkCred($email, $password);
				if ($flag) {
					$this->session->username = $email;
					$_SESSION['loggedin'] = TRUE;
					$_SESSION['wrong'] = null;

					redirect(base_url('chat'));
				} else{
					$this->session->set_flashdata("wrong", "Check your Credentials!");
				}
			}
			$this->load->view('login');
		}

	}

  public function logout(){
		$email = $this->session->username;
		$this->db->query("update user set online_status = 'offline' where email = '$email'");
		$_SESSION['loggedin'] = null;
		$_SESSION['username'] = null;
		redirect(base_url("login"));
	}


}
