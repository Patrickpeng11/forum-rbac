<?php
include_once('conn.php');

if (isset($_GET['id'])) {
	$userid = $_GET['id'];
} else {
	echo 'invalid access';
	exit;
}

if (empty($_SESSION['userid'])) {
	header('location: login.php');
	exit;
}

if (isset($_POST['change_authority'])) {
	$authority = $_POST['authority'];
	
	$sql = "select * from users where id='$userid'";
	$query_id = mysqli_query($link, $sql);
	$this_user_info = mysqli_fetch_assoc($query_id);
	
	if ($userid == $_SESSION['userid']) {
		$wrong = 'you can not change authority by youself';
	} else if ($userinfo['authority'] < 3) {
		$wrong = 'only administrator or moderator can change authority!';
	} else if ($userinfo['authority'] <= $this_user_info['authority']) {
		$wrong = 'your can not do this';
	} else if ($authority == 4) {
		$wrong = 'website can have only one administrator.';
	} else {
		$sql = "update users set authority='$authority' where id='$userid'";
		mysqli_query($link, $sql);
		$wrong = "<span class='right'>Successfully!</span>";
	}
}

$sql = "select * from users where id='$userid'";
$query_id = mysqli_query($link, $sql);
$this_user_info = mysqli_fetch_assoc($query_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>bbs</title>
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

<div id="nav">
	<ul>
    	<li><a href="index.php">HOME</a></li>
        <li class="active"><a href="allusers.php">ALL USERS</a></li>
    </ul>
</div>

<div id="content">
	<div class="main">
    	<div class="home">
        	<div class="title"><?php echo $this_user_info['name'];?></div>
            
            <div class="change">
            	<form method="post">
            	<div class="subchange">his/her authority</div>
                <select name="authority">
                	<option value="1" <?php if ($this_user_info['authority']==1) {?>selected<?php }?>>user</option>
                    <option value="2" <?php if ($this_user_info['authority']==2) {?>selected<?php }?>>author</option>
                    <option value="3" <?php if ($this_user_info['authority']==3) {?>selected<?php }?>>moderator</option>
                    <option value="4" <?php if ($this_user_info['authority']==4) {?>selected<?php }?>>admin</option>
                </select>
                <div>
                	<button type="submit" name="change_authority">Change his/her authority</button>
                    <span class="warning"><?php echo $wrong;?></span>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="footer">
	2016 Spring Web Application Security&copy; copyright
</div>
</div>

</body>
</html>