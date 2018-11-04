<?php

class Home extends Controller
{
    protected $user;
    
    public function __construct()
    {
        // Get the User model 
        $this->user = $this->model('User');
    }

    // Triggered if the home/index route has been requested
    public function index($root)
    {
        // Check if the user is logged in and gets the relevant details
        $user = $this->user;
        $this->chkIsLoggedIn($user);

        // Set the data parameters required for the view
        $data = array(
            'root' => $root, 
            'title' => 'Home', 
            'name' => $user->name, 
            'isLoggedIn' => $user->isLoggedIn
        );

        // Show the 'home/index' view passing any data parameters required
        $this->view('home/index', $data);
    }
}