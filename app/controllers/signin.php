<?php

class SignIn extends Controller
{
    protected $user;
    protected $root;
    protected $title = '';
    protected $messages = [];
    
    public function __construct()
    {
        // Get the User model 
        $this->user = $this->model('User');
    }

    // Triggered if the signin/index route has been requested
    public function index($root, $name =  '', $otherName = '')
    {
        $this->root = $root;
        $this->title = 'Sign In';
        $user = $this->user;
    
        // Check if the Sign In button has been clicked
        if (isset($_POST['action']) && $_POST['action'] === 'Sign In')
        {
            // Load the script with helper functions, i.e., to get the sanitise function
            require_once '../app/helper.php';

            // Call the trySignIn method
            if ($this->trySignIn())
            {
                // Redirect the browser to the user_home path
                $url = '../../public/userhome/';
                header('Location: ' . $url);
                exit();
            }
        }

        // Set the data parameters required for the view
        $data = array(
            'root' => $this->root,
            'title' => $this->title, 
            'isLoggedIn' => $user->isLoggedIn,
            'messages' => $this->messages
        );        

        // Show the 'login/index' view passing any data parameters required
        $this->view('login/index', $data);
        exit;
    }

    protected function trySignIn() 
    {
        // Check for a valid email and password
        $this->messages = [];
        if (empty($_POST["email"])) {
            $this->messages['email'] = 'An email must be entered.';
        }
        else
        {
            $email = sanitise($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $this->messages['email'] = 'The email format is invalid.';
        }

        if (empty($_POST["password"])) {
            $this->messages['password'] = 'A valid password must be entered, with at least 8 characters consisting of at least 1 upper, 1 lower, and 1 number';
        }
        else
        {
            $passwordPattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,16}$/";
            // (?=.*\d): At least a digit
            // (?=.*[a-z]): At least a lower case letter
            // (?=.*[A-Z]): At least an upper case letter
            // (?=.*[^a-zA-Z0-9]): At least a character except a-zA-Z0-9
            // .{8,16} between 8 to 16 characters
            // $: anchored to the end of the string
    
            $password = sanitise($_POST["password"]);
            if (!preg_match($passwordPattern, $password))
            {
                $this->messages['password'] = 'A valid password must be entered, with at least 8 characters consisting of at least 1 upper, 1 lower, and 1 number';
            }
        }

        // Access the database to see if matching user credentials are found
        $user = $this->user;
        if (empty($this->messages))
        {
            if ($user->loginUser($email, $password))
            {
                // Regenerate session id for user and set the necessary session variables
                session_regenerate_id();
                $_SESSION['userId'] = $user->id;
                $_SESSION['userName'] = $user->name;

                $this->messages['system'] = '<div class="alert alert-success form-control-alert">' . $user->errorMessage . '</div>';
                return true;
            }
            else
            {
                // Clear the necessary session variables
                unset($_SESSION['userId']);
                unset($_SESSION['userName']);
                $this->messages['main'] = $user->errorMessage;
            }
        }
        $this->user = $user;
        return false;
    }
}