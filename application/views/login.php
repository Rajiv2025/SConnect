<?php $this->load->view('layout/header'); ?>
    <div style="margin-top: 30px;" class="container bg-primary p-5">
        <div class="border bg-white p-3">
          <?php if(isset($_SESSION['wrong'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['wrong']; ?>
            </div>
          <?php endif; ?>
            <div class="alert">
                <h3>Login</h3>
            </div>
            <hr style="height: 30px;
            border-style: solid;
            border-color: #b9b8b8;
            border-width: 1px 0 0 0;
            border-radius: 20px;
            box-shadow: 0 10px 10px -10px #8c8b8b inset;">
            <div class="container">
              <form class="form-group" action="" method="post">
                <div class="container">
                  <div class=" m-3">
                    <input type="email" name="email" id="emailid" placeholder="Enter Email ID" class="form-control border-0 bg-light p-4">

                  </div>
                        <div class=" m-3">
                            <input type="password" name="pass" id="password" placeholder="Enter Password"
                                class="form-control border-0 bg-light p-4">

                        </div>
                        <div class="mt-3 navbar">
                            <input id="loginbtn" name="loginbtn" type="submit" value="Login" class="btn btn-primary btn-lg" />
                            <input id="clearbtn" type="reset" value="clear" class="btn btn-primary btn-lg">
                        </div>
                    </div>
              </form>
            </div>
        </div>
        <div class="container text-white text-center pt-4">
            <h5><a href="forgot" class="form-group text-white">Forgot password ?</a></h5>
        </div>
        <div class="container text-white text-center pt-4">
            <h5>Dont have an account? <a href="register" class="form-group text-white">Register here</a>
        </div>
    </div>
    <?php $this->load->view('layout/footer'); ?>
