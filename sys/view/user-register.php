<?php

$u = ""; $p = ""; $pa = "";
$error_message = "";

if ( Input::exists('post') && Input::get('registration_attempt') != "" ){

  if (  Token::is_valid( Input::get('input_token') ) ){
    $username = new Input( Input::get('username') );
    $password = new Input( Input::get('password') );
    $password_again = Input::get('password_again');

    if ( $username == '' ){
      $uerr = 1;
      $error_message = "Username cannot be empty";
    }

    if ( $password == '' ){
      $perr = 1;
      $error_message .= ( $error_message != '' ) ? '<br>' : '';
      $error_message .= "Password cannot be empty";
    }

    if ( $username != '' && $password != '' ){

      $uerr = ( $username->is_valid_username() ) ? 0 : 1;
      $perr = ( $password->is_valid_password() ) ? 0 : 1;
      $pmm = ( !$password->matches_password( $password_again ) && !$perr ) ? 1 : 0;

      if ( $uerr ){
        $error_message = "Username format error.<br>Use letters and numbers and the underscore (_) only";
      }

      if ( $perr ){
        $error_message .= ( $error_message != '' ) ? '<br>' : '';
        $error_message .= "<b>Password format error.</b><br>Use at least 1 of each of these : Uppercase letter, Lowercase letter, Number<br>Minimum length in 8 characters";
      }

      if ( $pmm ){
        $error_message .= ( $error_message != '' ) ? '<br>' : '';
        $error_message .= "Passwords entered do not match";
      }

      if ( !$uerr && !$perr && !$pmm ){
        if ( $username->is_unique_username() ){

          $user = User::register( $username, $password );
          if ( $user ){
            Redirect::to( 'chats/' );
          } else {
            $error_message = "An error occured. Please try again shortly";
          }

        } else {
          $uerr = 1;
          $error_message = "Username already exists in database.";
        }

      }
    }

  } else {
    Redirect::to( 'user/register/errna/' );
  }

}

if ( $get_param_3 == 'errna' ){
  $error_message = "Action Not Allowed!!!";
}

?>

<main class="form-signin text-center">
  <form method="post" action="<?php echo SITE_URL; ?>user/register/" >
    <img class="mb-4" src="<?php echo asset('logo/512x512/path'); ?>" alt="" width="60" height="60">
    <h1 class="h4 mb-3 fw-normal">Coursera Cybersecurity Capstone Chat App</h1>
    <br>
    <h1 class="h5 mb-3 fw-normal">Register to start chatting</h1>

    <div class="form-floating">
      <input
        type="text"
        name="username" 
        value="<?php echo ( Input::get('username') != "" ) ? Input::get('username') : Debug::registration_form_autofill("peter44"); ?>" 
        class="form-control <?php echo ( $uerr ) ? 'is-invalid' : ''; ?>"
        id="floatingInput" 
        placeholder="Username"
        required
        minlength="5"
        maxlength="64"
      >
      <label for="floatingInput">Username</label>
    </div>
    <div class="form-floating">
      <input 
        type="password" 
        name="password" 
        value="<?php echo ( Input::get('password') != "" ) ? Input::get('password') : Debug::registration_form_autofill("Password123"); ?>" 
        class="form-control <?php echo ( $perr ) ? 'is-invalid' : ''; ?>" 
        id="floatingPassword" 
        placeholder="Password"
        required
        minlength="8"
        maxlength="64"
      >
      <label for="floatingPassword">Password</label>
    </div>
    <div class="form-floating mb-3">
      <input type="password" 
        name="password_again" 
        value="<?php echo ( Input::get('password_again') != "" ) ? Input::get('password_again') : Debug::registration_form_autofill("Password123"); ?>" 
        class="form-control <?php echo ( $pmm ) ? 'is-invalid' : ''; ?>"
        id="floatingPasswordLast" 
        placeholder="Password Again"
        required
        minlength="8"
        maxlength="64"
      >
      <label for="floatingPasswordLast">Password Again</label>
    </div>

    <?php if ( $error_message != '' ) { ?>
      
      <p class="mb-3 invalid-feedback" style="display:block"><?php echo $error_message; ?></p>
 
     <?php } ?>

 
     <input type="hidden" name="input_token" value="<?php echo Token::generate(); ?>" />

    <button class="w-100 btn btn-lg btn-success" name="registration_attempt" value="1" type="submit">Register</button>
    <br>
    <br>

    <div class="btn-group w-100 mr-auto">
        <a class="btn w-100 btn-md btn-outline-secondary" href="#">Reset Password</a>
        <a class="btn w-100 btn-md btn-primary" href="<?php echo SITE_URL; ?>user/login/">Or Login</a>
    </div>
    
    <p class="mt-5 mb-3 text-muted">&copy; GoodhopeKD - 2022</p>
  </form>
</main>