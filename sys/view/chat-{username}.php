<?php

$user = Session::$logged_in_user;

$rand_user = null;
if ( $get_param_2 != "new" ){
  $chat = $user->chat_with_correspondent($get_param_2);
  if (!$chat)
  Redirect::to( 'chats/' );
} else {
  if ( DEBUG_MESSAGE_FORM_AUTOFILL ){
    $users = UserMin::get_all();
    if (($key = array_search(Session::$logged_in_user_min, $users)) !== false) {
      unset($users[$key]);
    }
    $rand_user = count($users) ? $users[array_rand($users)] : null;
  }
}

$u_fill = rand_color();
$r_fill = rand_color();

$uerr = 0; $cerr = 0;
$error_message = "";

if ( Input::exists('post') && Input::get('send_message_attempt') != "" ){

  if (  Token::is_valid( Input::get('input_token') ) ){

    $username = new Input( ( $get_param_2 == "new" ) ? Input::get('username') : $get_param_2 );
    $message_body = new Input( Input::get('message_body') );

    if ( $username == '' ){
      $uerr = 1;
      $error_message = "Username cannot be empty";
    }

    if ( $message_body == '' ){
      $cerr = 1;
      $error_message .= ( $error_message != '' ) ? '<br>' : '';
      $error_message .= "Message cannot be empty";
    }

    if ( $username != '' && $message_body != '' ){

      $uerr = ( $username->is_valid_username() && !$username->is_unique_username() ) ? 0 : 1;

      $message_body->sanitize();

      if ( !$uerr && !$cerr ){

        if ( $username != $user->get_username() ){
          $message = Message::send( $message_body, UserMin::find( $username ) );
          if ( $message ){
            Redirect::to( 'chat/'.$username.'/' );
          } else {
            $error_message = "An error occured";
          }
        } else {
          $error_message = "You cannot send message to yourself";
        }
        
      } else {
        $error_message = "User not found";
      }
    }
  } else {
    Redirect::to( 'chat/'.$get_param_2.'/errna/' );
  }
}

if ( $get_param_3 == 'errna' ){
  $error_message = "Action Not Allowed!!!";
}


?>

<nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark" aria-label="Top Navbar">
  <div class="container">
    <a class="navbar-brand" href="#"><img width="24" height="24" class="d-inline-block align-text-top" src="<?php echo asset('logo/512x512/path'); ?>" alt=""> Chat App</a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="<?php echo ($get_param_1 == "chats") ? "#" : SITE_URL . "chats/"; ?>">Chats</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($get_param_2 == "new") ? "active" : "" ?>" aria-current="page" href="<?php echo ($get_param_2 == "new") ? "#" : SITE_URL . "chat/new/"; ?>">New Chat</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link active dropdown-toggle" href="#" id="dropdown08" data-bs-toggle="dropdown" aria-expanded="false">@<?php echo $user->get_username(); ?></a>
          <ul class="dropdown-menu" aria-labelledby="dropdown08">
              <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>user/logout/">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main class="container">
  <div class="row justify-content-center">
    <div class="my-3 p-3 mt-5 bg-body rounded shadow-sm col-lg-8 col-xl-7">

        <?php if ( $get_param_2 != "new" ){ ?>

          <h6 class="border-bottom pb-2 mb-0">Chat with @<?php echo $chat->other_participant->get_username() ?></h6>

          <?php
            foreach ($chat->messages as $message) {
                if ( !$message->belongs_to_user()){ ?>
                    <div class="d-flex justify-content-end bg-light pt-2 border-bottom">   
                        <div>
                          <p class="mb-0 lh-sm text-end">
                            <i class="text-gray-dark small text-end"><?php echo $message->sender->get_username() . ' ' . $message->get_sent_datetime()->get_display_datetime(); ?></i>
                          </p>
                          <p class="ms-2 pb-2 mb-0 lh-sm">
                            <?php echo $message->get_message_body(); ?>
                          </p>
                        </div>
                        <svg class="bd-placeholder-img flex-shrink-0 mx-2 my-1 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="<?php echo $r_fill; ?>"/><text x="50%" y="50%" fill="<?php echo $r_fill; ?>" dy=".3em">32x32</text></svg>
                    </div>
                <?php } else { ?>
                    <div class="d-flex text-muted pt-2 border-bottom">
                        <svg class="bd-placeholder-img flex-shrink-0 mx-2 my-1 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="<?php echo $u_fill; ?>"/><text x="50%" y="50%" fill="<?php echo $u_fill; ?>" dy=".3em">32x32</text></svg>
                        <p class="pb-2 mb-0 lh-sm ">
                          <i class="d-flex text-gray-dark small"><?php echo $message->sender->get_username() . ' ' . $message->get_sent_datetime()->get_display_datetime(); ?></i>
                          <?php echo $message->get_message_body(); ?>
                        </p>
                    </div>
        <?php } } } ?>

        <form method="post" class="bg-light" action="<?php echo SITE_URL . 'chat/'.$get_param_2.'/'; ?>" >

            <?php if ( $get_param_2 == "new" ){ ?>
                <div class="p-2 pb-1 form-floating">
                  <input 
                    type="text"
                    name="username"
                    value="<?php echo ( Input::get('username') != "" ) ? Input::get('username') : Debug::message_form_autofill( $rand_user ? $rand_user->get_username() : '' ); ?>"
                    class="form-control form-control-sm <?php echo ( $uerr ) ? 'is-invalid' : ''; ?>"
                    id="floatingInput" 
                    placeholder="Username"
                    required
                    minlength="5"
                    maxlength="64"
                    >
                  <label for="floatingInput" class="form-label">Receipient Username</label>
                </div>
            <?php } ?>

            <input type="hidden" name="input_token" value="<?php echo Token::generate(); ?>" />

            <?php if ( $error_message != '' ) { ?>
      
              <p class="p-2 pb-1 mb-0 invalid-feedback" style="display:block"><?php echo $error_message; ?></p>
        
            <?php } ?>

            <div class="p-2">

              <label for="exampleFormControlTextarea1" class="form-label">Your Message</label>
              <div class="input-group">
                  <textarea
                    class="form-control"
                    name="message_body"
                    id="exampleFormControlTextarea1"
                    rows="2"
                    maxlength="4096"
                    required
                  ><?php echo ( Input::get('message_body') != "" ) ? Input::get('message_body') : Debug::message_form_autofill(RandomMessage::generate(1)); ?></textarea>

                  <button class="btn btn-primary" type="submit" name="send_message_attempt" value="1" id="inputGroupFileAddon04">Send</button>
              </div>
            
            </div>
        </form>
    </div>
  </div>
</main>