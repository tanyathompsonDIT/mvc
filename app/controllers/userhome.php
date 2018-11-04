<?php

class UserHome extends Controller
{
    protected $user;
    
    public function __construct()
    {
        // Get the User model 
        $this->user = $this->model('User');
    }

    // Triggered if the userhome/index route has been requested
    public function index($root)
    {
        // Check if the user is logged in
        $user = $this->user;
        $messages = [];
        if ($this->chkIsLoggedIn($user))
        {
            // Displays a message if required (e.g., on successful logins)
            if (isset($_SESSION['sysMessage']))
            {
                $messages['system'] = $_SESSION['sysMessage'];
            }
            unset($_SESSION['sysMessage']);
        }

        // Set the data parameters required for the view
        $data = array(
            'root' => $root, 
            'title' => 'Home', 
            'name' => $user->name, 
            'isLoggedIn' => $user->isLoggedIn,
            'messages' => $messages
        );

        // Checks if the user is logged in
        if ($user->isLoggedIn)
        {
            // Shows the 'user_home/index' view, if the user is logged in, passing any data parameters required
            $this->view('user_home/index', $data);
            exit;
        }
        else
        {
            // Redirects the browser to the home page, if the user is not logged in
            $url = '../../public/home/';
            header('Location: ' . $url);
            exit();            
        }
    }
}
