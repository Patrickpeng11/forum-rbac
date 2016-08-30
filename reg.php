<?php

include_once('conn.php');

if (!empty($_SESSION['userid'])) {
	header('Location: index.php');
	exit;
}

if (isset($_POST['submit'])) {
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$password2 = trim($_POST['password2']);
	$name = trim($_POST['name']);
	
	if (empty($email) || empty($password) || empty($password2) || empty($name)) {
		$wrong = 'All inputs can not be empty!';
	} else if ($password != $password2) {
		$wrong = 'Passwords are not the same!';
	} else if (!preg_match("/@/",$email)) {
		$wrong = 'Email format is wrong';
	} else {
		$sql = "select * from users where email='$email'";
		$query_id = mysqli_query($link, $sql);
		if ($userinfo = mysqli_fetch_assoc($query_id)) {
			$wrong = 'This email have be registered! Please change another one!';
		} else {
			$password = hash('sha256', $password);
			$sql = "insert into users (`email`,`password`,`name`,`authority`) values ('$email','$password','$name','1')";
			mysqli_query($link, $sql);
			$lastID = mysqli_insert_id($link);
			$wrong = "<span class='right'>Successfully!</span>";
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>register</title>
<link href="css/style.css" type="text/css" rel="stylesheet"  />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
	$('#regform').submit(function(){
		if (!this.email.value || this.email.value.indexOf('@')==-1) {
			alert('Email can not be empty, and must contain "@"');
			return false;
		}
		
		if (!this.password.value) {
			alert('Password can not be empty!');
			return false;
		}
		
		if (this.password.value != this.password2.value) {
			alert('Twice password must be the same');
			return false;
		}

		if (!this.name.value) {
			alert('Your name can not be empty!');
			return false;
		}
	});
})
</script>
</head>
<body>

<div id="wrapper">

<div id="header">
	<?php if (empty($_SESSION['userid'])) {?>
    	<a href="reg.php">Register</a>
    	<span class="split">|</span>
    	<a href="login.php">Login</a>
    <?php } else {?>
    	<span>Welcome：<a href="#"><?php echo $userinfo['name'];?></a></span>
    	<span class="split">|</span>
    	<a href="logout.php">Logout</a>
    <?php }?>
</div>

<div id="content">

	<div class="login">
    	<div class="title">
        	Register
        </div>
        
        <form method="post" id="regform">
        <div class="item">
        	<div class="sub">Email:</div>
            <div class="input"><input type="text" name="email" placeholder="Email"></div>
        </div>
        
        <div class="item">
        	<div class="sub">Password:</div>
            <div class="input"><input type="password" name="password" placeholder="Password"></div>
        </div>
        
        <div class="item">
        	<div class="sub">Password Again:</div>
            <div class="input"><input type="password" name="password2" placeholder="Password Again"></div>
        </div>
        
        <div class="item">
        	<div class="sub">Your Name:</div>
            <div class="input"><input type="text" name="name" placeholder="Your Name"></div>
        </div>
        
        <div class="item warning"><?php echo $wrong;?></div>
        
        <div class="item">
        	<button type="submit" name="submit">Register</button>
        </div>
        
        </form>
    </div>
</div>

<div id="footer">
	2016 Spring Web Application Security&copy; copyright
</div>
</div>

</body>
</html>