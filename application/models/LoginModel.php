<?php

	class LoginModel extends CI_Model {
		
		// on your local machine, throw this in the application\models folder
		// login model for grabbing the user data from the database
		// on your local server, i suggest setting up a test user to verify that this works
		// on your local server, create a database called currentusers and throw some test usernames and passwords in
		var $studentID = "";
		var $advisorID = "";
		var $user = "";
		var $password = "";
		var $advisorFirstName = "";
		var $advisorLastName = "";
		var $approvalLimitReached = false;
		
		function __construct() {
			parent::__construct();
		}
		
		public function getLoginData($user) {
			session_start();
			$query = $this->db->get_where("currentusers", array("Username" => $user)); // grab the username from the database
			if ($query != null) { // check if it exists
				$user_data = $query->row();
				if ($query->num_rows() == 1) {
					// user was found
					$_SESSION["isAdvisor"] = false;
					$_SESSION["StudentID"] = $user_data->StudentID;
					$_SESSION["username"] = $user_data->Username;
					$this->studentID = $user_data->StudentID;
					$this->advisorID = null;
					$this->user = $user_data->Username;
					$this->password = $user_data->Password;
					$this->advisorFirstName = null;
					$this->advisorLastName = null;
					$this->approvalLimitReached = $user_data->ApprovalLimitReached;
					return $this;
				}
				else {
					// user was not found, might be an advisor
					$query = $this->db->get_where("advisors", array("Username" => $user));
					$user_data = $query->row();
					if ($query->num_rows() == 1) {
						$_SESSION["isAdvisor"] = true;
						$_SESSION["username"] = $user_data->Username;
						$this->studentID = null;
						$this->advisorID = $user_data->AdvisorID;
						$this->user = $user_data->Username;
						$this->password = $user_data->Password;
						$this->approvalLimitReached = null;
						// todo: assign advisor last and first name
						return $this;
					}
				}
				return false;
			}
		}
		
	}

?>