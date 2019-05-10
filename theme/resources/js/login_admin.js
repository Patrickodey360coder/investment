
var _user;
var _key;
var _home;

function begin_login(home)
{ 
  _home=home;
  $("#denied").hide(); 
  $("#blocked").hide(); 
  $("#connection").hide(); 
  $("#loading").hide(); 
  
  if( $("#email").val().trim()=="" || $("#key").val().trim()=="" )
    $("#denied").show();  
  else
    connect($("#email").val().trim(), $("#key").val().trim());
    
}


function connect(user,key)
{
     _user=user; _key=key;
     $("#login_button").hide();
   
     $("#loading").show();  
      
     $.ajax({
            type        : 'POST',
            url         : 'admin/login',
            data        : { process: 'request' },
            dataType    : 'json', 
            encode      : true
        })
      
         .done(function(data) {
             if(data.approved)
               verify(data.token);
            else
             {
                stop_process();
                $("#loading").hide();  
               $("#blocked").show();  
             }
          })
            
            
      .fail(function() {
             stop_process();
            $("#loading").hide();  
             $("#connection").show(); 
      });
   

}



function verify(token)
{
       $.ajax({
            type        : 'POST',
            url         : 'admin/login',
            data        : { process: 'verify', id: token, user: _user },
            dataType    : 'json', 
            encode      : true
        })
      
         .done(function(data) {
             if(data.approved)
             {
                if(data.verified)
                  encrypt(token,data.process);
                else
                {
                     stop_process();
                     $("#loading").hide();  
                     $("#denied").show(); 
                }
             }
             else
             {
                stop_process();
                 $("#loading").hide();  
               $("#blocked").show(); 
             }
          })
            
            
      .fail(function() {
             stop_process();
              $("#loading").hide();  
               $("#connection").show(); 
       });
    
    
}


function encrypt(token,form)
{

    var p=    sha512( sha512(token) + sha512(  sha512(_key) + sha512(form)  )   );
      $.ajax({
            type        : 'POST',
            url         : 'admin/login',
            data        : { process: 'authorize', key:p, user:_user },
            dataType    : 'json', 
            encode      : true
        })
      
         .done(function(data) {
             if(data.approved)
             {
                if(data.accepted)
                {
                    $("#loading").hide();  
                    $("#done").show();
                   window.location=_home;
                }
                else
                {
                     stop_process();
                      $("#loading").hide();  
               $("#denied").show();
                    
                }
             }
             else
             {
                stop_process();
                  $("#loading").hide();  
               $("#blocked").show();
             }
          })
            
            
      .fail(function() {
             stop_process();
               $("#loading").hide();  
               $("#connection").show();
       });
    
    
}

 



function stop_process()
{
     $("#login_button").show();
}