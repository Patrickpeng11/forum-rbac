<?php
include_once('conn.php');

$sql = "select * from users";
$query_id = mysqli_query($link, $sql);
$userArr = array();
while ($row = mysqli_fetch_assoc($query_id)) {
	$userArr[] = $row;
}
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
        	<div class="title">All users</div>
            
            <div class="allusers">
            	<?php foreach ($userArr as $key => $value) {?>
                <div class="item">
                	<a href="user.php?id=<?php echo $value['id'];?>"><?php echo $value['name'];?></a>
                </div>
                <?php }?>
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