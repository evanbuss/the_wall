<?php
  session_start();
  require_once('connection.php');

       // var_dump($_SESSION['errors']);
       // die();
?>




<html>
<head>
	<title>The Wall</title>
      <link rel="stylesheet" href="/css/normalize.css">
      <link rel="stylesheet" href="/css/skeleton.css">


      <style type="text/css">

      .header {
      	height: 75px;
      	width: 100%;
      	position: absolute;
      	border-bottom: 1px solid grey;
      }

      .message {
      	position: relative;
      	top: 100px;
      }

      .showPosts {
      	position: relative;
      	font-family: 'Times New Roman';
      	font-size: 20px;
      	margin-top: 50px;
      	border-bottom: 1px solid grey;
      }

      .posts {
      	border-bottom: 1px solid lightgrey; 
      }

      .comments {
            border-bottom: 1px solid lightgrey;
            margin-left: 50px;
      }

      .success {
      	color: lightgreen;
      }
      .error {
            color: red;
      }

      #align {
            display: inline-block;
            position: relative;
      }

      body {
            background-color: whitesmoke;
      }

      div h6 {
      	position: relative;
      	vertical-align: top;
      	left: 65%;
      	top: 10px;
      }

      div h4 {
      	position: absolute;
      	vertical-align: top;
      }

      div button {
      	position: absolute;
      	vertical-align: top;
      	left: 85%;
      	top: 10px;
      }

      a {
      	color: white;
            padding-top: 40px;
            padding-bottom: 40px;
      }

      </style>

</head>

<body>
<div class="container">
	<div> 
		<?php 
			if(isset($_SESSION['success'])) 
			{
                        foreach ($_SESSION['success'] as $success) 
                        {
                             echo '<div class="success">'. $success .'</div>';
                        }
			     
			} 
			unset($_SESSION['success']);

			if(isset($_SESSION['errors']))
			{
				foreach ($_SESSION['errors'] as $error) 
                        {
					echo '<div class="error">' . $error . '</div>';
				}
				unset($_SESSION['errors']);
			}
		?> 
	</div>

	<div class="row">
		<div class="header">
			<h4> CodingDojo Wall </h4>
			<button class="button-primary"><a href="logout.php">Log Out</a></button>
			<h6>Welcome <?= $_SESSION['name']?></h6>
		</div>
	</div>	


	<div class="row">
		<div class="showPosts">
		<?php 

            echo  '<div class="message">
                        <form action="process.php" method="post">
                              <label class="theMessage"> Message </label>
                              <input type="hidden" name="action" value="postMessage">
                              <textarea class="u-full-width" id="theMessage" name="message"></textarea> 
                              <input class="button-primary" type="submit" value="Post A Message" />
                        </form>
                  </div>';


            	if(isset($_SESSION['message'])) 
			{

				foreach(array_reverse($_SESSION['message']) as $message) 
				{	
					echo '<div class="posts">'.'<h6>'.$message['first_name']." ".$message['last_name']." - ".date('M d Y',strtotime($message['created_at'])).'</h6><br><p>'.$message['message'].'</div><br>';   
	
                        if(isset($_SESSION['comment'])) 
                        {
                              foreach($_SESSION['comment'] as $comment) 
                              {     
                                    if($message['messages_id'] === $comment['messages_messages_id'])
                                    {      
                                    echo '<div class="comments">'.'<h6>'.$comment['first_name']." ".$comment['last_name']." - ".date('M d Y',strtotime($comment['created_at'])).'</h6><br><p>'.$comment['comment'].'</div><br>';
                                    }
                              }
                        }     

                        echo '<div>
                                    <form action="process.php" method="post">
                                          <label class="theComment"> Comment </label>
                                          <input type="hidden" name="action" value="postComment">
                                          <textarea class="u-full-width" id="theComment" name="comment"></textarea>
                                          <input class="button-primary" type="submit" value="Post A Comment">
                                          <input type ="hidden" name="message_id" value="'.$message['messages_id'].'">
                                          <input type="hidden" name="action" value="delete">
                                          <input class="button-primary" type="submit" value="Delete Post">
                                          <input type="hidden" name="message_id" value="'.$message['messages_id'].'">
                                    </form>
                              </div>';
  
                        }
			}
		 ?>

            </div>
      </div>



</div>	

</body>

</html>
