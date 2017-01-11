<?php
  class Bootstrap 
  {
    private $action;
    private $controller;
    private $request;

    public function __construct($request)
    {
      $this->request = $request;
      // URL is going 'root/controller/action'.
      if ($this->request['controller'] == '') {
        $this->controller = 'home'; // Load home controller (home page).
      } else {
        $this->controller = $this->request['controller']; // Load any other controller (whatever will be passed in URL, i.e. '/sample-subpage' controller name will be 'sample-subpage').
      }
      if ($this->request['action'] == '') { // Load index action.
        $this->action = 'index';
      } else {
        $this->action = $this->request['action'];
      }

      // echo $this->controller;
      // echo $this->action;
    }

    public function createController() 
    {
      if (class_exists($this->controller)) // Check class.
      {
        $parents = class_parents($this->controller);
        if (in_array('Controller', $parents)) // Check base controller.
        {
          if (method_exists($this->controller, $this->action)) // Check method.
          {
            return new $this->controller($this->action, $this->request);
          } else {
            echo "<h1>Method doesn't exist.</h1>";
            return;
          }
        } else {
          echo "<h1>Base controller not found.</h1>";
          return;
        }
      } else {
        echo "<h1>Controller class doesn't exist</h1>";
        return;
      }
    }
  }
