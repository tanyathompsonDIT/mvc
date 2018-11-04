<?php

class SignOut extends Controller
{
    protected $user;
    
    public function __construct()
    {
        // Get the User model 
        $this->user = $this->model('User');
    }

    public function index($root)
    {
        $user = $this->user;
        $messages = [];
        $wasLoggedIn = false;
        if ($this->chkIsLoggedIn($user))
        {
            // Clear relevant session variables on logging out the user
            $wasLoggedIn = true;
            unset($_SESSION['userId']);
            unset($_SESSION['userName']);

            // Notify user whether or not successfully logged out
            if (!$this->chkIsLoggedIn($user))
            {
                $messages['system'] = '<div class="alert alert-success form-control-alert">You have been successfully signed out.</div>';
            }
            else
            {
                $messages['system'] = '<div class="alert alert-danger form-control-alert">You have not been successfully signed out. Please try again.</div>';
            }                
        }

        // Set the data parameters required for the view
        $data = array(
            'root' => $root, 
            'title' => 'Home', 
            'name' => $user->name, 
            'isLoggedIn' => $user->isLoggedIn,
            'messages' => $messages
        );

        if ($wasLoggedIn)
        {
            // Show the 'home/index' view, passing any data parameters required
            $this->view('home/index', $data);
            exit;
        }
        else
        {
            // Redirect browser to the Home page
            $url = '../../public/home/';
            header('Location: ' . $url);
            exit();            
        }
    }
}
