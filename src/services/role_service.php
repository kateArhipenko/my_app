<?php
	require_once('base_service.php');

	Class RoleService  extends BaseService {
		function __construct() {
			parent::__construct();
			$this->table_name = 'roles';
		}
	}