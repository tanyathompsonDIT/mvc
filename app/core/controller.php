<?php

class Controller{
    
    // Create the model requested
    protected function model($model)
    {
        // Load the relevant script for the model, if not already loaded
        require_once '../app/models/' . $model . '.php';
        // Create a new instance of the class for the model
        return new $model();
    }

    // Generate the page to be viewed
    protected function view($view, $data = [])
    {
        // Generate the view using the specific script requested, along with the generic header and footer to used for all pages
        require_once '../app/views/includes/header.inc.php';
        require_once '../app/views/' . $view . '.php';
        require_once '../app/views/includes/footer.inc.php';
    }

    // Check if the user is logged in
    public function chkIsLoggedIn($user)
    {
        // Check if the 'userid' session variable exists
        if (isset($_SESSION['userId']))
        {
            // Set the id, and and isLoggedIn variables of the User model
            $user->id = $_SESSION['userId'];
            $user->name = $_SESSION['userName'];
            $user->isLoggedIn = true;
            return true;
        }
        return false;
    }


}