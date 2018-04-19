<?php
     
require_once("Rest.inc.php");
require_once("../services/project_service.php");
require_once("../services/role_service.php");
require_once("../services/task_service.php");
require_once("../services/user_service.php");
     
class API extends REST {
     
    public $data = "";
    
    private $project_service;
    private $role_service;
    private $task_service;
    private $user_service;
 
    public function __construct(){
        parent::__construct();              // Init parent contructor
        $this->project_service = new ProjectService;
        $this->task_service    = new TaskService;
        $this->role_service    = new RoleService;
        $this->user_service    = new UserService;
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
  
    private function get_projects(){    
        $this->check_method("GET");

        $result = $this->project_service->get_all();
        $this->response(json_encode($result), 200);    
    }


    private function get_project() {
        $this->check_method("GET");

        $id = $this->_request['id'];
        $result = $this->project_service->find_by_id($id);

        $this->response(json_encode($result), 200);
    }


    private function delete_project() {
        $this->check_method("DELETE");

        $id = $this->_request['id'];
        $result = $this->project_service->delete_project($id);
       
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
        $result = $this->task_service->delete_task($id);
       
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
        $result = $this->role_service->delete_role($id);
       
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
        $result = $this->user_service->delete_user($id);
       
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