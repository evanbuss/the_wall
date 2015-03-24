<?php
 session_start();
 require('connection.php');
?>
<html>
<head>
  <title>Login and Registration</title>
      <link rel="stylesheet" href="/css/normalize.css">
      <link rel="stylesheet" href="/css/skeleton.css">
      <!-- error message  -->

      <!-- jQuery -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js" type="text/javascript"></script>
      <!-- error message -->

      <!-- jshake -->
      <link rel="stylesheet" type="text/css" href="jshake-1.1.min.css">
      <script type="text/javascript" src="jquery.js"></script>
      <script type="text/javascript" src="jshake-1.1.min.js"></script>

      <script type="text/javascript">
          $(document).ready(function(){
            $('#login').jshake();
          });
      </script>

      <style type="text/css">
        .register{
          display: inline-block;
          padding: 20px;
          border: 1px solid lightgrey;
          background-color: whitesmoke;
          border-radius: 20px;
        }
        .login{
          display: inline-block;
          vertical-align: top;
          padding: 20px;
          border: 1px solid lightgrey;
          border-radius: 20px;
          background-color: whitesmoke;
        }
        .new {
          position:absolute;
          left: 300px;
          vertical-align: top;
        }
        #error {
          position: relative;
          height: 35px;
          width: 200px;
          background-color: whitesmoke;
          color: red;
          padding:10px;
          border: 1px solid grey;
          border-radius: 5px;
          left: 75%;
          top: 300px;
          text-align: center;
        }
        body {
          background:url(content/the_wall_pic.png) no-repeat;
        }

        button {
          position: absolute;
          top: 50px;
          left: 700px;
        }
        a{
          color: white;
        }

        h2 {
          color: blue;
        }

        video {  
          position: fixed;
          display:block;
          right: 0;
          bottom: 0;
          min-width: 100%;
          min-height: 100%;
          width: auto;
          height: auto;
          z-index: -100;
          background-color:#fff;
          background:url(content/the_wall_pic.png) no-repeat;
          background-size: cover;
          background-position: center center;
        }

        @media only screen and (min-width: 1111px) {
          .container {
            width: 100%;
          }
        }

      </style>

</head>


<body>

      <!--video background-->
      <video autoplay loop muted poster="content/the_wall.png" id="bgvid"
          <source src="content/the_wall.mp4" type="video/mp4">
      </video>
      <!--video background-->


  <?php
    if(isset($_SESSION['errors']))
    {
      foreach($_SESSION['errors'] as $error)
      {
        echo '<div id="error">'.$error.'</div><br>';
      }
      unset($_SESSION['errors']);
    }

    if(isset($_SESSION['success']))
    {
      echo $_SESSION['success'];
    }
      unset($_SESSION['success']);
  ?>

<div class="container">
    <div class="row">
        <div class="twelve columns">
          <h2> Login and Registration </h2>
          <button class="button-primary"><a href="logout.php"> Reset </a></button>
      </div>
    </div>

  <div class="row">
    <div class="three columns">
      <div class="register" id="login">
        <form action="process.php" method="post">
          <input type="hidden" name="action" value="register">
          <label for="first_name">First Name:</label>
            <input type="text" name="first_name">
          <label for="last_name">Last Name:</label>
            <input type="text" name="last_name">
          <label for="email">Email:</label>
            <input type="text" name="email">
          <label for="password">Password:</label>
            <input type="password" name="password">
          <label for="confirm_password">Password Confirmation:</label>
            <input type="password" name="confirm_password"><br>
          <input class="button-primary" type="submit" value="Register">
        </form>
      </div>
    </div>
    <div class="six columns">
      <div class="login" id="login">
        <form action="process.php" method="post">
          <input type="hidden" name="action" value="login">
          <label for="email">Email: </label>
            <input type="text" name="email">
          <label for="password">Password: </label>
            <input type="password" name="password"><br>
          <input class="button-primary" type="submit" value="login">
        </form>
      </div>
   </div>   

  </div>
</div>




</body>
</html>