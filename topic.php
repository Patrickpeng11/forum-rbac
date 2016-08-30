<?php
include_once('conn.php');

if (isset($_GET['id'])) {
	$topicid = $_GET['id'];
} else {
	echo 'invalid access';
	exit;
}

if (isset($_POST['newpost'])) {
	$post_name = trim($_POST['post_name']);
	$post_content = trim($_POST['post_content']);
	
	if ($userinfo['authority'] < 2) {
		$wrong = 'you have no right to create a new post';
	} else if (empty($post_name)) {
		$wrong = 'Post Title can not be empty';
	} else if (empty($post_content)) {
		$wrong = 'Post Content can not be empty';
	} else {
		$time = time();
		$sql = "insert into posts (`userID`,`topicid`,`title`,`content`,`time`) values ('$_SESSION[userid]','$topicid','$post_name','$post_content','$time')";
		mysqli_query($link, $sql);
	}
}

$sql = "select * from topics where id='$topicid'";
$query_id = mysqli_query($link, $sql);
$topicinfo = mysqli_fetch_assoc($query_id);

$sql = "select * from posts where topicid='$topicid'";
$query_id = mysqli_query($link, $sql);
$postArr = array();
while ($row = mysqli_fetch_assoc($query_id)) {
	$postArr[] = $row;
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
    	<li class="active"><a href="index.php">HOME</a></li>
        <li><a href="allusers.php">ALL USERS</a></li>
    </ul>
</div>

<div id="content">
	<div class="main">
    	<div class="home">
        	<div class="title"><span><?php echo $topicinfo['title'];?></span></div>
            
            <div class="topics">
            	<?php if (!empty($postArr)) {?>
            	<ul>
                	<?php foreach ($postArr as $key => $value) {?>
                    	<li><a href="post.php?id=<?php echo $value['id'];?>"><?php echo $value['title'];?></a></li>
                    <?php }?>
                </ul>
                <?php } else {?>
                	have no post in this topic, you can create a new one!
                <?php }?>
            </div>
        </div>
        
        <div class="home2">
        	<form method="post">
        	<div class="title">New Post Title:</div>
            <div>
            	<input type="text" name="post_name">
            </div>
            
            <div class="title">New Post Content:</div>
            <div>
            	<textarea name="post_content"></textarea>
            </div>
            
            <button type="submit" name="newpost">Create New Post</button>
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