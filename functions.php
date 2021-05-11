<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Register Here</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
<?php if(@$_SESSION['error']): ?>
<div class="alert alert-danger">
<strong>Danger!</strong> <?php echo $_SESSION['error'];?>
</div>
<?php endif; ?>
<form method="post" id="userlogin">
<div class="form-group">
<label for="email">Username:</label>
<input type="text" class="form-control" id="username" name="username">
</div>
<div class="form-group">
<label for="pwd">Password:</label>
<input type="password" class="form-control" id="pwd" name="pass">
<input type="hidden" name="userregister" value="userregister">
</div>
<button type="submit" class="btn btn-danger modal-btn">Register Here</button>
</form>
</div>
</div>
</div>
</div>
<!-- Modal End-->    
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script>
jQuery(document).ready(function($){
if(!$("body").hasClass("logged-in"))
{
$("#myModal").modal("show");
}
$(".modal-btn").click(function(){
var username = $("#username").val();
var pwd = $("#pwd").val();
var a = 0;
var b = 0; 
if(username == "")
{
a = 1;
$("#username").css("border", "1px solid red");
}
else
{
a = 0;
$("#username").removeAttr("style");
}
if(pwd == "")
{
b = 1;
$("#pwd").css("border", "1px solid red");
}
else
{
b = 0;
$("#pwd").removeAttr("style");
}
if(a==0 && b ==0)
{
//alert("pass");
$("#userlogin").submit();
}
else
{
return false;
}
})
});
</script>

 
2. Here is the code for theme’s functions.php file:
add_action('init', 'process_register');
function process_register()
{
  
if($_POST["userregister"])
{
  
  
  $WP_array = array (
        'user_login'    =>  $_POST['username'],
        'user_pass'     =>  $_POST['pass']
    ) ;
  $id = wp_insert_user( $WP_array ) ;
    if ( is_wp_error($id) )
   {
   session_start();
     $_SESSION['error'] = $id->get_error_message();
   }
   else
   {
    wp_update_user( array ('ID' => $id, 'role' => 'subscriber') ) ;
    $creds['user_login'] = $_POST["username"];
    $creds['user_password'] = $_POST["pass"];
    $creds['remember'] = true;
    $user = wp_signon( $creds, false );
      $url = admin_url();
      wp_redirect($url);
      exit();
   }
    
  
}
}
