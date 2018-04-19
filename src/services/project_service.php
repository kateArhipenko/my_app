<?php
	require_once('base_service.php');

	class ProjectService extends BaseService
	{
		function __construct() {
			parent::__construct();
			$this->table_name = 'projects';
		}
	}