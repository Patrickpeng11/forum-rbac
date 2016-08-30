<?php
include_once('conn.php');

if (isset($_GET['id'])) {
	$topic_id = $_GET['id'];
} else {
	echo 'invalid access';
	exit;
}

if (isset($_POST['changetopic'])) {
	$topic_name = trim($_POST['topic_name']);
	$topic_name = strtolower($topic_name);
	$topic_id = $_POST['topic_id'];
	
	if (empty($topic_id)) {
		$wrong = 'this topic is not existed.';
	} else if (empty($topic_name)) {
		$wrong = 'topic name can not be empty';
	} else if ($userinfo['authority'] < 3) {
		$wrong = 'you have no right to do this';
	} else {
		$sql = "select * from topics where title='$topic_name'";
		$query_id = mysqli_query($link, $sql);
		if ($row = mysqli_fetch_assoc($query_id)) {
			$wrong = 'This topic have existed. please change another one';
		} else {
			if ($userinfo['authority'] == 4) {
				$sql = "update topics set title='$topic_name' where id='$topic_id'";
				mysqli_query($link, $sql);
				$wrong = "<span class='right'>Successfully!</span>";
			} else {
				$sql = "select * from topics where id='$topic_id'";
				$query_id = mysqli_query($link, $sql);
				$row = mysqli_fetch_assoc($query_id);
				if ($row['userid'] != $_SESSION['userid']) {
					$wrong = 'you can only edit the topic that created by yourself';
				} else {
					$sql = "update topics set title='$topic_name' where id='$topic_id'";
					mysqli_query($link, $sql);
					$wrong = "<span class='right'>Successfully!</span>";
				}
			}
		}
	}
}

$sql = "select * from topics where id='$topic_id'";
$query_id = mysqli_query($link, $sql);
$topicInfo = mysqli_fetch_assoc($query_id);
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
    	<li class="active"><a href="index.php">HOME</a></li>
        <li><a href="allusers.php">ALL USERS</a></li>
    </ul>
</div>

<div id="content">
	<div class="main">

        <div class="home2">
        	<form method="post">
        	<div>Change Topic Name:</div>
            <div>
            	<input type="text" name="topic_name" value="<?php echo $topicInfo['title'];?>">
                <input type="hidden" name="topic_id" value="<?php echo $topicInfo['id'];?>">
            </div>
            <button type="submit" name="changetopic">Change Topic Name</button>
            <span class="warning"><?php echo $wrong;?></span>
            </form>
        </div>
    </div>
</div>

<div id="footer">
	2016 Spring Web Application Security&copy; copyright
</div>
</div>

</body>
</html>