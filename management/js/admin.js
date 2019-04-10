$(document).ready(function(){


     //updateForm('Organization');
     //updateForm('Consortium');
     //updateForm('DocumentType');
     //updateForm('DocumentNoteType');
     //updateExpressionTypeList();
     //updateForm('SignatureType');
     //updateForm('Status');
     //updateQualifierList();



     updateUserList();
     buttonOn();



     $(".updateUserList").click(function () {
         updateUserList();
         buttonOn();


     });

     $(".updateTable").click(function () {
        getBtnTitle($(this));
         updateTable($(this).attr("id"));
         buttonOff();


     });

});


/*Auto-Select the first button in side menu on arrival in the admin section */
function buttonOff(){
  $("#PreSelectedButton").css({'background': '#F2F5F7', 'font-weight':'normal'});
};

function buttonOn(){
  $("#PreSelectedButton").css({'background': '#EAEDEF', 'font-weight':'bold'});
};

function getBtnTitle(id){

  menuTitle = $(id).text();

};



function updateTable(className){

      $.ajax({
         type:       "GET",
         url:        "ajax_htmldata.php",
         cache:      false,
         data:       "action=getAdminList&className=" + className + "&menuTitle=" + menuTitle,
         success:    function(html) { $('#div_AdminContent').html(html);
           tb_reinit();
         }
     });




}


function updateUserList(){

      $.ajax({
         type:       "GET",
         url:        "ajax_htmldata.php",
         cache:      false,
         data:       "action=getAdminUserList",
         success:    function(html) { $('#div_AdminContent').html(html);
           tb_reinit();
         }
     });


}


/*
 function updateExpressionTypeList(){

       $.ajax({
          type:       "GET",
          url:        "ajax_htmldata.php",
          cache:      false,
          data:       "action=getExpressionTypeList",
          success:    function(html) { $('#div_ExpressionType').html(html);
           tb_reinit();
          }
      });

 }
*/

/*
  function updateQualifierList(){

        $.ajax({
           type:       "GET",
           url:        "ajax_htmldata.php",
           cache:      false,
           data:       "action=getQualifierList",
           success:    function(html) { $('#div_Qualifier').html(html);
             tb_reinit();
           }
       });

 }
*/
function addData(tableName){

      if ($('#new' + tableName).val()) {
         $('#span_' + tableName + "_response").html("<img src='images/circle.gif'>&nbsp;&nbsp;" + _("Processing..."));
       $.ajax({
        type:       "POST",
        url:        "ajax_processing.php?action=checkForDuplicates",
        cache:      false,
        data:       { shortName: $('#new' + tableName).val(), newType: tableName },
        success:    function(data) {
               if (data == "1") {
                    $.ajax({
                 type:       "POST",
                 url:        "ajax_processing.php?action=addData",
                 cache:      false,
                 data:       { tableName: tableName, shortName: $('#new' + tableName).val() },
                 success:    function(html) {
                 $('#span_' + tableName + "_response").html(html);

                 // close the span in 3 secs
                 setTimeout("emptyResponse('" + tableName + "');",3000);

                 showAdd(tableName);
                 updateTable(tableName);

                 }
                   });
               } else {
                 var displayName = tableName;
                 if (tableName == 'Consortium') {
                   displayName = 'Category';
                 }
                 $('#span_' + tableName + "_response").html(_("That ") + displayName + _(" is already in use."));
               }
             }
       });
 }

}

function updateData(tableName, updateID){
   if(validateUpdateData() === true){
       $.ajax({
           type:       "POST",
           url:        "ajax_processing.php?action=updateData",
           cache:      false,
           data:       { tableName: tableName, updateID: updateID, shortName: $('#updateVal').val() },
           success:    function(html) {
               updateForm(tableName);
               window.parent.tb_remove();
           }
       });
   }
}

// Validate updateData
function validateUpdateData(){
   if($("#updateVal").val() == ''){
       $("#span_errors").html('Error - Please enter a value');
       $("#updateVal").focus();
       return false;
   }else{
       return true;
   }
}

function submitUserData(orgLoginID){
   if(validateUserForm() === true){
       $.ajax({
           type:       "POST",
           url:        "ajax_processing.php?action=submitUserData",
           cache:      false,
           data:       { orgLoginID: orgLoginID, loginID: $('#loginID').val(), firstName: $('#firstName').val(), lastName: $('#lastName').val(), privilegeID: $('#privilegeID').val(), emailAddressForTermsTool: $('#emailAddressForTermsTool').val() },
           success:    function(html) {
               updateUserList();
               window.parent.tb_remove();
           }
       });
   }
}

