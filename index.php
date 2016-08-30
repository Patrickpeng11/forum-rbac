<?php
include_once('conn.php');

if (isset($_POST['newtopic'])) {
	$topic_name = trim($_POST['topic_name']);
	$topic_name = strtolower($topic_name);
	
	if ($userinfo['authority'] < 3) {
		$wrong = 'only administrator or moderator can create a new topic';
	} else if (empty($topic_name)) {
		$wrong = 'topic name can not be empty';
	} else {
		$sql = "select * from topics where title='$topic_name'";
		$query_id = mysqli_query($link, $sql);
		if ($row = mysqli_fetch_assoc($query_id)) {
			$wrong = 'This topic have existed. please change another one';
		} else {
			$sql = "insert into topics (`title`,`userid`) values ('$topic_name','$_SESSION[userid]')";
			mysqli_query($link, $sql);
		}
	}
}

if (isset($_POST['deleteid'])) {
	$deleteid = $_POST['deleteid'];
	if ($userinfo['authority'] < 3) {
		echo 'only administrator or moderator can delete a topic';
		exit;
	}
	
	if ($userinfo['authority'] == 4) {
		$sql = "delete from topics where id='$deleteid'";
		mysqli_query($link, $sql);
		echo 'ok';
		exit;
	} else {
		$sql = "select * from topics where id='$deleteid'";
		$query_id = mysqli_query($link, $sql);
		$row = mysqli_fetch_assoc($query_id);
		if ($row['userid'] != $_SESSION['userid']) {
			echo 'you can only delete the topic that created by yourself';
			exit;
		} else {
			$sql = "delete from topics where id='$deleteid'";
			mysqli_query($link, $sql);
			echo 'ok';
			exit;
		}
	}
}

$sql = "select * from topics";
$query_id = mysqli_query($link, $sql);
$topicArr = array();
while ($row = mysqli_fetch_assoc($query_id)) {
	$topicArr[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Web Application Security Project 3</title>
<link href="css/style.css" type="text/css" rel="stylesheet"  />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
	$('.delete_topic').click(function(){
		$.ajax({ 
			type: "post",
			url: "index.php",
			data: {'deleteid':$(this).attr('id')},
			success: function(result) {
				if (result=='ok') {
					alert('delete successfully!');
					location.href = 'index.php';
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
        	<div class="title">All topics</div>
            
            <div class="topics">
            	<ul>
                	<?php foreach ($topicArr as $key => $value) {?>
                    	<li>
                        	<a href="topic.php?id=<?php echo $value['id'];?>"><?php echo $value['title'];?></a>
                            <span class="controls">
                            	<a href="edit_topic.php?id=<?php echo $value['id'];?>">Edit</a>
                                <a id="<?php echo $value['id'];?>" class="delete_topic">Delete</a>
                            </span>
                        </li>
                    <?php }?>
                </ul>
            </div>
        </div>
        
        <div class="home2">
        	<form method="post">
        	<div>New Topic Name:</div>
            <div>
            	<input type="text" name="topic_name">
            </div>
            <button type="submit" name="newtopic">Create New Topic</button>
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