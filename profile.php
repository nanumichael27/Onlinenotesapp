<?php
session_start();
if(!isset($_SESSION["user_id"])){
    header("location: index.php");
    
}

include('connection.php');

$user_id = $_SESSION['user_id'];


//this is getting to spaghetti coded... we just want to get the new email and username loaded
//get username and email
$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($link, $sql);

$count = mysqli_num_rows($result);

if($count == 1){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $username = $row['username'];
    $email = $row['email'];
}else{
    echo"There was an error retrieving the username and email from the database";
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Profile</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
      
      <link href="styling.css" rel="stylesheet">

      <link href="https://googleapis.com/css?family=arvo" rel="stylesheet" type="text/css">
      
      <style>
          #container{
              margin-top: 100px;
          }
          
          #allNotes, #done ,#notepad{
              display: none;
          } 
          
          .buttons{
              margin-bottom: 20px;
          }
          
          textarea{
              width: 100%;
              max-width: 100%;
              font-size: 16px;
              line-height: 1.5em;
              border-left: 20px solid;
              border-color: #CA3DD9;
              color: #CA3DD9;
              background-color: #FBEFFF;
              padding: 10px;
              
          }
          
          tr{
              cursor: pointer;
          }
          
                    
          table{

              background: linear-gradient(#ffffff, #eceae7);
              
          }
      </style>
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
                  
                      <li class="active"><a href="#">Profile</a></li>
                      <li><a href="#">Help</a></li>
                      <li><a href="#">Contact us</a></li>
                      <li><a href="mainpageloggedin.php">My Notes</a></li>
                      
                  </ul>
                  <ul class="navbar-nav nav navbar-right">
                  
                      <li><a href="#" >Logged in as <b><?php echo $username; ?></b></a></li>
                      <li><a href="index.php?logout=1" >Log out</a></li>
                  </ul>
              </div>
          </div>
      </nav>
<!--Container-->
      
      <div class="container" id="container">
          <div class="row">
            <div class="col-md-offset-3 col-md-6">
             
                <h2>General Account Settings</h2>
                
                <div class="table-responsive">
                
                    <table class="table table-hover table-condensed table-bordered">
                        <tr data-target="#updateusername" data-toggle="modal">
                            <td>Username:</td>
                            <td><?php echo $username ?></td>
                        </tr>
                        <tr data-target="#updateemail" data-toggle="modal">
                            <td>Email:</td>
                            <td><?php echo $email; ?></td>
                        </tr>
                        <tr data-target="#updatepassword" data-toggle="modal">
                            <td>Password:</td>
                            <td>hidden</td>
                        </tr>
                    </table>
                </div>
            </div>
          </div>
      </div>
      
<!--Update username-->
      <form method="post" id="updateusernameform">
      
        <div class="modal" id="updateusername" role="dialog" aria-labelledby="#myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 id="myModalLabel">Edit Username:</h4>
                    </div>
                    <div class="modal-body">
                        
                        <!--updateusername Message from the php file-->
                        <div id="updateusernamemessage">
                        </div>
                        
                       
                    <div class="form-group">
                       <label for="username">Username</label>
                        <input class="form-control" type="text" name="username" placeholder="New Username" maxlength="50" id="username" value="<?php echo $username; ?>">
                   </div>
             
                   
                      
               
                    </div>
                    <div class="modal-footer">
                        <input class="btn green" type="submit" value="submit" name="updatepasswordmessage">
                        
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                       
                    </div>
                    
                </div>
            </div>
        </div>
      </form>
      
<!--Update email-->
      <form method="post" id="updateemailform">
      
        <div class="modal" id="updateemail" role="dialog" aria-labelledby="#myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 id="myModalLabel">Enter new Email:</h4>
                    </div>
                    <div class="modal-body">
                        
                        <!--update email Message from the php file-->
                        <div id="updateemailmessage">
                        </div>
                        
                       
                    <div class="form-group">
                       <label for="email">Email:</label>
                        <input class="form-control" type="email" name="email" placeholder="New Email" maxlength="50" id="email" value="<?php echo $email; ?>">
                   </div>
             
                   
                      
               
                    </div>
                    <div class="modal-footer">
                        <input class="btn green" type="submit" value="submit" name="updateemail">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                       
                    </div>
                    
                </div>
            </div>
        </div>
      </form>
<!--Update password-->
      <form method="post" id="updatepasswordform">
      
        <div class="modal" id="updatepassword" role="dialog" aria-labelledby="#myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 id="myModalLabel">Enter Current and new password:</h4>
                    </div>
                    <div class="modal-body">
                        
                        <!--updatepassword Message from the php file-->
                        <div id="updatepasswordmessage">
                            
                        </div>
                        
                       
                    <div class="form-group">
                       <label class="sr-only" for="currentpassword">Current password</label>
                        <input class="form-control" type="password" name="currentpassword" placeholder="Your current password" maxlength="30" id="currentpassword">
                   </div>
                   <div class="form-group">
                       <label class="sr-only" for="password">Choose a password:</label>
                        <input class="form-control" type="password" name="password" placeholder="Choose a password" maxlength="30" id="password">
                   </div>
                   <div class="form-group">
                       <label class="sr-only" for="password2">Confirm password</label>
                        <input class="form-control" type="password" name="password2" placeholder="Confirm password" maxlength="30" id="password2">
                   </div>
             
                   
                      
               
                    </div>
                    <div class="modal-footer">
                        <input class="btn green" type="submit" value="submit" name="updatepassword">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                       
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
      
      <script src="profile.js"></script>
  </body>
</html>