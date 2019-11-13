<?php
//start session
session_start();

//establish a connection with the server
include ("connection.php");

//logout
include("logout.php");

//remember me
include ("rememberme.php");

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Online Notes</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

      <link href="https://googleapis.com/css?family=arvo" rel="stylesheet" type="text/css">
      
      <link href="styling.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
<!--Navigation Bar-->
      <nav role="navigation" class="navbar navbar-custom navbar-fixed-top">
      
          <div class="container-fluid">
          
              <div class="navbar-header">
              
                  <a class="navbar-brand">Online Notes</a>
                  <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
                      
                  <span class="sr-only">Toggle navigation</span>
                      
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  </button>
              </div>
              <div class="navbar-collapse collapse" id="navbarCollapse">
              
                  <ul class="nav navbar-nav">
                  
                      <li class="active"><a href="#">Home</a></li>
                      <li><a href="#">Help</a></li>
                      <li><a href="#">Contact us</a></li>
                      
                  </ul>
                  <ul class="navbar-nav nav navbar-right">
                  
                      <li><a href="#loginModal" data-toggle="modal">Login</a></li>
                  </ul>
              </div>
          </div>
      </nav>
<!--Jumbotron with sign up Button-->
      <div class="jumbotron" id="myContainer">
          <h1>Online Notes App</h1>
          <p>Your Notes with you wherever you go.</p>
          <p>Easy to use, protects all your notes!</p>
          <button type="button" class="btn btn-lg green signup" data-target="#signupModal" data-toggle="modal">Sign up-it's free</button>
      </div>
      
<!--Login form-->
      <form method="post" id="loginform">
      
        <div class="modal" id="loginModal" role="dialog" aria-labelledby="#myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 id="myModalLabel">Login:</h4>
                    </div>
                    <div class="modal-body">
                        
                        <!--login Message from the php file-->
                        <div id="loginmessage">
                        </div>
                        
                       
                    <div class="form-group">
                       <label class="sr-only" for="loginemail">Email</label>
                        <input class="form-control" type="email" name="loginemail" placeholder="Email" maxlength="50" id="loginemail">
                   </div>
                    <div class="form-group">
                       <label class="sr-only" for="loginpassword">Password</label>
                        <input class="form-control" type="password" name="loginpassword" placeholder="Password" maxlength="30" id="loginpassword">
                    </div>
                        
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="rememberme" id="rememberme">
                            Remember me
                        </label>
                        <a class="pull-right" style="cursor: pointer" data-dismiss="modal" data-target="#forgotpasswordModal" data-toggle="modal">
                            Forgot password?
                        </a>
                    </div>
                      
               
                    </div>
                    <div class="modal-footer">
                        <input class="btn green" type="submit" value="Login" name="login">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">Register</button>
                    </div>
                    
                </div>
            </div>
        </div>
      </form>
      
<!--Sign up form-->
      <form method="post" id="signupform">
      
        <div class="modal" id="signupModal" role="dialog" aria-labelledby="#myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 id="myModalLabel">Sign up today and start using our online notes app! with 1Year free storage.</h4>
                    </div>
                    <div class="modal-body">
                        
                        <!--Signup Message from the php file-->
                        <div id="signupmessage">
                        </div>
                        
                       <div class="form-group">
                       <label class="sr-only" for="username">Username</label>
                        <input class="form-control" type="text" name="username" placeholder="Username" maxlength="30" id="username">
                    </div>
                    <div class="form-group">
                       <label class="sr-only" for="email">Email</label>
                        <input class="form-control" type="email" name="email" placeholder="Email Address" maxlength="50" id="email">
                   </div>
                    <div class="form-group">
                       <label class="sr-only" for="password">Password</label>
                        <input class="form-control" type="password" name="password" placeholder="Choose a password" maxlength="30" id="password">
                    </div>
                    <div class="form-group">
                       <label class="sr-only" for="password2">Confirm Password</label>
                        <input class="form-control" type="password" name="password2" placeholder="Confirm password" maxlength="30" id="password2">
                    </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn green" type="submit" value="Sign up" name="signup">
                        
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        
                    </div>
                    
                </div>
            </div>
        </div>
      </form>
      
<!--Forgot password form-->
  <form method="post" id="forgotpasswordform">

    <div class="modal" id="forgotpasswordModal" role="dialog" aria-labelledby="#myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">&times;</button>
                    <h4 id="myModalLabel">Forgot password? Enter your email address:</h4>
                </div>
                <div class="modal-body">

                    <!--forgot password Message from the php file-->
                    <div id="forgotpasswordmessage">
                    </div>


                <div class="form-group">
                   <label class="sr-only" for="forgotemail">Email</label>
                    <input class="form-control" type="email" name="forgotemail" placeholder="Email" maxlength="50" id="forgotemail">
               </div>


                </div>
                <div class="modal-footer">
                    <input class="btn green" type="submit" value="submit" name="forgotpassword">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">Register</button>
                </div>

            </div>
        </div>
    </div>
  </form>
<!--Footer-->
<?php
      include "footer.php";
      
      ?>
      
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
    <script src="jquery-3.3.1.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
      <script src="index.js"></script>
  </body>
</html>