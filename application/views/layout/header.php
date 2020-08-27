<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-grid.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-reboot.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/about-style.css'); ?>">
</head>

<body>

    <div class="container-fluid" style="display: flex;place-content: space-between;">
        <div>
            <p>website name / logo</p>
        </div>
        <div class="text-right">
          <?php if(isset($_SESSION['loggedin'])): ?>
            <a href="<?php echo base_url('logout') ?>">Logout</a>
          <?php else: ?>
            <a class="br-1" href="<?php echo base_url('login') ?>">Login</a> /
            <a href="<?php echo base_url('register') ?>">Register</a>
          <?php endif; ?>
        </div>
    </div>
    
