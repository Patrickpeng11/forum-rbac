<?php


include_once('conn.php');


if (!empty($_SESSION['userid'])) {
	header('Location: index.php');
	exit;
}

if (isset($_POST['submit'])) {
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$password = hash('sha256', $password);
	
	$sql = "SELECT * from users WHERE email='" . $email ."' and password='" . $password . "'";
	$query_id = mysqli_query($link, $sql);
	if ($userinfo = mysqli_fetch_assoc($query_id)) {
		$_SESSION['userid']	= $userinfo['id'];
		header('Location: index.php');
		exit;
	} else {
		$wrong = 'Sorry. Email or Password is wrong!';
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>login</title>
<link href="css/style.css" type="text/css" rel="stylesheet"  />
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
        	Login
        </div>
        
        <form method="post">
        <div class="item">
        	<div class="sub">Email:</div>
            <div class="input"><input type="text" name="email" placeholder="Email"></div>
        </div>
        
        <div class="item">
        	<div class="sub">Password:</div>
            <div class="input"><input type="password" name="password" placeholder="Password"></div>
        </div>
        
        <div class="item warning"><?php echo $wrong;?></div>
        
        <div class="item">
        	<button type="submit" name="submit">Login</button>
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