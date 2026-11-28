<?php
session_start();
$errors=[
    'login'=>$_SESSION['login_error'] ??'',
    'register'=>$_SESSION['register_error']??'',
];
$activeForm=$_SESSION['active_form']??'login';
session_unset();
function showError($error){
    return !empty($error) ? "<p class='error_message'>$error</p>":'';
}
function isActiveForm($formName,$activeForm){
    return $formName===$activeForm ?'active':'';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drop</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
</head>
<body>
    <div class="faucet" id="faucet">
        <div class="pipe"></div>
        <div class="faucet-body">
            <div class="eye eye1"><div class="pupil"></div></div>
            <div class="eye eye2"><div class="pupil"></div></div>
            <div class="mouth"></div>
        </div>
        <div class="spout"></div>
        <div class="handle"></div>
    </div>
    <!--waterrrrr-->
    <div class="water"></div>
    <p class="hint">tap the faucet to turn on the water</p>
    <div class="pool"></div>
    <div class="bubble b1"></div>
    <div class="bubble b2"></div>
    <div class="bubble b3"></div>
    <div class="bubble b4"></div>
    <div class="bubble b5"></div>
    <div class="login-register">
    <h2>Welcome to DROP</h2>

    <!-- Login Box -->
    <div class="acc-box <?= isActiveForm('login', $activeForm) ?>" id="login-box">
        <form action="login_register.php" method="post">
            <h2>Login</h2>
            <?= showError($errors['login']); ?>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login" class="btn1">Login</button>
            <p>Don't have an account yet? <a href="#" onclick="showForm('register-box')">Register</a></p>
        </form>
    </div>

    <!-- Register Box -->
    <div class="acc-box <?= isActiveForm('register', $activeForm) ?>" id="register-box">
        <form action="login_register.php" method="post">
            <h2>Register</h2>
            <?= showError($errors['register']); ?>
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register" class="btn1">Register</button>
            <p>Already have an account? <a href="#" onclick="showForm('login-box')">Login</a></p>
        </form>
    </div>
</div>
    
</div>
<script src="script.js"></script>