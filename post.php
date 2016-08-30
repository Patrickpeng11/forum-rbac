<?php
include_once('conn.php');

if (isset($_POST['deleteid'])) {
	$deleteid = $_POST['deleteid'];
	if ($userinfo['authority'] < 2) {
		echo 'you have no right to do this';
		exit;
	}
	
	if ($userinfo['authority'] == 4) {
		$sql = "delete from posts where id='$deleteid'";
		mysqli_query($link, $sql);
		echo 'ok';
		exit;
	} else {
		$sql = "select * from posts where id='$deleteid'";
		$query_id = mysqli_query($link, $sql);
		$row = mysqli_fetch_assoc($query_id);
		if ($row['userID'] != $_SESSION['userid']) {
			echo 'you can only delete the post that created by yourself';
			exit;
		} else {
			$sql = "delete from post where id='$deleteid'";
			mysqli_query($link, $sql);
			echo 'ok';
			exit;
		}
	}
}

if (isset($_GET['id'])) {
	$postid = $_GET['id'];
} else {
	echo 'invalid access';
	exit;
}

if (isset($_POST['newcomment'])) {
	$comment_content = trim($_POST['comment_content']);
	
	if ($userinfo['authority'] < 1) {
		$wrong = 'you have no right to create a comment';
	} else if (empty($comment_content)) {
		$wrong = 'comment can not be empty';
	} else {
		$time = time();
		$sql = "insert into comments (`userid`,`postid`,`time`,`content`) values ('$_SESSION[userid]','$postid','$time','$comment_content')";
		mysqli_query($link, $sql);
	}
}

$sql = "select posts.topicid,posts.title,posts.content,users.name from posts left join users on users.id=posts.userID where posts.id='$postid'";
$query_id = mysqli_query($link, $sql);
$postinfo = mysqli_fetch_assoc($query_id);

$sql = "select * from topics where id='$postinfo[topicid]'";
$query_id = mysqli_query($link, $sql);
$topicinfo = mysqli_fetch_assoc($query_id);

$sql = "select users.name,comments.content from comments left join users on users.id=comments.userid where postid='$postid'";
$query_id = mysqli_query($link, $sql);
$commentArr = array();
while ($row = mysqli_fetch_assoc($query_id)) {
	$commentArr[] = $row;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>bbs</title>
<link href="css/style.css" type="text/css" rel="stylesheet"  />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
	$('.delete_post').click(function(){
		$.ajax({ 
			type: "post",
			url: "post.php",
			data: {'deleteid':$(this).attr('id')},
			success: function(result) {
				if (result=='ok') {
					alert('delete successfully!');
					location.href = 'topic.php?id=<?php echo $topicinfo['id'];?>';
				} else {
					alert(result);
				}
			}
		});
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

<div id="nav">
	<ul>
    	<li class="active"><a href="index.php">HOME</a></li>
        <li><a href="allusers.php">ALL USERS</a></li>
    </ul>
</div>

<div id="content">
	<div class="main">
    	<div class="home">
        	<div class="title">
            	<a href="topic.php?id=<?php echo $topicinfo['id'];?>"><?php echo $topicinfo['title'];?></a>
            	&gt;&gt;
                <span class="now"><?php echo $postinfo['title'];?></span>
            </div>
            
            <div class="topics">
                <div class="posttitle">Title: <?php echo $postinfo['title'];?></div>
                <div class="postauthor">Author: <?php echo $postinfo['name'];?></div>
                <div class="content">Content: <?php echo $postinfo['content'];?></div>
            </div>
            
            <div class="postcontrols">
            	<a href="edit_post.php?id=<?php echo $postid;?>">Edit</a>
                <a id="<?php echo $postid;?>" class="delete_post">Delete</a>
            </div>
            
            <div class="comment">
            	<div class="commenttitle">Comments:</div>
                
                <?php foreach ($commentArr as $key => $value) {?>
                <div class="subcomment">
                	<div class="name">name:<span><?php echo $value['name'];?></span></div>
                    <div class="comment_content"><?php echo $value['content'];?></div>
                </div>
                <?php }?>
            </div>
        </div>
        
        <div class="home2">
        	<form method="post">
        	<div class="title">New Comment:</div>
            <div>
            	<textarea name="comment_content"></textarea>
            </div>
            
            <button type="submit" name="newcomment">Create New Comment</button>
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