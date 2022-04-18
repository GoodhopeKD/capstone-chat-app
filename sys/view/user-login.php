<?php

$uerr = ""; $perr = "";
$error_message = "";

$rand_user = null;

if ( DEBUG_LOGIN_FORM_AUTOFILL ){
  $users = UserMin::get_all();
  $rand_user = count($users) ? $users[array_rand($users)] : null;
}

if ( Input::exists('post') && Input::get('login_attempt') != "" ){

  if (  Token::is_valid( Input::get('input_token') ) ){
    $username = new Input( Input::get('username') );
    $password = new Input( Input::get('password') );

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

      if ( !$uerr && !$perr ){
        $user = User::login( $username, $password );
        if ( $user ){
          Redirect::to( 'chats/' );
        } else {
          $error_message = "Incorrect Username/Password";
        }
      } else {
        $error_message = "Please verify your login details";
      }
    }
  } else {
    Redirect::to( 'user/login/errna/' );
  }
}

if ( $get_param_3 == 'errna' ){
  $error_message = "Action Not Allowed!!!";
}

?>

<main class="form-signin text-center">
  <form method="post" action="<?php echo SITE_URL; ?>user/login/" >
    <img class="mb-4" src="<?php echo asset('logo/512x512/path'); ?>" alt="" width="60" height="60">
    <h1 class="h4 mb-3 fw-normal">Coursera Cybersecurity Capstone Chat App</h1>
    <br>
    <h1 class="h5 mb-3 fw-normal">Login to start chatting</h1>

    <div class="form-floating">
      <input 
        type="text"
        name="username"
        value="<?php echo ( Input::get('username') != "" ) ? Input::get('username') : Debug::login_form_autofill( $rand_user ? $rand_user->get_username() : '' ); ?>"
        class="form-control <?php echo ( $uerr ) ? 'is-invalid' : ''; ?>"
        id="floatingInput" 
        placeholder="Username"
        required
        minlength="5"
        maxlength="64"
        >
      <label for="floatingInput">Username</label>
    </div>
    <div class="form-floating mb-3">
      <input
        type="password"
        name="password"
        value="<?php echo ( Input::get('password') != "" ) ? Input::get('password') : Debug::login_form_autofill("Password123"); ?>"
        class="form-control <?php echo ( $perr ) ? 'is-invalid' : ''; ?>"
        id="floatingPasswordLast"
        placeholder="Password"
        required
        minlength="8"
        maxlength="64"
      >
      <label for="floatingPasswordLast">Password</label>
    </div>

    <?php if ( $error_message != '' ) { ?>
      
     <p class="mb-3 invalid-feedback" style="display:block"><?php echo $error_message; ?></p>

    <?php } ?>

    <input type="hidden" name="input_token" value="<?php echo Token::generate(); ?>" />

    <button class="w-100 btn btn-lg btn-primary" name="login_attempt" value="1" type="submit">Login</button>
    <br>
    <br>

    <div class="btn-group w-100 mr-auto">
        <a class="btn w-100 btn-md btn-outline-secondary" href="#">Reset Password</a>
        <a class="btn w-100 btn-md btn-success" href="<?php echo SITE_URL; ?>user/register/">Or Register</a>
    </div>
    
    <p class="mt-5 mb-3 text-muted">&copy; GoodhopeKD - 2022</p>
  </form>
</main>