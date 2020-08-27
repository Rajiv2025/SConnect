<?php $this->load->view('layout/header'); ?>

    <div style="margin-top: 30px;" class="container bg-primary p-5">
        <div class="border bg-white p-3">
          <?php if (isset($_SESSION['success'])):?>
            <div class="alert alert-success">
              <?php echo $_SESSION['success']?>
            </div>
          <?php endif ?>
            <div class="alert">
                <h3>Register with us</h3>
                <p class="text-secondary">Please fill the details to create an account</p>
            </div>
            <hr style="height: 30px;
            border-style: solid;
            border-color: #b9b8b8;
            border-width: 1px 0 0 0;
            border-radius: 20px;
            box-shadow: 0 10px 10px -10px #8c8b8b inset;">
            <div class="container">
                <!-- form starts -->
                <form class="form-group" action="" method="post">
                    <!-- name container -->
                    <div class="d-flex m-3">
                        <!-- first name div -->
                        <div class="container-fluid">
                            <input type="text" name="fname" id="fname" value="" placeholder="First Name"
                                class="form-control border-0 mr-2 bg-light p-4">
                                <span class="text-danger"> <?php echo form_error('fname') ?> </span>
                        </div>
                        <!-- last name div -->
                        <div class="container-fluid">
                            <input type="text" name="lname" id="lname" value="" placeholder="Last Name"
                                class="form-control border-0 ml-2 bg-light p-4">
                            <span class="text-danger"> <?php echo form_error('lname') ?> </span>

                        </div>
                    </div>
                    <!-- email div -->
                    <div class=" m-3">
                        <input type="email" name="email" id="emailid" value="" placeholder="Enter Email ID"
                            class="form-control border-0 bg-light p-4">
                        <span class="text-danger"> <?php echo form_error('email') ?> </span>

                    </div>
                    <!-- password div -->
                    <div class=" m-3">
                        <input type="password" name="pass" id="password" value="" placeholder="Enter Password"
                            class="form-control border-0 bg-light p-4">
                        <span class="text-danger"> <?php echo form_error('pass') ?> </span>

                    </div>
                    <!-- confirm pass div -->
                    <div class=" m-3">
                        <input type="password" name="cpass" id="confirmpassword" value="" placeholder="Confirm Password"
                            class="form-control border-0 bg-light p-4">
                        <span class="text-danger"> <?php echo form_error('cpass') ?> </span>

                    </div>
                    <!-- submit button  -->
                    <div class="container text-center">
                        <input type="submit" name="registerbtn" value="Register!" class="btn btn-lg btn-primary">

                    </div>
                </form>
                <!-- form ends here -->
            </div>

        </div>
        <!-- question login -->
        <div class="container text-white text-center pt-4">
            Already have an account? <a href="login" class="form-group text-white">Login here</a>
        </div>
    </div>

    <?php $this->load->view('layout/footer'); ?>
