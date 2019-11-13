          $(function(){
              
              
              
              //define variables
              var activeNote =0;
              var editMode = false;
              //load notes on page load: Ajax call to loadnotes.php     
                $.ajax({
                    url: "loadnotes.php",
                    success: function(data){
                        $('#notes').html(data);
                        clickonNote();
                        
                        clickonDelete();
                    },
                    error: function(){
                         $('#alertContent').text("There was an error with the ajax call please try again");
                              
                              $("#alert").fadeIn();
                    }
                    
                });
              //add a new note: : Ajax call to createnote.php
              $('#addNote').click(function(){
                  $.ajax({
                      url: "createnote.php",
                      success: function(data){
                          if(data == 'error'){
                             
                              $('#alertContent').text("There was an issue inserting the note in the database");
                              
                              $("#alert").fadeIn();
                              
                             }else{
                                 
                                 //update activeNote to the id of the new note
                                 activeNote = data;
                                 $("textarea").val("");
                                 
                                 //show hide elements
                                 showHide(["#notepad", "#allNotes"], ["#notes", "#addNote", "#edit", "#done"]);
                                 
                                 $("textarea").focus();
                                 
                                 
                             }
                      },
                      error: function(){
                          
                           $('#alertContent').text("There was an error with the ajax call... Please try again later.");
                              
                              $("#alert").fadeIn();
                      }
                      
                  });
                  
                  
              });
              //type note: : Ajax call to updatenote.php
              $('textarea').keyup(function(){
                  
                  //ajax call to the update note file the task of id activenote
                        $.ajax({
                    url: "updatenote.php",
                    type: "POST",
                            //WE NEED TO SEND THE CURRENT NOTE CONTENT AND ID TO THE PHP FILE
                    data: {note: $(this).val(), id: activeNote},
                    success: function(data){
                     if(data == 'error'){
                         $('#alertContent').text("There was an issue updating the note in the database");
                         
                         $("#alert").fadeIn();
                     }
                    },
                    error: function(){
                         $('#alertContent').text("There was an error with the ajax call please try again");
                              
                              $("#alert").fadeIn();
                    }
                    
                });
                  
              });
              
              //Click on all notes button
              $('#allNotes').click(function(){
                  
                     $.ajax({
                    url: "loadnotes.php",
                    success: function(data){
                        $('#notes').html(data);
                        showHide(['#addNote','#edit','#notes'],['#allNotes', '#notepad']);
                        
                        clickonNote();
                        clickonDelete();
                    },
                    error: function(){
                         $('#alertContent').text("There was an error with the ajax call please try again");
                              
                              $("#alert").fadeIn();
                    }
                    
                });
              });
              //click on done after editing: load notes again
              
              $("#done").click(function(){
                  editMode = false;
                  
                  //expand the notes
            $('.noteheader').removeClass("col-xs-7 col-sm-9");
                  // show hide elements
                  showHide(['#edit'],[this, '.delete']);
              });
              //click on edit: fo to the edit mode and show delete  buttons>....
              $('#edit').click(function(){
                  //switch to edit mode
                  editMode = true;
                  
                  //reduce the width of our notes
                  $('.noteheader').addClass("col-xs-7 col-sm-9");

                  showHide(['#done', '.delete'],[this]);
              });
              
              
              
              
              
              //functions
                //for clicking on a note
              function clickonNote(){
                                $('.noteheader').click(function(){
                  
                  if(!editMode){
                      
                      //update activeNote variable
                      activeNote = $(this).attr("id");
                      
                      $('textarea').val($(this).find('.text').text());
                     
                      //showHide elements
                      showHide(["#notepad", "#allNotes"], ["#notes", "#addNote", "#edit", "#done"]);
                      
                     }
                  
              });
                  
              }
                //for clicking delete button
                //show and hide function
              
              function clickonDelete(){
                  $(".delete").click(function(){
                      
                      var deleteButton = $(this);
                      
                      //send ajax call to delete note
                      
                        $.ajax({
                    url: "deletenote.php",
                    type: "POST",
                            //WE NEED TO SEND THE CURRENT NOTE CONTENT AND ID TO THE PHP FILE
                    data: {id: deleteButton.next().attr("id")},
                    success: function(data){
                     if(data == 'error'){
                         $('#alertContent').text("There was an issue deleting the note from the database");
                         
                         $("#alert").fadeIn();
                     }else{
                         //remove containing div
                         deleteButton.parent().remove();
                     }
                    },
                    error: function(){
                         $('#alertContent').text("There was an error with the ajax call please try again");
                              
                              $("#alert").fadeIn();
                    }
                    
                });
                      
                      
                      
                  });
              }

              
              function showHide(array1, array2){
                  
                  for(i=0; i<array1.length; i++){
                      $(array1[i]).show();
                  }
                  for(i=0; i<array2.length; i++){
                      $(array2[i]).hide();
                  }
              }
              
          });