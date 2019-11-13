//Ajax call for the sign up form
//Once the form is submitted

$("#signupform").submit(function(event){
        //Prevent default php processing
    event.preventDefault();
        //Collect user inputs
    var datatopost = $(this).serializeArray();
    console.log(datatopost);
        //Send them to signup.php using AJAX
    $.ajax({
        url: "signup.php", 
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
            $("#signupmessage").html(data);
            }
            
        },
        
        error: function(){
            $("#signupmessage").html("<div class='alert alert-danger'>There was an error with the ajax call . Please try again later </div>");
        },
        
    });
    
//    $.post({}).done().fail();
});



        //AJAX Call successful: show error or success message
        //AJAX Call fails: show Ajax call error


//Ajax Call for the login form
$("#loginform").submit(function(event){
        //Prevent default php processing
    event.preventDefault();
        //Collect user inputs
    var datatopost = $(this).serializeArray();
    console.log(datatopost);
        //Send them to signup.php using AJAX
    $.ajax({
        url: "login.php", 
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data == "success"){
            $("#loginmessage").html(data);
                window.location = "mainpageloggedin.php";
            }else{
                
                $("#loginmessage").html(data);
            }
            
        },
        
        error: function(){
            $("#signupmessage").html("<div class='alert alert-danger'>There was an error with the ajax call. Please try again later.</div>");
        },
        
    });
    
//    $.post({}).done().fail();
});
//Once the form is submitted
    //prevent default php processing
    //collect user inputs
    //send them to login.php using AJAX 
        //AJAX call successful
            //if php files returns "success": redirect the user to notes page
            //otherwise show error message
        //AJAX Call fails:  show Ajax call error

$("#forgotpasswordform").submit(function(event){
        //Prevent default php processing
    event.preventDefault();
        //Collect user inputs
    var datatopost = $(this).serializeArray();
    console.log(datatopost);
        //Send them to forgotpassword.php using AJAX
    $.ajax({
        url: "forgotpassword.php", 
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data == "success"){
            $("#forgotpasswordmessage").html(data);
           
                
            }else{
                
                $("#forgotpasswordmessage").html(data);
            }
            
        },
        
        error: function(){
            $("#forgotpasswordmessage").html("<div class='alert alert-danger'>There was an error with the ajax call. Please try again later.</div>");
        },
        
    });
    
//    $.post({}).done().fail();
});
//Ajax call for the forgot password form
//Once the form is submitted
    //prevent default php processing
    //collect user inputs
    //send them to login.php using AJAX
        //AJAX Call successful: show error or success message
        //AJAX Call fails: show Ajax Call error