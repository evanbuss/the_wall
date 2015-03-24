<?php
 session_start();

 require_once('connection.php');

 

 if(isset($_POST['action']) && $_POST['action'] == "register")
 {  
  register_user($_POST);
 }
 elseif(isset($_POST['action']) && $_POST['action'] == "login")
 {
  login_user($_POST);
 }
 elseif(isset($_POST['action']) && $_POST['action'] == "postMessage")
 {
  post_message($_POST);
 }
  elseif(isset($_POST['action']) && $_POST['action'] == "postComment")
 {
  post_comment($_POST);
 }
 elseif (isset($_POST['action']) && $_POST['action'] == "delete") 
 {
  delete_post($_POST);
 }
 
   update_wall();
   header("location: wall.php");

 function register_user($post)
 {
    $_SESSION['errors'] = array();

      if(empty($post['first_name']))
      {
        $_SESSION['errors'][] = "please enter a first name ";
      }
      if(empty($post['last_name']))
      {
        $_SESSION['errors'][] = "please enter a last name ";
      }
      if(empty($post['email']) && !filter_var($post['email'], FILTER_VALIDATE_EMAIL))
      {
        $_SESSION['errors'][] = "please enter a valid email ";
      }
      if(empty($post['password']))
      {
        $_SESSION['errors'][] = "please enter a password ";
      }
      if($post['password'] !== $post['confirm_password'])
      {
        $_SESSION['errors'][] = "please make sure passwords match ";
      }

      if(count($_SESSION['errors']) > 0)
      {
        header("location: index_1.php");
        die();
      }

      else
      {
        $fname = escape_this_string($post['first_name']);
        $lname = escape_this_string($post['last_name']);
        $email = escape_this_string($post['email']);
        $password = escape_this_string(md5($post['password']));

        $query = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at) VALUES ('{$fname}', '{$lname}', '{$email}', '{$password}', NOW(), NOW())";
        run_mysql_query($query);
        $_SESSION['success'] = array();
        $_SESSION['success'][] = "User registration was successful";
        header("location: index_1.php");
        die();
      }
 }

 function login_user($post)
 {
  $email = escape_this_string($post['email']);
  $password = escape_this_string(md5($post['password']));

  $user = fetch_record("SELECT * FROM users WHERE users.password = '{$password}' AND users.email = '{$email}'");

  if(!empty($user))
  {

      $_SESSION['id'] = $user['users_id'];
      $_SESSION['name'] = $user['first_name']. " ". $user['last_name'];
  }
    else
    {
      bad_credentials();
    }
  }

 function bad_credentials()
 {
  $_SESSION['errors'][] = "User has not been found in db";
  header("location: index_1.php");
  die();
 }




function post_message($post) 
{
  $_SESSION['errors'] = array();
  $_SESSION['success'] = array();
  $message = escape_this_string($post['message']);
  $userID = $_SESSION['id'];

      if(empty($post['message']))
      {
        $_SESSION['errors'][] = "There is nothing to Post!";
        header('location: wall.php');
        die();
      }
      else 
      {
        $query = "INSERT INTO messages (message, created_at, updated_at, users_users_id) VALUES ('{$message}', NOW(), NOW(), '{$userID}')";
        run_mysql_query($query);

        $_SESSION['success'][] = "You Posted a Message";

        $newQuery = "SELECT * FROM messages LEFT JOIN users ON messages.users_users_id = users.users_id";
        $allMessages = fetch_all($newQuery);
        $_SESSION['message'] = $allMessages;
      }
}


function post_comment($post) 
{

  $_SESSION['errors'] = array();
  $_SESSION['success'] = array();
  $comment = escape_this_string($post['comment']);
  $messageID = $_POST['message_id'];
  $userID = $_SESSION['id'];


    if(empty($post['comment']))
    {
      $_SESSION['errors'][] = "There is nothing to Post!";
      header('location: wall.php');
      die();
    }
    else 
    {
      $query = "INSERT INTO comments (comment, created_at, updated_at, messages_messages_id, users_users_id) VALUES ('{$comment}', NOW(), NOW(), '{$messageID}', '{$userID}')";
      run_mysql_query($query);

      $_SESSION['success'][] = "You Posted a Comment";
   
      $anotherQuery = "SELECT comments.comment,comments.messages_messages_id,users.first_name,users.last_name,comments.created_at FROM comments LEFT JOIN users ON comments.users_users_id=users.users_id";
      $allComments = fetch_all($anotherQuery);
      $_SESSION['comment'] = $allComments;
    }
}

function update_wall() 
{
  $query_messages = "SELECT * FROM messages LEFT JOIN users ON messages.users_users_id = users.users_id";
  $query_comments = "SELECT comments.comment,comments.messages_messages_id,users.first_name,users.last_name,comments.created_at FROM comments LEFT JOIN users ON comments.users_users_id=users.users_id";
  $_SESSION['message']=fetch_all($query_messages);
  $_SESSION['comment']=fetch_all($query_comments);
}



function delete_post() 
{
  $queryUserID = "SELECT users.users_id FROM users WHERE users.users_id = '{$_SESSION['id']}' ";
  $messageQuery = "SELECT messages_id, users_id FROM messages LEFT JOIN users ON messages.users_users_id = users.users_id WHERE users.users_id = '{$_SESSION['id']}' AND messages.messages_id = '{$_POST['message_id']}' ";
  $commentsQuery = "SELECT comments_id, messages_messages_id FROM comments LEFT JOIN users ON comments.users_users_id = users.users_id WHERE users.users_id = '{$_SESSION['id']}' AND comments.messages_messages_id = '{$_POST['message_id']}' ";
  $messageQuery = fetch_all($messageQuery);

       if(empty($messageQuery))
       {
        $_SESSION['errors'][] = "Sorry you cannot delete this post";
          header('location: wall.php');
          die();
       }
       else 
       {
          $deleteComments = "DELETE FROM comments WHERE comments.users_users_id = '{$_SESSION['id']}' AND comments.messages_messages_id = '{$_POST['message_id']}' ";
          $deleteMessages = "DELETE FROM messages WHERE messages.users_users_id = '{$_SESSION['id']}' AND messages.messages_id = '{$_POST['message_id']}' ";
          run_mysql_query($deleteComments);
          run_mysql_query($deleteMessages);

          $_SESSION['success'][] = "You deleted your post!";
       }
          
}


die();














