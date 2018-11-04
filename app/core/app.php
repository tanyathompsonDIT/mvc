<?php

class App{

    protected $controller = 'home';
    protected $method = 'index';
    protected $params = [];
    protected $root = '../';
 
    public function __construct()
    {
        // Get each element of the full request path (as redirected in .htaccess)
        $url = $this->parseUrl();
        // Check if the request path ends with a '/'
        $reduceUrlCount = 0;
        if (isset($_GET['url']))
        {
            if (substr($_GET['url'], -1) != '/')
            {
                $reduceUrlCount = 1;
            }
        }
        // Determine number of levels up needed to get to the root folder
        $count = count($url) - $reduceUrlCount;
        for ($i = 0; $i < $count; $i++)
        {
            $this->root .= '../';
        }
        // print_r($url);

        // Check if a contoller exists (e.g., home.php) for the first element in the request path and load
        // If not, home.php will be loaded
        if (file_exists('../app/controllers/' . $url[0] . '.php'))
        {
            $this->controller = $url[0];
            // remove the element from the array without reshuffling or renumbering the keys
            unset($url[0]);
        }
        // Load as the controller and create a new instance of the controller-specific class
        require_once '../app/controllers/' . $this->controller . '.php';
        // echo '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;
        
        // Check if a method is found for the second element in the request path, and check if it is defined within the controller
        if (isset($url[1]))
        {
            // Check if the method is defined in the relevant controller
            if (method_exists($this->controller, $url[1]))
            {
                // Check if the method is public
                // The method can't be called if not public (e.g., as in the case of 'public/signin/trySignIn/')
                $reflection = new ReflectionMethod($this->controller, $url[1]);
                if ($reflection->isPublic()) 
                {
                    $this->method = $url[1];
                }
                // remove the element from the array without reshuffling or renumbering the keys
                unset($url[1]); 
            }
        // print_r($url);
        }

        // Get any other elements within the request path -- to be used as parameters
        // Set as values of an array, or return an empty array if no further elements are found 
        $this->params = $url ? array_values($url) : [];  
        // Add the root location to the beginning of the array      
        array_unshift($this->params , $this->root);
        // call the method required from the controller with the relevant parameters
        call_user_func_array([$this->controller, $this->method], $this->params); 
    }

    // Convert the full request path returned into an array - see .htaccess
    public function parseUrl()
    {
        if (isset($_GET['url']))
        {
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}