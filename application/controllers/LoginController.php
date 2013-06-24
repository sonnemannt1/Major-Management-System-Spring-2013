
<?php 

	if (! defined('BASEPATH')) exit('No direct access allowed');

	class LoginController extends CI_Controller {
		
		// throw this in your application\controllers folder
		
		public function __construct() {
			parent::__construct();
		}
		
		function index() {
			// function that is called when the class is initially instantiated
			// first things first, load up the login view
			$this->load->view("LoginView");
			if (isset($_SESSION["username"])) {
				redirect("LoginView.php");
			}
			session_start();
		}
		
		function ValidateForm() {
			$this->load->library("form_validation");
			$this->form_validation->set_rules("userName", "Username", "trim|required|xss_clean");
			$this->form_validation->set_rules("passWord", "Password", "trim|required|xss_clean");
			if ($this->form_validation->run() == TRUE) {
				$this->CheckValidLogin();
			}
			else {
				$this->load->view("LoginView");
			}
		}
		
		function CheckValidLogin() {
			// Note: to pass data to a view, use the following:
			// $data = <whatever data you want to pass>;
			// $this->load->view("name of view (without spaces)";
			// TODO: check for valid login
			//if ($this->input->post("userName") == "" || $this->input->post("passWord") == "") {
				//$this->load->view("LoginViewEmpty");
			//}
			$this->load->model("LoginModel"); // load up the model
			$user = $this->LoginModel->getLoginData($this->input->post("userName")); // creates a LoginModel object that has user data such as username and password
			// TODO: check here for a valid login and then load the appropriate view based on user access level (only if the login is successful)
			if ($user == false) {
				$this->load->view("InvalidLoginView");
				return;
			}
			if (isset($_SESSION["isAdvisor"]) == true) {
				if ($_SESSION["isAdvisor"] == true) {
					$password = $this->input->post("passWord");
					if ($password == $user->password) {
						$this->load->view("AdvisorView");
						return;
						// may need to set a session variable for the advisor id here for when we submit an approved minor or rejected minor
					}
					else {
						$this->load->view("InvalidLoginView");
						return;
					}
				}
				else if ($_SESSION["isAdvisor"] == false) {
					$password = $this->input->post("passWord");
					if ($password == $user->password) {
						$this->load->view("CurrentUserView");
					}
					else {
						$this->load->view("InvalidLoginView");
						return;
					}
				}
				else {
					$this->load->view("InvalidLoginView");
					return;
				}
			}
		}
		
		function CheckMinor() {
			// validation function for minor submission form
			if (isset($_SESSION) == false) {
				session_start();
			}
			$this->load->library("form_validation");
			$this->form_validation->set_rules("minorClass1", "Course #1", "required|xss_clean|trim|min_length[5]");
			$this->form_validation->set_rules("minorClass2", "Course #2", "required|xss_clean|trim|min_length[5]");
			$this->form_validation->set_rules("minorClass3", "Course #3", "required|xss_clean|trim|min_length[5]");
			$this->form_validation->set_rules("minorClass4", "Course #4", "required|xss_clean|trim|min_length[5]");
			$this->form_validation->set_rules("minorClass5", "Course #5", "required|xss_clean|trim|min_length[5]");
			$this->form_validation->set_rules("minorClass6", "Course #6", "required|xss_clean|trim|min_length[5]");
			if ($this->form_validation->run() == TRUE) {
				$check = $this->db->get_where("minorrequests", "minorrequests.studentid = " . $_SESSION["StudentID"]);
				// check if the student has already submitted a request
				// this makes it so that the user cannot go back and resubmit the form
				$this->SubmitNewMinor();
			}
			else {
				$this->load->view("CurrentUserView");
			}
		}
		
		function SubmitNewMinor() {
			// Get the last row of the MinorRequests table
			$query = $this->db->get("minorrequests");
			if ($query->num_rows() > 0) {
				session_start();
				$last_row = $query->last_row();
				$last_id = $last_row->MinorID;
				if ($this->input->post("minorClass1") != null && $this->input->post("minorClass2") != null && 
						$this->input->post("minorClass3") != null && $this->input->post("minorClass4") != null &&
						$this->input->post("minorClass5") != null && $this->input->post("minorClass6") != null) {
					// submit the minor request into the MinorRequests table
					$new_row = array("StudentID" => $_SESSION["StudentID"], "MinorID" => $last_id + 1);
					$this->db->insert("minorrequests", $new_row);
					// submit the classes into the classes table
					$new_row = array("Name" => $this->input->post("minorClass1"), "MinorID" => $last_id + 1);
					$this->db->insert("classes", $new_row);
					$new_row = array("Name" => $this->input->post("minorClass2"), "MinorID" => $last_id + 1);
					$this->db->insert("classes", $new_row);
					$new_row = array("Name" => $this->input->post("minorClass3"), "MinorID" => $last_id + 1);
					$this->db->insert("classes", $new_row);
					$new_row = array("Name" => $this->input->post("minorClass4"), "MinorID" => $last_id + 1);
					$this->db->insert("classes", $new_row);
					$new_row = array("Name" => $this->input->post("minorClass5"), "MinorID" => $last_id + 1);
					$this->db->insert("classes", $new_row);
					$new_row = array("Name" => $this->input->post("minorClass6"), "MinorID" => $last_id + 1);
					$this->db->insert("classes", $new_row);
					$minor_submit_success = array("minor_submit_success" => "Your minor has been successfully submitted.");
					$this->load->view("CurrentUserView", $minor_submit_success);
				}
				else {
					$minor_errors = array("minor_errors" => "We're sorry, but an internal error has occured. Please resubmit your minor.");
					$this->load->view("CurrentUserView", $minor_errors);
				}
			}
			else {
				// submit the minor into the MinorRequests table
				// MinorID will be one since there are no requests
				if (isset($_SESSION) == false) {
					session_start();
				}
				if ($this->input->post("minorClass1") != null && $this->input->post("minorClass2") != null &&
						$this->input->post("minorClass3") != null && $this->input->post("minorClass4") != null &&
						$this->input->post("minorClass5") != null && $this->input->post("minorClass6") != null) {
					$new_row = array("StudentID" => $_SESSION["StudentID"], "MinorID" => 1);
					$this->db->insert("minorrequests", $new_row);
					// submit the classes into the classes table
					$new_row = array("Name" => $this->input->post("minorClass1"), "MinorID" => 1);
					$this->db->insert("classes", $new_row);
					$new_row = array("Name" => $this->input->post("minorClass2"), "MinorID" => 1);
					$this->db->insert("classes", $new_row);
					$new_row = array("Name" => $this->input->post("minorClass3"), "MinorID" => 1);
					$this->db->insert("classes", $new_row);
					$new_row = array("Name" => $this->input->post("minorClass4"), "MinorID" => 1);
					$this->db->insert("classes", $new_row);
					$new_row = array("Name" => $this->input->post("minorClass5"), "MinorID" => 1);
					$this->db->insert("classes", $new_row);
					$new_row = array("Name" => $this->input->post("minorClass6"), "MinorID" => 1);
					$this->db->insert("classes", $new_row);
					$minor_submit_success = array("minor_submit_success" => "Your minor has been successfully submitted.");
					$this->load->view("CurrentUserView", $minor_submit_success);
				}
				else {
					$minor_errors = array("minor_errors" => "We're sorry, but an internal error has occured. Please resubmit your minor.");
					$this->load->view("CurrentUserView", $minor_errors);
				}
			}
			// Submit the minor into the requested minors database
		}
		
		function CheckMajor() {
			// this function validates the form input and checks for cross site scripting
			// it also decides if the selected values from the form meet the specifications
			// for example, one minor can be selected twice, but a third has to be selected
			if (isset($_SESSION) == false) {
				session_start();
			}
			$request_check = $this->db->get_where("majorrequests", "majorrequests.studentid = " . $_SESSION["StudentID"]);
			if ($request_check->num_rows() > 0) {
				// user has an outstanding request, stop execution
				// this prevents the user from pressing "back" and then trying to resubmit the form
				$major_errors = array("major_errors" => "You have already submitted a request. You may not submit another.");
				$this->load->view("CurrentUserView", $major_errors);
				return;
			}
			$this->load->library("form_validation");
			$this->form_validation->set_rules("MinorSelect1", "First minor", "trim|required|xss_clean");
			$this->form_validation->set_rules("MinorSelect2", "Second minor", "trim|required|xss_clean");
			$this->form_validation->set_rules("MinorSelect3", "Third minor", "trim|xss_clean");
			if ($this->form_validation->run() == true) {
				$first_input = $this->input->post("MinorSelect1");
				$second_input = $this->input->post("MinorSelect2");
				$third_input = $this->input->post("MinorSelect3");
				if ($first_input != "empty" && $second_input != "empty" && $third_input != "none") {
					// check if they're all equal
					// if they are not, then at least one is unique
					if ($first_input == $second_input || $second_input == $third_input || $first_input == $third_input) {
						// does not pass validation
						$major_errors = array("major_errors" => "Please select unique minors.");
						$this->load->view("CurrentUserView", $major_errors);
						return;
					}
					else {
						$this->SubmitMajorRequest();
						return;
					}
				}
				else if ($first_input != "empty" && $second_input != "empty" && $third_input == "none") {
					if ($first_input == $second_input) {
						// does not pass
						$major_errors = array("major_errors" => "Please select at least one unique minor.");
						$this->load->view("CurrentUserView", $major_errors);
						return;
					}
					else {
						// passes
						$this->SubmitMajorRequest();
						return;
					}
				}
				else if ($first_input != "empty" && $third_input != "none" && $second_input == "empty") {
					if ($first_input == $third_input) {
						// does not pass
						$major_errors = array("major_errors" => "Please select at least one unique minor.");
						$this->load->view("CurrentUserView", $major_errors);
						return;
					}
					else {
						// passes
						$this->SubmitMajorRequest();
						return;
					}
				}
				else if ($second_input != "empty" && $third_input != "none" && $first_input == "empty") {
					if ($second_input == $third_input) {
						// does not pass
						$major_errors = array("major_errors" => "Please select at least one unique minor.");
						$this->load->view("CurrentUserView", $major_errors);
						return;
					}
					else {
						// passes
						$this->SubmitMajorRequest();
						return;
					}
				}
				else {
					// does not pass
					$major_errors = array("major_errors" => "Please select unique minors.");
					$this->load->view("CurrentUserView", $major_errors);
					return;
				}
			}
		}
		
		function CheckAction() {
			if ($this->input->post("submit") != null) {
				if ($this->input->post("submit") == "View") {
					$this->SetCurrMinorID();
					return;
				}
				$this->load->library("form_validation");
				$this->form_validation->set_rules("MinorName", "Minor Name", "required|xss_clean|trim|min_length[5]");
				if ($this->form_validation->run() == TRUE) {
					if ($this->input->post("submit") == "Approve") {
						$this->ApproveMinor();
					}
					else {
						$this->RejectMinor();
					}
				}
				else {
					$_SESSION["form_id"] = 0;
					$this->load->view("AdvisorView");
				}
			}
		}
		
		function SetCurrMinorID() {
			if ($this->input->post("minorSelectionBox") != null) {
				$data["curr_id"] = $this->input->post("minorSelectionBox");
				$this->load->view("AdvisorView", $data);
			}
		}
		
		function SubmitMajorRequest() {
			if (isset($_SESSION) == false) {
				session_start();
			}
			$first_minor = $this->input->post("MinorSelect1");
			$second_minor = $this->input->post("MinorSelect2");
			$third_minor = $this->input->post("MinorSelect3");
			$major_submit_success = array("major_submit_success" => "Your major has been successfully submitted for approval.");
			if ($first_minor != "empty" && $second_minor != "empty" && $third_minor != "none") {
				// best case scenario, everything is basically handed to us nicely. go ahead and throw it in the databse
				$insert = array("StudentID" => $_SESSION["StudentID"], "Minor1" => $first_minor, "Minor2" => $second_minor,
						"Minor3" => $third_minor);
				$this->db->insert("majorrequests", $insert);
				$this->load->view("CurrentUserView", $major_submit_success);
				return;
			}
			else if ($first_minor != "empty" && $second_minor != "empty" && $third_minor == "none") {
				// for the sake of neatness, if there is not a third minor, set the first two columns in the database
				// This also makes it easier when we display the approval table in the advisor view
				$insert = array("StudentID" => $_SESSION["StudentID"], "Minor1" => $first_minor, "Minor2" => $second_minor, 
						"Minor3" => null);
				$this->db->insert("majorrequests", $insert);
				$this->load->view("CurrentUserView", $major_submit_success);
				return;
			}
			else if ($first_minor != "empty" && $second_minor == "empty" && $third_minor != "none") {
				$insert = array("StudentID" => $_SESSION["StudentID"], "Minor1" => $first_minor, "Minor2" => $third_minor,
						"Minor3" => null);
				$this->db->insert("majorrequests", $insert);
				$this->load->view("CurrentUserView", $major_submit_success);
				return;
			}
			else if ($first_minor == "empty" && $second_minor != "empty" && $third_minor != "none") {
				$insert = array("StudentID" => $_SESSION["StudentID"], "Minor1" => $second_minor, "Minor2" => $third_minor,
						"Minor3" => null);
				$this->db->insert("majorrequests", $insert);
				$this->load->view("CurrentUserView", $major_submit_success);
				return;
			}
			else {
				$major_errors = array("major_errors" => "We apologize, but an internal error has occured. Please resubmit the request.");
				$this->load->view("CurrentUserView", $major_errors);
				return;
			}
		}
		
		function ApproveMinor() {
			// four things need to be done here
			// insert the new approval into the approvedminors table
			// update the classes table
			// remove any outstanding rejections
			// remove the request
			if ($this->input->post("minorSelectionBox") != null) {
				$curr_minor_id = $this->input->post("minorSelectionBox");
				$comments = $this->input->post("Comments");
				$minor_name = $this->input->post("MinorName");
				$student_q = $this->db->get_where("minorrequests", "minorrequests.minorid = " . $curr_minor_id);
				$student_id = $student_q->row()->StudentID;
				$data = array("StudentID" => $student_id, "Comments" => $comments, "MinorName" => $minor_name);
				$this->db->insert("approvedminors", $data);
				$classes_q = $this->db->get_where("classes", "classes.minorid = " . $curr_minor_id);
				if ($classes_q->num_rows() > 0) {
					$approvals = $this->db->get("approvedminors");
					$last_approval = $approvals->last_row()->ID;
					foreach ($classes_q->result() as $row) {
						$this->db->where("classes.minorid = " . $curr_minor_id);
						$data = array("MinorID" => null, "ApprovedID" => $last_approval);
						$this->db->update("classes", $data);
					}
				}
				$delete = array("MinorID" => $curr_minor_id);
				$this->db->delete("minorrequests", $delete);
				$this->db->select("*");
				$this->db->from("classes");
				$this->db->where("rejectedminors.studentid = " . $student_id);
				$this->db->join("rejectedminors", "classes.rejectedid = rejectedminors.id");
				$rejections = $this->db->get();
				if ($rejections->num_rows() > 0) {
					foreach ($rejections->result() as $row) {
						$this->db->delete("rejectedminors", array("MinorID" => $curr_minor_id));
					}
				}
				$student_q = $this->db->get_where("currentusers", "currentusers.studentid = " . $student_id);
				if ($student_q->num_rows() > 0) {
					$this->db->where("currentusers.studentid", $student_id);
					$data = array("ApprovalLimitReached" => true);
					$this->db->update("currentusers", $data);
				}
				$this->load->view("AdvisorView", array("curr_tab" => 0, "approved_message" => "The minor has been approved."));
			}
		}
		
		function SetCurrMajorID() {
			if ($this->input->post("majorSelectionBox") != null) {
				$data = array("curr_maj_id" => $this->input->post("majorSelectionBox"), "curr_tab" => 1);
				$this->load->view("AdvisorView", $data);
			}
		}
		
		function ValidateMajorApproval() {
			if ($this->input->post("submitMajor") != null) {
				$m_id = $this->input->post("majorSelectionBox");
				// check for a double submit
				$id_check = $this->db->get_where("approvedmajors", "approvedmajors.id = " . $m_id);
				if ($id_check->num_rows() > 0) {
					$approval_errors = array("approval_errors" => "This major has already been approved.");
					$this->load->view("AdvisorView", $approval_errors);
					return;
				}
				if ($this->input->post("submitMajor") == "View") {
					$this->SetCurrMajorID();
					return;
				}
				else if ($this->input->post("submitMajor") == "Approve") {
					$this->load->library("form_validation");
					$this->form_validation->set_rules("majorSelectionBox", "Major ID", "trim|required|xss_clean");
					$this->form_validation->set_rules("majorComments", "Comments", "trim|xss_clean");
					$this->form_validation->set_rules("MajorName", "Major Name", "trim|required|xss_clean|min_length[5]");
					if ($this->form_validation->run() == true) {
						$this->ApproveMajor();
						return;
					}
					else {
						$_SESSION["form_id"] = 1;
						$this->load->view("AdvisorView");
						return;
					}
				}
				else {
					$this->RejectMajor();
					return;
				}
			}
		}
		
		function ApproveMajor() {
			if ($this->input->post("majorSelectionBox") != null) {
				$curr_major_id = $this->input->post("majorSelectionBox");
				$comments = $this->input->post("majorComments");
				$major_name = $this->input->post("MajorName");
				if ($curr_major_id != null && $major_name != null) {
					$request = $this->db->get_where("majorrequests", "majorrequests.id = " . $curr_major_id);
					if ($request->num_rows() == 1) {
						$row = $request->row();
						$insert = array("StudentID" => $row->StudentID, "Minor1" => $row->Minor1, "Minor2" => $row->Minor2, 
								"Minor3" => $row->Minor3, "Comments" => $comments);
						$this->db->insert("approvedmajors", $insert);
						$rejections_check = $this->db->get_where("rejectedmajors", "rejectedmajors.studentid = " . $row->StudentID);
						if ($rejections_check->num_rows() > 0) {
							foreach ($rejections_check->result() as $row) {
								$this->db->delete("rejectedmajors", array("StudentID" => $row->StudentID));
							}
						}
					}
					$this->db->delete("majorrequests", array("ID" => $curr_major_id));
					$major_message = array("major_message" => "The major has been approved.");
					$this->load->view("AdvisorView", $major_message);
				}
			}
		}
		
		function RejectMinor() {
			if ($this->input->post("minorSelectionBox") != null) {
				$this->db->select("*");
				$this->db->from("classes");
				$this->db->where("minorid", $this->input->post("minorSelectionBox"));
				$query = $this->db->get();
				if ($query->num_rows() > 0) {
					$student_query = $this->db->get_where("minorrequests", "minorrequests.minorid = " . $this->input->post("minorSelectionBox"));
					if ($student_query->num_rows() == 1) {
						$student_id = $student_query->row()->StudentID;
						$rejected_minors = $this->db->get("rejectedminors");
						if ($rejected_minors->num_rows() > 0) {
							$rejected_last = $rejected_minors->last_row();
							$last_id = $rejected_last->ID;
							foreach($query->result() as $row) {
								// update the classes table with the new data
								$this->db->where("minorid", $this->input->post("minorSelectionBox"));
								$data = array("MinorID" => null, "RejectedID" => $last_id + 1);
								$this->db->update("classes", $data);
							}
							// insert new row into the RejectedMinors table
							$data = array("StudentID" => $student_id, "ID" => $last_id + 1);
							$this->db->insert("rejectedminors", $data);
							// remove the request
							$data = array("MinorID" => $this->input->post("minorSelectionBox"));
							$this->db->delete("minorrequests", $data);
						}
						else {
							foreach($query->result() as $row) {
								// update the classes table with the new data
								$this->db->where("minorid", $this->input->post("minorSelectionBox"));
								$data = array("MinorID" => null, "RejectedID" => 1);
								$this->db->update("classes", $data);
							}
							// insert new row into the RejectedMinors table
							$data = array("StudentID" => $student_id, "ID" => 1);
							$this->db->insert("rejectedminors", $data);
							// remove the request
							$data = array("MinorID" => $this->input->post("minorSelectionBox"));
							$this->db->delete("minorrequests", $data);
						}
					}
				}
			}
		}
		
		function RejectMajor() {
			if ($this->input->post("majorSelectionBox") != null) {
				$curr_major_id = $this->input->post("majorSelectionBox");
				$comments = $this->input->post("majorComments");
				$major_name = $this->input->post("MajorName");
				$request = $this->db->get_where("majorrequests", "majorrequests.id = " . $curr_major_id);
				if ($request->num_rows() == 1) {
					$row = $request->row();
					$insert = array("StudentID" => $row->StudentID, "Minor1" => $row->Minor1, "Minor2" => $row->Minor2,
							"Minor3" => $row->Minor3, "Comments" => $comments);
					$this->db->insert("rejectedmajors", $insert);
					$this->db->delete("majorrequests", array("ID" => $curr_major_id));
				}
				$major_message = array("major_message" => "The major has been rejected.");
				$this->load->view("AdvisorView", $major_message);
			}
		}
		
		function ValidateProspect() {
			$this->load->library("form_validation");
			$this->form_validation->set_rules("prospect_email", "Prospect Email", "required|xss_clean|min_length[5]|valid_email|is_unique[prospects.email)");
			$this->form_validation->set_rules("prospect_phone", "Prospect Phone Number", "required|xss_clean|exact_length[10]|numeric");
			$this->form_validation->set_rules("prospect_confirm", "Prospect Email Confirm", "required|xss_clean|min_length[5]|valid_email|matches(prospect_email)");
			if ($this->form_validation->run() == TRUE) {
				$this->SubmitProspect();
			}
			else {
				$_SESSION["form_id"] = 3;
				$this->load->view("AdvisorView");
			}
		}
		
		function SubmitProspect() {
			$email = $this->input->post("prospect_email");
			$phone = $this->input->post("prospect_phone");
			$insert = array("Email" => $email, "Phone_Number" => $phone);
			$this->db->insert("prospects", $insert);
			$prospect_message = array("prospect_message" => "Prospect has been added successfully.");
			$this->load->view("AdvisorView", $prospect_message);
		}
	
		function ValidateNewUser() {
			if ($this->input->post("newUserSelect") != null) {
				$this->load->library("form_validation");
				$this->form_validation->set_rules("fName", "First Name", "required|xss_clean|min_length[3]");
				$this->form_validation->set_rules("lName", "Last Name", "required|xss_clean|min_length[5]");
				$this->form_validation->set_rules("email", "Email", "required|xss_clean|min_length[5]|valid_email|is_unique(currentusers.username)");
				$this->form_validation->set_rules("email_confirm", "Email confirmation", "required|xss_clean|min_length[5]|valid_email|matches[email]");
				$this->form_validation->set_rules("password", "Password", "required|xss_clean|min_length[5]|");
				$this->form_validation->set_rules("password_confirm", "Password confirmation", "required|xss_clean|min_length[5]|matches[password]");
				if ($this->form_validation->run() == TRUE) {
					$_SESSION["form_id"] = 2;
					if ($this->input->post("newUserSelect") == "Advisor") {
						$this->SubmitNewAdvisor();
					}
					else {
						$this->SubmitNewUser();
					}
				}
				else {
					$_SESSION["form_id"] = 2;
					$this->load->view("AdvisorView");
				}
			}
		}
		
		function SubmitNewUser() {
			// check is the user exists already
			// this is done mainly so that the form is not resubmitted when the users refreshes the page
			$f_name = $this->input->post("fName");
			$l_name = $this->input->post("lName");
			$email = $this->input->post("email");
			$password = $this->input->post("password");
			$insert = array("First_Name" => $f_name, "Last_Name" => $l_name, "Username" => $email, "Password" => $password);
			$this->db->insert("currentusers", $insert);
			$new_message = array("new_message" => "User has been successfully created.");
			$this->load->view("AdvisorView", $new_message);
		}
		
		function SubmitNewAdvisor() {
			$f_name = $this->input->post("fName");
			$l_name = $this->input->post("lName");
			$email = $this->input->post("email");
			$password = $this->input->post("password");
			$insert = array("First_Name" => $f_name, "Last_Name" => $l_name, "Username" => $email, "Password" => $password);
			$this->db->insert("advisors", $insert);
			$new_message = array("new_message" => "Advisor has been successfully created.");
			$this->load->view("AdvisorView", $new_message);
		}
		
		function Logout() {
			if (isset($_SESSION) == false) {
				session_start();
				session_destroy();
			}
			else {
				session_destroy();
			}
			$this->load->view("LoginView");
		}
		
	}

?>