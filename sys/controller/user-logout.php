<?php

Session::$logged_in_user->logout();
Redirect::to('user/login');