<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RegisterController extends CI_Controller {

  public function register(){
    $this->load->library('form_validation');
    $this->load->model('MyModel');
    $this->form_validation->set_rules("fname", "firstsname", "required");
    $this->form_validation->set_rules("lname", "lastsname", "required");
    $this->form_validation->set_rules("email", "Email-Id", "required|is_unique[user.email]");
    $this->form_validation->set_rules("pass", "password", "required");
    $this->form_validation->set_rules("cpass", "cpassword", "required");

    if ($this->form_validation->run() !== FALSE) {
      $fname = $this->input->post('fname');
      $lname = $this->input->post('lname');
      $email = $this->input->post('email');
      $password = $this->input->post('pass');

      $varrrr = $this->MyModel->addRow($fname, $lname, $email, $password);

      if ($varrrr) {
        $this->session->set_flashdata('success', "Registration Successful !");
        redirect(base_url('login'));
      } else {
      }
    }
    $this->load->view('register');
  }//register function ends


}

?>
