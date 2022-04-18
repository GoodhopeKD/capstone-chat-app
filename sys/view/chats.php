<?php $user = Session::$logged_in_user; ?>

<nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark" aria-label="Top Navbar">
  <div class="container">
    <a class="navbar-brand" href="#"><img width="24" height="24" class="d-inline-block align-text-top" src="<?php echo asset('logo/512x512/path'); ?>" alt=""> Chat App</a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo ($get_param_2 == "chats") ? "#" : SITE_URL . "chats/"; ?>">Chats</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="<?php echo ($get_param_2 == "new") ? "#" : SITE_URL . "chat/new/"; ?>">New Chat</a>
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
    <h6 class="border-bottom pb-2 mb-0">My chats</h6>

    <?php foreach ($user->chats as $chat ) { $chat->load_messages(); $fill = rand_color(); ?>

      <div class="d-flex text-muted pt-3 border-bottom">
        <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="<?php echo $fill; ?>"/><text x="50%" y="50%" fill="<?php echo $fill; ?>" dy=".3em">32x32</text></svg>

        <p class="pb-3 mb-0 small lh-sm ">
          <a href="<?php echo SITE_URL; ?>chat/<?php echo $chat->other_participant->get_username(); ?>/" class="d-flex text-gray-dark"><strong>@<?php echo $chat->other_participant->get_username(); ?></strong></a>
          <small><i><?php echo $chat->last_message->sender->get_username() . ' ' . $chat->last_message->get_sent_datetime()->get_display_datetime(); ?> </i>:</small> <?php echo $chat->last_message->get_exerpt(); ?>
        </p>
      </div>

    <?php } ?>

    <h6 class=" h6 mt-3">
      <a href="<?php echo SITE_URL; ?>chat/new/">Start new chat</a>
    </h6>
  </div>
  </div>
</main>