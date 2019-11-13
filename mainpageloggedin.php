<?php
session_start();
if(!isset($_SESSION["user_id"])){
    header("location: index.php");
    
}



?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>My Notes</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
      
      <link href="styling.css" rel="stylesheet">

      <link href="https://googleapis.com/css?family=arvo" rel="stylesheet" type="text/css">
      
      <style>
          #container{
              margin-top: 120px;
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
          
          .noteheader{
              border: 1px solid grey;
              border-radius: 10px;
              margin-bottom: 10px;
              cursor: pointer;
              padding:  0 10px;
              background: linear-gradient(#ffffff, #eceae7);
          }
          
          .text{
              font-size: 20px;
              overflow: hidden;
              white-space: nowrap;
              text-overflow: ellipsis;
          }
          
          .timetext{
              overflow: hidden;
              white-space: nowrap;
              text-overflow: ellipsis;
          }
          
          .delete{
              display: none;
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
                  
                      <li><a href="profile.php">Profile</a></li>
                      <li><a href="#">Help</a></li>
                      <li><a href="#">Contact us</a></li>
                      <li class="active"><a href="#"><b>My Notes</b></a></li>
                      
                  </ul>
                  <ul class="navbar-nav nav navbar-right">
                  
                      <li><a href="#" >Logged in as <b><?php echo $_SESSION['username']; ?></b></a></li>
                      <li><a href="index.php?logout=1" >Log out</a></li>
                  </ul>
              </div>
          </div>
      </nav>
<!--Container-->
      
      <div class="container" id="container">
          <div class="row">
<!--              Alert Message-->
              <div id="alert" class="alert alert-danger collapse"><a class="close" data-dismiss="alert">&times;</a><p id="alertContent"></p></div>
            <div class="col-md-offset-3 col-md-6">
              
                <div class="buttons">
                    <button id="addNote" type="button" class="btn btn-info btn-lg">Add Note</button>
                    <button id="edit" type="button" class="btn btn-info btn-lg pull-right">Edit</button>
                    <button id="done" type="button" class="btn green btn-lg pull-right">Done</button>
                    <button id="allNotes" type="button" class="btn btn-info btn-lg">All Notes</button>
                </div>
                
                <div id="notepad">
                    <textarea rows="10"></textarea>
                </div>
                <div id="notes" class="notes">
                    <!--Ajax call to the php file-->
                </div>
            </div>
          </div>
      </div>

<!--Footer-->
<?php
      include "footer.php";
      
      ?> 
      
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
    <script src="jquery-3.3.1.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
      <script src="js/mynotes.js">

      
      </script>
  </body>
</html>