<?php include 'includes/header.php';

	$this->load->helper("form");	

?>
<html>
<head>
<link rel="stylesheet" href="../../styles/default.css" />
<script src="../../scripts/script.js" type="text/javascript"></script>
<script type="text/javascript">
	function Load() {
		<?php 
			if (isset($curr_tab)) {
				echo ("window.onLoad = function () {\n");
				echo ("tab_click(" . $curr_tab . ");");
				echo ("}\n");
			}
		?>
	}
</script>
<title>Advisors</title>
</head>
<body onLoad="Load">
<div class="centerTabs" id="tabs" align="center">
	<div class="tabContainer">
		<table style="position: relative; width: 100%; height: 100%;">
			<tr>
				<td id="firstTab" class="selectedTab" align="center" onMouseOver="tab_enter(0)" onClick="tab_click(0)" onMouseOut="tab_leave(0)">
					<p style="color: white">View Requested Minors</p>
				</td>
				<td id="secondTab" class="inactiveTab" align="center" onMouseOver="tab_enter(1)" onMouseOut="tab_leave(1)" onClick="tab_click(1)">
					View Requested Majors
				</td>
				<td id="thirdTab" class="inactiveTab" align="center" onMouseOver="tab_enter(2)" onClick="tab_click(2)" onMouseOut="tab_leave(2)"> 
					Administrator
				</td>
				<td id="fourthTab" class="inactiveTab" align="center" onMouseOver="tab_enter(3)" onClick="tab_click(3)" onMouseOut="tab_leave(3)"> 
					View List of Minors
				</td>
				<td id="fifthTab" class="inactiveTab" align="center" onMouseOver="tab_enter(4)" onClick="tab_click(4)" onMouseOut="tab_leave(4)">
					Prospects
				</td>
				<td id="logoutTab" class="inactiveTab" align="center" onMouseOver="tab_enter(5)" onMouseOut="tab_leave(5)" onClick="logout()">
					Logout
				</td>
			</tr>
		</table>
	</div>
	<div>
		<div id="firstTabContent" class="activeTabContent">
			<div style="margin-top: 10px; margin-left: 15%; margin-right: 15%">
				<?php
					// TODO: grab number of minor requests that are awaiting approval and display them to the advisor
					$query = $this->db->get("minorrequests");
					if (isset($_SESSION["form_id"]))
						if ($_SESSION["form_id"] == 0)
							echo ("<p align=center><font color=red>" . validation_errors() . "</font></p>");
					if ($query->num_rows() > 0) {
						if (isset($approved_message)) {
							echo ("<p align=center>" . $approved_message . "</p>");
						}
						else if (isset($rejected_message)) {
							echo ("<p align=center>" . $rejected_message . "</p>");
						}
						echo ("<p align=center><font color=red weight=bold>" . validation_errors() . "</p></font>\n");
						echo(form_open("/LoginController/CheckAction") . "\n");
						echo ("<table align=center>\n");
						echo ("<tr>\n");
						echo ("<td valign=center>\n");
						echo (form_label("Select a pending minor:") . "\n");
						echo ("</td>\n");
						echo ("<td align=left>\n");
						echo ('<select name=minorSelectionBox id=minorSelectionBox width=50px align=left>\n');
						foreach ($query->result() as $row) {
							if (isset($curr_id)) {
								if ($row->MinorID == $curr_id) {
									echo ("<option selected value=" . $row->MinorID . ">" . $row->MinorID . "</option>\n");
								}
								else {
									echo ("<option value=" . $row->MinorID . ">" . $row->MinorID . "</option>\n");
								}
							}
							else
								echo ("<option value=" . $row->MinorID . ">" . $row->MinorID . "</option>\n");
						}
						echo ("</select>\n");
						echo ("</td>\n");
						echo ("<td>\n");
						echo (form_submit(array("name" => "submit"), "View") . "\n");
						echo ("</td>");
						echo ("</tr>\n");
						echo ("</table>");
						echo ("<table width=70% align=center class=classesTable>\n");
						echo ("<tr>\n");
						echo ("<th>\n");
						echo ("Class Name\n");
						echo ("</th>\n");
						echo ("</tr>");
						if (isset($curr_id)) {
							$query = $this->db->get_where("classes", "classes.minorid = " . $curr_id);
							foreach ($query->result() as $row) {
								echo ("<tr>");
								echo ("<td align=center>" . $row->Name . "</td>");
								echo ("</tr>");
							}
							$curr_id = null;
						}
						else {
							$requests = $query->result_array();
							$firstItem = $requests[0];
							$this->db->select("*");
							$this->db->from("classes");
							$this->db->where("classes.minorid =" . $firstItem["MinorID"]);
							$query = $this->db->get();
							foreach ($query->result() as $row) {
								echo ("<tr>");
								echo ("<td align=center>" . $row->Name . "</td>");
								echo ("</tr>");
							}
						}
						echo ("</table>");
						echo ("<br />");
						echo ("<table align=center>\n");
						echo ("<tr>");
						echo ("<td align=right>");
						echo ("Enter a unique name for this minor:   ");
						echo ("</td>");
						echo ("<td>");
						$data = array("id" => "MinorName", "name" => "MinorName", "style" => "width: 100%;");
						echo (form_input($data, null));
						echo ("</td>");
						echo ("</tr>");
						echo ("<tr>");
						echo ("<td valign=top>");
						echo ("Enter any comments that you have for this minor:   ");
						echo ("</td>");
						echo ("<td>");
						$data = array("id" => "Comments", "name" => "Comments", "style" => "width: 325px; height: 50px");
						echo (form_input($data));
						echo ("</td>");
						echo ("</tr>");
						echo ("</table>");
						echo ("<table align=center>");
						echo ("<tr>");
						echo ("<td>");
						echo (form_submit(array("name" => "submit", "style" => "width: 150px"), "Approve"));
						echo ("</td>");
						echo ("<td>");
						echo (form_submit(array("name" => "submit", "style" => "width: 150px"), "Reject"));
						echo ("</td>");
						echo ("</tr>");
						echo ("</table>");
						echo (form_close());
					}
					else {
						echo ("<p align=center>There are no requests for minors at this time.</p>");
					}
				?>
			</div>
		</div>
		<div id="secondTabContent" class="inActiveTabContent">
			<div style="margin-top: 10px; margin-left: 15%; margin-right: 15%">
				<?php 
					$query = $this->db->get("majorrequests");
					if (isset($_SESSION["form_id"]))
						if ($_SESSION["form_id"] == 1)
							echo ("<p align=center><font color=red>" . validation_errors() . "</font></p>");
					if ($query->num_rows() > 0) {
						echo(form_open("/LoginController/ValidateMajorApproval"));
						echo ("<table align=center>");
						echo ("<tr>");
						echo ("<td>");
						echo (form_label("Select a pending major:"));
						echo ("</td>");
						echo ("<td align=left>");
						echo ('<select name=majorSelectionBox id=majorSelectionBox width=50px align=left>');
						foreach ($query->result() as $row) {
							echo ("<option value=" . $row->ID . ">" . $row->ID . "</option>\n");
						}
						echo ("</select>");
						echo ("</td>");
						echo ("<td>");
						echo (form_submit(array("name" => "submitMajor"), "View"));
						echo ("</tr>");
						echo ("<tr>");
						echo ("</table>");
						echo ("<table width=70% align=center class=classesTable>");
						echo ("<tr>");
						echo ("<th>");
						echo ("Minor Name");
						echo ("</th>");
						echo ("</tr>");
						$requests = $query->result_array();
						$firstItem = $requests[0];
						$this->db->select("*");
						$this->db->from("majorrequests");
						$this->db->where("majorrequests.studentid =" . $firstItem["StudentID"]);
						$query = $this->db->get();
						$row = $query->row();
						echo ("<tr>\n");
						echo ("<td align=center>\n");
						echo ($row->Minor1);
						echo ("</td>\n");
						echo ("</tr>\n");
						echo ("<tr>\n");
						echo ("<td align=center>\n");
						echo ($row->Minor2);
						echo ("</td>\n");
						echo ("</tr>\n");
						if ($row->Minor3 != null) {
							echo ("<tr>\n");
							echo ("<td align=center>\n");
							echo ($row->Minor3);
							echo ("</td>\n");
							echo ("</tr>\n");
						}
						echo ("</table>");
						echo ("<table>");
						echo ("<tr>");
						echo ("<td>");
						echo (form_label("Enter a unique name for this major:   "));
						echo ("</td>");
						echo ("<td>");
						$data = array("id" => "MajorName", "name" => "MajorName", "style" => "width: 100%");
						echo (form_input($data));
						echo ("</td>");
						echo ("</tr>");
						echo ("<tr>");
						echo ("<td align=right>\n");
						echo (form_label("Enter any comments you have here:   "));
						echo ("</td>");
						echo ("<td>");
						$data = array("name" => "MajorComments", "style" => "width: 325px; height: 50px");
						echo (form_textarea($data));
						echo ("</td>");
						echo ("</tr>");
						echo ("</table>");
						echo ("<table align=center>");
						echo ("<tr>");
						echo ("<td>");
						echo (form_submit(array("name" => "submitMajor", "style" => "width: 150px"), "Approve"));
						echo ("</td>");
						echo ("<td>");
						echo (form_submit(array("name" => "submitMajor", "style" => "width: 150px"), "Reject"));
						echo ("</td>");
						echo ("</tr>");
						echo ("</table>");
						echo (form_close());	
					}
					else {
						echo ("<p align=center>There are no major requests at this time.</p>");
					}
				?>
			</div>
		</div>
		<div id="thirdTabContent" class="inActiveTabContent">
			<div style="margin-top: 10px; margin-left: 15%; margin-right: 15%">
				<?php 
					if (isset($_SESSION["form_id"])) {
						if ($_SESSION["form_id"] == 2)
							echo ("<p align=center><font color=red>" . validation_errors() . "</font></p>\n");
					}
					if (isset($new_message))
						echo ("<p align=center>" . $new_message . "</p>\n");
					if (isset($prospect_message))
						echo ("<p align=center>" . $prospect_message . "</p>\n");
					echo ("<h2>Add a new user</h2>\n");
					echo (form_open("LoginController/ValidateNewUser"));
					echo ("<table align=center>\n");
					echo ("<tr>\n");
					echo ("<td>\n");
					echo ("Please select a user type to create:\n");
					echo ("</td>\n");
					echo ("<td>\n");
					echo ("<select name=newUserSelect id=newUserSelect>\n");
					echo ("<option value=Advisor selected>Advisor</option>\n");
					echo ("<option value=Student>Student</option>\n");
					echo ("</select>\n");
					echo ("</td>\n");
					echo ("</tr>\n");
					echo ("</table>\n");
					echo ("<br />\n");
					echo ("<table align=center>\n");
					echo ("<tr>\n");
					echo ("<td>\n");
					echo ("First Name:\n");
					echo ("</td>\n");
					echo ("<td>\n");
					echo (form_input(array("type" => "text", "name" => "fName")));
					echo ("</td>\n");
					echo ("</tr>\n");
					echo ("<tr>\n");
					echo ("<td>\n");
					echo ("Last Name:\n");
					echo ("</td>\n");
					echo ("<td>\n");
					echo (form_input(array("type" => "text", "name" => "lName")));
					echo ("</td>\n");
					echo ("</tr>\n");
					echo ("<tr>\n");
					echo ("<td>\n");
					echo ("Email:\n");
					echo ("</td>\n");
					echo ("<td>\n");
					echo (form_input(array("type" => "text", "name" => "email")));
					echo ("</td>\n");
					echo ("</tr>\n");
					echo ("<tr>\n");
					echo ("<td>\n");
					echo ("Confirm Email:\n");
					echo ("</td>\n");
					echo ("<td>\n");
					echo (form_input(array("type" => "text", "name" => "email_confirm")));
					echo ("</td>\n");
					echo ("</tr>\n");
					echo ("<tr>\n");
					echo ("<td>\n");
					echo ("Password:\n");
					echo ("</td>\n");
					echo ("<td>\n");
					echo (form_password(array("name" => "password")));
					echo ("</td>\n");
					echo ("</tr>\n");
					echo ("<tr>\n");
					echo ("<td>\n");
					echo ("Confirm Password:\n");
					echo ("</td>\n");
					echo ("<td>\n");
					echo (form_password(array("name" => "password_confirm")));
					echo ("</td>\n");
					echo ("</tr>\n");
					echo ("<tr>\n<td>\n<br />\n</td>\n</tr>\n");
					echo ("<tr>\n");
					echo ("<td>\n");
					echo (form_submit(array("name" => "submitNew", "style" => "width: 100%"), "Submit"));
					echo ("</td>\n");
					echo ("<td>\n");
					echo (form_reset(array("name" => "resetNew", "style" => "width: 100%"), "Reset"));
					echo ("</td>\n");
					echo ("</tr>\n");
					echo ("</table>\n");
					echo (form_close());
					echo ("<br />\n");
					if (isset($_SESSION["form_id"]))
						if ($_SESSION["form_id"] == 3)
							echo ("<p align=center><font color=red>" . validation_errors() . "</font></p>");
					echo ("<h2>Add a new prospect</h2>\n");
					echo (form_open("/LoginController/ValidateProspect"));
					echo ("<table align=center>\n");
					echo ("<tr>\n");
					echo ("<td>\n");
					echo ("Email:\n");
					echo ("</td>\n");
					echo ("<td>\n");
					echo (form_input(array("type" => "text", "name" => "prospect_email")));
					echo ("</td>\n");
					echo ("</tr>\n");
					echo ("<tr>\n");
					echo ("<td>\n");
					echo ("Confirm Email:\n");
					echo ("</td>\n");
					echo ("<td>\n");
					echo (form_input(array("type" => "text", "name" => "prospect_confirm")));
					echo ("</td>\n");
					echo ("</tr>\n");
					echo ("<tr>\n");
					echo ("<td>\n");
					echo ("Phone Number:\n");
					echo ("</td>\n");
					echo ("<td>\n");
					echo (form_input(array("type" => "text", "name" => "prospect_phone")));
					echo ("</td>\n");
					echo ("</tr>\n");
					echo ("<tr>\n<td>\n<br />\n</td>\n</tr>\n");
					echo ("<tr>\n");
					echo ("<td>\n");
					echo (form_submit(array("name" => "submitProspect", "style" => "width: 100%"), "Submit"));
					echo ("</td>\n");
					echo ("<td>\n");
					echo (form_reset(array("name" => "resetProspect", "style" => "width: 100%"), "Reset"));
					echo ("</td>\n");
					echo ("</tr>\n");
					echo ("</table>");
					echo (form_close());
				?>
			</div>
		</div>
		<div id="fourthTabContent" class="inActiveTabContent">
			<div style="margin-top: 10px; margin-left: 15%; margin-right: 15%">
				<?php 
					$query = $this->db->get("minors");
					echo (form_label("List of Minors at Southern Connecticut State University"));
					if ($query->num_rows() > 0) {
						echo ("<table align=center class = classesTable>");
						echo ("<tr>");
						for ($i = 0; $i < $query->num_rows(); $i++) {
							if ($i % 3 == 0) {
								echo ("</tr>\n");
								echo ("<tr>\n");
							}
							echo ("<td>\n");
							echo ($query->row($i)->Name);
							echo ("</td>\n");
						}
						echo("</table>");
					}
				?>
			</div>
		</div>
		<div id="fifthTabContent" class="inactiveTabContent">
			<div style="margin-top: 10px; margin-left: 15%; margin-right: 15%;">
				<?php 
					$prospects = $this->db->get("prospects");
					if ($prospects->num_rows() > 0) {
						echo ("<table class=prospectsTable align=center>\n");
						echo ("<th>Email</th>\n");
						echo ("<th>Phone Number</th>\n");
						foreach ($prospects->result() as $row) {
							echo ("<tr>\n");
							echo ("<td>\n");
							echo ($row->Email . "\n");
							echo ("</td>\n");
							echo ("<td>\n");
							echo ($row->Phone_Number . "\n");
							echo ("</td>\n");
							echo ("</tr>\n");
						}
						echo ("</table>\n");
					}
				?>
			</div>
		</div>
		<div id="logout" class="inactiveTabContent">
			<?php 
				echo (form_open("LoginController/Logout", array("id" => "logoutForm")));
				echo (form_close());
			?>
		</div>
	</div>
</div>
</body>
</html>
