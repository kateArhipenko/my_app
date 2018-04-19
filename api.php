<?php
     
require_once("Rest.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/my_api/src/services/project_service.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/my_api/src/services/role_service.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/my_api/src/services/task_service.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/my_api/src/services/user_service.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/my_api/src/services/auth_service.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/my_api/src/services/reg_service.php");
     
class API extends REST {
     
    public $data = "";
    
    private $project_service;
    private $role_service;
    private $task_service;
    private $user_service;

    private $auth_service;
    private $reg_service;
 
    public function __construct(){
        parent::__construct();              // Init parent contructor
        $this->project_service = new ProjectService;
        $this->task_service    = new TaskService;
        $this->role_service    = new RoleService;
        $this->user_service    = new UserService;
        $this->auth_service    = new AuthService;
        $this->reg_service     = new RegService;
    }
          
    /*
     * Public method for access api.
     * This method dynmically call the method based on the query string
     *
     */
    public function processApi(){
            $func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
            if((int)method_exists($this,$func) > 0)
                $this->$func();
            else
                $this->response('Error code 404, Page not found',404);   // If the method not exist with in this class, response would be "Page not found".
    }

    private function registration() {
      $this->check_method("GET");

      $login            = $this->_request['login'];
      $password         = $this->_request['password'];
      $confirm_password = $this->_request['confirm_password'];

      $result = $this->reg_service->registration($login, $password, $confirm_password);

      $this->response(json_encode($result), 200);
    }

    private function login() {
      $this->check_method("GET");

      $login = $this->_request['login'];
      $password = $this->_request['password'];

      $result = $this->auth_service->login($login, $password);

      $this->response(json_encode($result), 200);
    }

    private function check_authorize() {
      $this->check_method("GET");

      $hash = $this->_request['hash'];

      $result = $this->auth_service->check_authorize($hash);

      $this->response(json_encode($result), 200);
    }
  
    private function get_projects(){    
        $this->check_method("GET");

        $result = $this->project_service->get_all();
        $this->response(json_encode($result), 200);    
    }


    private function get_project() {
        $this->check_method("GET");

        $id = $this->_request['id'];
        $result = $this->project_service->find_by_id($id);
        $this->_request['id'];
        $this->response(json_encode($result), 200);
    }


    private function delete_project() {
        $this->check_method("DELETE");

        $id = $this->_request['id'];
        $result = $this->project_service->delete($id);
       
        $this->response(json_encode($result), 200);
    }

     private function create_project() {
       $this->check_method("GET"); 
       
       $params = $this->_request;
       array_shift($params);
       $result = $this->project_service->create($params);

       $this->response(json_encode($result), 200);
    }

      private function update_project() {
       $this->check_method("GET"); 
       
       $params = $this->_request;
       array_shift($params);
       $result = $this->project_service->update($params['id'], $params);

       $this->response(json_encode($result), 200);
    }

    private function get_tasks(){    
        $this->check_method("GET");

        $result = $this->task_service->get_all();
        $this->response(json_encode($result), 200);    
    }


    private function get_task() {
        $this->check_method("GET");

        $id = $this->_request['id'];
        $result = $this->task_service->find_by_id($id);

        $this->response(json_encode($result), 200);
    }


    private function delete_task() {
        $this->check_method("DELETE");

        $id = $this->_request['id'];
        $result = $this->task_service->delete($id);
       
        $this->response(json_encode($result), 200);
    }
     

      private function create_task() {
       $this->check_method("GET"); 
       
       $params = $this->_request;
       array_shift($params);
       $result = $this->task_service->create($params);

       $this->response(json_encode($result), 200);
    }

      private function update_task() {
       $this->check_method("GET"); 
       
       $params = $this->_request;
       array_shift($params);
       $result = $this->task_service->update($params['id'], $params);

       $this->response(json_encode($result), 200);
    }

    private function get_roles(){    
        $this->check_method("GET");

        $result = $this->role_service->get_all();
        $this->response(json_encode($result), 200);    
    }


    private function get_role() {
        $this->check_method("GET");

        $id = $this->_request['id'];
        $result = $this->role_service->find_by_id($id);

        $this->response(json_encode($result), 200);
    }


    private function delete_role() {
        $this->check_method("DELETE");

        $id = $this->_request['id'];
        $result = $this->role_service->delete($id);
       
        $this->response(json_encode($result), 200);
    }

    private function create_role() {
       $this->check_method("GET"); 
       
       $params = $this->_request;
       array_shift($params);
       $result = $this->role_service->create($params);

       $this->response(json_encode($result), 200);
    }

     private function update_roles() {
       $this->check_method("GET"); 
       
       $params = $this->_request;
       array_shift($params);
       $result = $this->roles_service->update($params['id'], $params);

       $this->response(json_encode($result), 200);
    }

    private function get_users(){    
        $this->check_method("GET");

        $result = $this->user_service->get_all();
        $this->response(json_encode($result), 200);    
    }


    private function get_user() {
        $this->check_method("GET");

        $id = $this->_request['id'];
        $result = $this->user_service->find_by_id($id);

        $this->response(json_encode($result), 200);
    }


    private function delete_user() {
        $this->check_method("DELETE");

        $id = $this->_request['id'];
        $result = $this->user_service->delete($id);
       
        $this->response(json_encode($result), 200);
    }

      private function create_user() {
       $this->check_method("GET"); 
       
       $params = $this->_request;
       array_shift($params);
       $result = $this->user_service->create($params);

       $this->response(json_encode($result), 200);
    }

      private function update_user() {
       $this->check_method("GET"); 
       
       $params = $this->_request;
       array_shift($params);
       $result = $this->user_service->update($params['id'], $params);

       $this->response(json_encode($result), 200);
    }
    /*
     *  Encode array into JSON
    */
    private function json($data){
        if(is_array($data)){
            return json_encode($data);
        }
    }
    
    private function check_method($expected_method) {
        if($this->get_request_method() != $expected_method){
            $this->response('',406);
        }
    }
}

 $api = new API;
    $api->processApi();