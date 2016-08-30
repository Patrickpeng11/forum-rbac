<?php
include_once('conn.php');

if (isset($_GET['id'])) {
	$post_id = $_GET['id'];
} else {
	echo 'invalid access';
	exit;
}

if (isset($_POST['changepost'])) {
	$post_name = trim($_POST['post_name']);
	$post_content = trim($_POST['post_content']);
	$post_id = $_POST['post_id'];
	
	if (empty($post_id)) {
		$wrong = 'this post is not existed.';
	} else if (empty($post_name)) {
		$wrong = 'post title can not be empty';
	} else if (empty($post_content)) {
		$wrong = 'post content can not be empty';
	} else if ($userinfo['authority'] < 2) {
		$wrong = 'you have no right to do this';
	} else if ($userinfo['authority'] == 4) {
		$sql = "update posts set title='$post_name',content='$post_content' where id='$post_id'";
		$query_id = mysqli_query($link, $sql);
		$wrong = "<span class='right'>Successfully!</span>";
	} else {
		$sql = "select * from posts where id='$post_id'";
		$query_id = mysqli_query($link, $sql);
		$row = mysqli_fetch_assoc($query_id);
		if ($row['userID'] != $_SESSION['userid']) {
			$wrong = 'you can only change the post that created by yourself';
		} else {
			$sql = "update posts set title='$post_name',content='$post_content' where id='$post_id'";
			$query_id = mysqli_query($link, $sql);
			$wrong = "<span class='right'>Successfully!</span>";
		}
	}
}

$sql = "select * from posts where id='$post_id'";
$query_id = mysqli_query($link, $sql);
$postInfo = mysqli_fetch_assoc($query_id);
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
        	<div class="title">Change Post Title:</div>
            <div>
            	<input type="text" name="post_name" value="<?php echo $postInfo['title'];?>">
            </div>
            
            <div class="title">Change Post Content:</div>
            <div>
            	<textarea name="post_content"><?php echo $postInfo['content'];?></textarea>
            </div>
            
            <input type="hidden" name="post_id" value="<?php echo $post_id;?>">
            
            <button type="submit" name="changepost">Change This Post</button>
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