// Validate user form
function validateUserForm() {
   if($("#loginID").val() == ''){
       $("#span_errors").html('Error - Please add a Login ID for the user');
       $("#loginID").focus();
       return false;
   }else{
       return true;
   }
}

function submitExpressionType(){
 $.ajax({
         type:       "POST",
         url:        "ajax_processing.php?action=submitExpressionType",
         cache:      false,
         data:       { expressionTypeID: $('#expressionTypeID').val(), shortName: $('#shortName').val(), noteType: $('#noteType').val() },
         success:    function(html) {
         updateExpressionTypeList();
         window.parent.tb_remove();
         }
      });

}





function submitQualifier(){
 $("#submitQualifier").attr("disabled","disabled");
 $.ajax({
         type:       "POST",
         url:        "ajax_processing.php?action=submitQualifier",
         cache:      false,
         data:       { qualifierID: $('#qualifierID').val(), shortName: $('#shortName').val(), expressionTypeID: $('#expressionTypeID').val() },
         success:    function(html) {
         updateQualifierList();
         window.parent.tb_remove();
         }
      });

}

function deleteData(tableName, deleteID){

 if (confirm(_("Do you really want to delete this data?")) == true) {

        $('#span_' + tableName + "_response").html("<img src = 'images/circle.gif'>&nbsp;&nbsp;" + _("Processing..."));
        $.ajax({
     type:       "GET",
     url:        "ajax_processing.php",
     cache:      false,
     data:       "action=deleteData&tableName=" + tableName + "&deleteID=" + deleteID,
     success:    function(html) {
     $('#span_' + tableName + "_response").html(html);

     // close the span in 3 secs
     setTimeout("emptyResponse('" + tableName + "');",5000);

     updateForm(tableName);
     tb_reinit();
     }
       });

 }
}


function deleteUser(loginID){

 if (confirm(_("Do you really want to delete this user?")) == true) {

        $('#span_User_response').html("<img src = 'images/circle.gif'>&nbsp;&nbsp;" + _("Processing..."));
        $.ajax({
     type:       "GET",
     url:        "ajax_processing.php",
     cache:      false,
     data:       "action=deleteUser&loginID=" + loginID,
     success:    function(html) {
     $('#span_User_response').html(html);

     // close the span in 5 secs
     setTimeout("emptyResponse('User');",5000);

     updateUserList();
     tb_reinit();
     }
       });

 }
}



function deleteExpressionType(deleteID){

 if (confirm(_("Do you really want to delete this expression type?  Any associated Qualifiers will be deleted as well.")) == true) {

        $("#span_ExpressionType_response").html("<img src='images/circle.gif'>&nbsp;&nbsp;" + _("Processing..."));
        $.ajax({
     type:       "GET",
     url:        "ajax_processing.php",
     cache:      false,
     data:       "action=deleteExpressionType&expressionTypeID=" + deleteID,
     success:    function(html) {
     $("#span_ExpressionType_response").html(html);

     // close the span in 5 secs
     setTimeout("emptyResponse('ExpressionType');",5000);

     updateExpressionTypeList();
     updateQualifierList();
     tb_reinit();
     }
       });

 }
}



function deleteQualifier(deleteID){

 if (confirm(_("Do you really want to delete this data?")) == true) {

        $("#span_Qualifier_response").html("<img src = 'images/circle.gif'>&nbsp;&nbsp;" + _("Processing..."));
        $.ajax({
     type:       "GET",
     url:        "ajax_processing.php",
     cache:      false,
     data:       "action=deleteData&tableName=Qualifier&deleteID=" + deleteID,
     success:    function(html) {
     $("#span_Qualifier_response").html(html);

     // close the span in 5 secs
     setTimeout("emptyResponse('Qualifier');",5000);

     updateQualifierList();
     tb_reinit();
     }
       });

 }
}


function showAdd(tableName){
      $('#span_new' + tableName).html("<input type='text' name='new" + tableName + "' id='new" + tableName + "' class='adminAddInput' />  <a href='javascript:addData(\"" + tableName + "\");'>"+_("add") + "</a>");

      //attach enter key event to new input and call add data when hit
      $('#new' + tableName).keyup(function(e) {

              if(e.keyCode == 13) {
                  addData(tableName);
              }
       });

}

/*
function emptyResponse(tableName){
 $('#span_' + tableName + "_response").html("");
}
*/
