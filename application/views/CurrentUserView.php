<?php include 'includes/header.php';

	$this->load->helper("form");	

?>
<html>
<head>
<style type="text/css">
	.centerTabs {
		background: white;
		height: 100%;
		margin-left: 15%;
		margin-right: 15%;
	}
	
	.selectedTab {
		background: gold;
		color: black;
	}
	
	.inactiveTab {
		background: 0099FF;
		color: black;
	}
	
	.tabHover {
		background: 00CCFF;
		color: black;
	}
	
	.tabContainer {
		background: gray;
		position: relative;
		width: 100%;
		height: 5%;
	}
	
	.activeTabContent {
		position: relative;
		visibility: visible;
	}
	
	.inactiveTabContent {
		position: absolute;
		visibility: hidden;
		height: 100%;
	}
	
	.collapsedContent {
		position: relative;
		margin-left: 15%;
		margin-right: 15%;
		visibility: hidden;
	}
	
	.visibleContent {
		position: relative;
		margin-left: 15%;
		margin-right: 15%;
		visibility: visible;
	}
	
	.tabContainerTable {
		position: relative;
		width: 100%;
		height: 100%;
		
	}
	
		.classesTable {
		border-style: solid;
		border-width: 1px;
		border-color: #DAA520;
	}
	
	.classesTable td {
		background: white;
		color: black;
	}
	
	.classesTable th {
		background: #FFD700;
		color: black;
	}
	
</style>
<script type="text/javascript">

	// todo: mouseleave handler for tabs

	var currentTab = 0;

	function Load() {
	}

	function tab_enter(tabID) {
		if (tabID == 0) {
			if (currentTab == 1 || currentTab == 2 || currentTab == 3) {
				document.getElementById("firstTab").className = "tabHover";
				return;
			}
		}
		if (tabID == 1) {
			if (currentTab == 0 || currentTab == 2 || currentTab == 3) {
				document.getElementById("secondTab").className = "tabHover";
				return;
			}
		}
		if (tabID == 2) {
			if (currentTab == 0 || currentTab == 1 || currentTab == 3){
				document.getElementById("thirdTab").className = "tabHover";
				return;
			}
		}
	}

	function tab_leave(tabID) {
		if (currentTab == 0) {
			document.getElementById("secondTab").className = "inactiveTab";
			document.getElementById("thirdTab").className = "inactiveTab";
		}
		if (currentTab == 1) {
			document.getElementById("firstTab").className = "inactiveTab";
			document.getElementById("thirdTab").className = "inactiveTab";
		}
		if (currentTab == 2){
			document.getElementById("firstTab").className = "inactiveTab";
			document.getElementById("secondTab").className = "inactiveTab";
		}
	}

	function tab_click(tabID) {
		// event handler for tabs
		if (tabID == 0) { // tabID 0 indicates the first tab was clicked, so show the content in the first tab and set the current tab
			if (currentTab != 0) {
				currentTab = 0;
				document.getElementById("firstTab").className = "selectedTab";
				document.getElementById("secondTab").className = "inactiveTab";
				document.getElementById("thirdTab").className = "inactiveTab";
				document.getElementById("firstTabContent").className = "activeTabContent";
				document.getElementById("secondTabContent").className = "inactiveTabContent";
				document.getElementById("thirdTabContent").className = "inactiveTabContent";
			}
		}
		if (tabID == 1) { // tabID 1 indicates the second tab was clicked, so show the content in the second tab and set the current tab
			if (currentTab != 1) {
				currentTab = 1;
				document.getElementById("secondTab").className = "selectedTab";
				document.getElementById("firstTab").className = "inactiveTab";
				document.getElementById("thirdTab").className = "inactiveTab";
				document.getElementById("secondTabContent").className = "activeTabContent";
				document.getElementById("firstTabContent").className = "inactiveTabContent";
				document.getElementById("thirdTabContent").className = "inactiveTabContent";
			}
		}
		if (tabID == 2) { // tabID 2 indicates the third tab was clicked, so show the content in the third tab and set the current tab
			if (currentTab != 2) {
				currentTab = 2;
				document.getElementById("thirdTab").className = "selectedTab";
				document.getElementById("secondTab").className = "inactiveTab";
				document.getElementById("firstTab").className = "inactiveTab";
				document.getElementById("thirdTabContent").className = "activeTabContent";
				document.getElementById("secondTabContent").className = "inactiveTabContent";
				document.getElementById("firstTabContent").className = "inactiveTabContent";
			}
		}
	}
	
</script>
<title>Current Students</title>
</head>
<body onLoad="Load">
<div class="centerTabs" id="tabs" align="center">
	<div class="tabContainer">
		<table class="tabContainerTable">
			<tr>
				<td id="firstTab" class="selectedTab" align="center" onMouseOver="tab_enter(0)" onClick="tab_click(0)" onMouseOut="tab_leave(0)">
					<p style="color: inherit">Create A Minor</p>
				</td>
				<td id="secondTab" class="inactiveTab" align="center" onMouseOver="tab_enter(1)" onMouseOut="tab_leave(1)" onClick="tab_click(1)">
					Submit A Major for Approval
				</td>
				<td id="thirdTab" class="inactiveTab" align="center" onMouseOver="tab_enter(2)" onClick="tab_click(2)" onMouseOut="tab_leave(2)">
					Manage Schedule
				</td>
			</tr>
		</table>
	</div>
	<div>
		<div id="firstTabContent" class="activeTabContent">
		<?php 
			if (isset($_SESSION) == false) {
				session_start();
			}
			$minor_check = $this->db->get_where("approvedminors", "approvedminors.studentid = " . $_SESSION["StudentID"]);
			$request_check = $this->db->get_where("minorrequests", "minorrequests.studentid = " . $_SESSION["StudentID"]);
			if (isset($minor_submit_success)) {
				echo ("<p align=center><h3>" . $minor_submit_success . "</h3></p>");
			}
			if ($minor_check->num_rows() > 0) {
				echo ("<p align=center><h3>You have an approved minor. You may not create another one.</h3></p>\n");
				echo ("<p align=center>The details of your minor are listed below</p>\n");
				$this->db->select("*");
				$this->db->from("classes");
				$this->db->where("approvedminors.studentid", $_SESSION["StudentID"]);
				$this->db->join("approvedminors", "approvedminors.id = classes.approvedid");
				$query = $this->db->get();
				echo ("<table class=classesTable width=40%>\n");
				echo ("<th>Classes</th>");
				foreach ($query->result() as $row) {
					echo ("<tr>\n");
					echo ("<td align=center>\n");
					echo ($row->Name . "\n");
					echo ("</td>\n");
					echo ("</tr>\n");
				}
				echo ("</table>\n");
			}
			else if ($request_check->num_rows() > 0) {
				echo ("<p align=center><h3>You have an outstanding minor request. You may not submit another one at this time.</h3>\n");
			}
			else {
				if (isset($_SESSION["form_id"]))
					if ($_SESSION["form_id"] == 0)
						echo ("<p align=center><font color=red>" . validation_errors() . "</font></p>");
				echo ("<p align=center>Please enter six courses into the form below. Click submit when you are finished and your minor will be submitted for approval by an advisor.</p>");
				echo ("\n<br />\n");
				echo (form_open("LoginController/CheckMinor"));
				echo ("\n<table align=center>\n");
				for ($i = 1; $i < 7; $i++) {
					echo ("<tr>\n");
					echo ("<td>\n");
					echo ("Course #" . $i . ":");
					echo ("</td>\n");
					echo ("<td>\n");
					echo (form_input(array("id" => "minorClass" . $i, "name" => "minorClass" . $i, "type" => "text")));
					echo ("</td>");
					echo ("</tr>\n");
				}
				echo ("<tr>\n");
				echo ("<td colspan=2>\n");
				echo (form_submit(array("name" => "minorSubmit", "value" => "Submit", "style" => "width: 47%; margin-right: 3%")));
				echo (form_reset(array("name" => "minorReset", "style" => "width: 47%; margin-left: 3%"), "Reset"));
				echo ("</td>\n");
				echo ("</tr>\n");
				echo ("</table>");
				echo (form_close() . "\n");
			}
		?>
		</div>
		<div id="secondTabContent" class="inactiveTabContent">
			<div style="margin-top: 10px; margin-left: 15%; margin-right: 15%">
				<?php 
					$query = $this->db->get_where("minorrequests", "minorrequests.studentid = " . $_SESSION["StudentID"]);
					$approval_query = $this->db->get_where("approvedminors", "approvedminors.studentid = " . $_SESSION["StudentID"]);
					$majors_approved = $this->db->get_where("approvedmajors", "approvedmajors.studentid = " . $_SESSION["StudentID"]);
					if ($query->num_rows() > 0) {
						echo ("<p align=center><h3>You have an outstanding minor request. You may not submit your major for approval until this request has been approved.</h3>");
					}
					else if ($majors_approved->num_rows() > 0) {
						echo ("<p align=center><h3>Your major has been approved. You may not submit another for approval.</h3>");
						echo ("<p align=center>The details of your major are listed below</p>\n");
						echo ("<table class=classesTable width=40%>\n");
						echo ("<th>Your Minors</th>");
						$row = $majors_approved->row();
						echo ("<tr>\n");
						echo ("<td align=center>\n");
						echo ($row->Minor1 . "\n");
						echo ("</td>\n");
						echo ("</tr>\n");
						echo ("<tr>\n");
						echo ("<td align=center>\n");
						echo ($row->Minor2 . "\n");
						echo ("</td>\n");
						echo ("</tr>\n");
						if ($row->Minor3 != null) {			
							echo ("<tr>\n");
							echo ("<td align=center>\n");
							echo ($row->Minor3);
							echo ("</td>\n");
							echo ("</tr>\n");
						}
						echo ("</table>\n");
					}
					else if ($approval_query->num_rows() > 0) {
						$major_request_check = $this->db->get_where("majorrequests", "majorrequests.studentid = " . 
											$_SESSION["StudentID"]);
						if ($major_request_check->num_rows() <= 0) {
							if (isset($errors)) {
								echo (validation_errors());
								echo ("<p><font color=red weight=bold>" . $errors . "</font></p>");
							}
							echo ("You have an approved minor. Please select at least one more minor, then click submit.");
							echo (form_open("/LoginController/CheckMajor"));
							echo ("<table align=center width=70%>\n");
							echo ("<tr>\n");
							echo ("<td align=right>\n");
							echo ("Self-Designed Minor:");
							echo ("</td>\n");
							echo ("<td>");
							echo ("<select name=MinorSelect1 id=MinorSelect1 style=width:100%>\n");
							echo ("<option value=" . $approval_query->row(0)->MinorName . ">" . $approval_query->row()->MinorName . "</option>\n");
							echo ("</select>\n");
							echo ("</td>\n");
							echo ("</tr>\n");
							echo ("<tr>\n");
							echo ("<td align=right>\n");
							echo ("Please select a second minor: \n");
							echo ("</td>\n");
							echo ("<td>\n");
							echo ("<select name=MinorSelect2 id=MinorSelect2 style=width:100%>\n");
							echo ("<option value=empty selected>Please select a minor</option>");
							$minors = $this->db->get("minors");
							foreach($minors->result() as $row) {
								echo ("<option value=" . $row->Name . ">" . $row->Name . "</option>\n");
							}
							echo ("</select>\n");
							echo ("</td>\n");
							echo ("</tr>\n");
							echo ("<tr><br />\n");
							echo ("<td align=right>\n");
							echo ("Please select your third minor:  ");
							echo ("</td>\n");
							echo ("<td>\n");
							echo ("<select name=MinorSelect3 id=MinorSelect3 style=width:100%>\n");
							echo ("<option value=none selected>None</option>");
							foreach($minors->result() as $row) {
								echo ("<option value=" . $row->Name . ">" . $row->Name . "</option>\n");
							}
							echo ("</td>");
							echo ("</tr><br />\n");
							echo ("</table>\n");
							echo ("<br />\n");
							echo (form_submit(array("style" => "width: 150px", "name" => "majorSubmit"), "Submit Major") . "\n");
							echo (form_reset(array("style" => "width: 150px", "name" => "majorReset"), "Reset Form") . "\n");
							echo (form_close() . "\n");
						}
						else {
							echo ("<p>You have an outstanding major request. You may not submit another request unless your current request is rejected.");
						}
					}
					else {
						if (isset($errors)) {
							echo ("<p><font color=red weight=bold>" . $errors . "</font></p>\n");
						}
						echo ("<p align=center>From the form below, please select at least two minors and click submit to submit your major for approval.</p>");
						echo (form_open("/LoginController/CheckMajor"));
						echo ("<table align=center width=70%>\n");
						echo ("<tr>\n");
						echo ("<td align=right>\n");
						echo ("Please select your first minor:  ");
						echo ("</td>\n");
						echo ("<td>\n");
						echo ("<select name=MinorSelect1 id=MinorSelect1>\n");
						echo ("<option value=empty selected>Please select a minor</option>");
						$minors = $this->db->get("minors");
						foreach($minors->result() as $row) {
							echo ("<option value=" . $row->Name . ">" . $row->Name . "</option>\n");
						}
						echo ("</select>\n");
						echo ("</tr>\n");
						echo ("<tr>\n");
						echo ("<td align=right>\n");
						echo ("Please select your second minor:  ");
						echo ("</td>\n");
						echo ("<td>\n");
						echo ("<select name=MinorSelect2 id=MinorSelect2>\n");
						echo ("<option value=empty selected>Please select a minor</option>");
						foreach($minors->result() as $row) {
							echo ("<option value=" . $row->Name . ">" . $row->Name . "</option>\n");
						}
						echo ("</select>\n");
						echo ("</tr>\n");
						echo ("<tr>\n");
						echo ("<td align=right>\n");
						echo ("Please select your third minor:  ");
						echo ("</td>\n");
						echo ("<td>\n");
						echo ("<select name=MinorSelect3 id=MinorSelect3>\n");
						echo ("<option value=none selected>None</option>");
						foreach($minors->result() as $row) {
							echo ("<option value=" . $row->Name . ">" . $row->Name . "</option>\n");
						}
						echo ("</select>\n");
						echo ("</td>\n");
						echo ("</tr>\n");
						echo ("</table>\n");
						echo ("<br />\n");
						echo (form_submit(array("style" => "width: 150px", "name" => "submitMajor"), "Submit Major") . "\n");
						echo (form_reset(array("style" => "width: 150px", "name" => "resetMajor"), "Reset Form") . "\n");
						echo (form_close() . "\n");
					}
				?>
			</div>
		</div>
		<div id="thirdTabContent" class="inactiveTabContent">
			<div style="margin-top: 10px; margin-left: 15%; margin-right: 15%">
				<?php 

				echo (form_open("LoginController/CheckSchedule"));
				echo ("<table width=50%>");
				echo ("<tr>");
				echo ("<th>Year 1 - Fall</th>");
				echo ("<th>Year 1 - Spring</th>");
				echo ("<th>Year 2 - Fall</th>");
				echo ("<th>Year 2 - Spring</th>");
				echo ("<th>Year 3 - Fall</th>");
				echo ("<th>Year 3 - Spring</th>");
				echo ("</tr>");
				for ($j = 0; $j<6; $j++) {
					echo ("<tr>\n");
					
					for ($i = 0; $i<3; $i++) {
						echo ("<td align=center>");
						$data = array("name" => "fall" . $i . "_" . $j, "tabindex" => ($i * 2) + 1);
						echo (form_input($data));
						echo ("</td>\n");
						echo ("<td align=center>\n");
						$data = array("name" => "spring" . $i . "_" . $j, "tabindex" => ($i * 2) + 2);
						echo (form_input($data));
						echo ("</td>\n");
					}
					echo ("</tr>\n");
				}
				echo ("</table>");

				echo ("<table width=50%>");
				echo ("<tr>");
				echo ("<th>Year 4 - Fall</th>");
				echo ("<th>Year 4 - Spring</th>");
				echo ("<th>Year 5 - Fall</th>");
				echo ("<th>Year 5 - Spring</th>");
				echo ("<th>Year 6 - Fall</th>");
				echo ("<th>Year 6 - Spring</th>");
				echo ("</tr>");
				for ($j = 0; $j<7; $j++) {
					echo ("<tr>\n");
					if ($j == 6){
					echo ("<td align=center colspan=3>\n");
						echo ("<br />");
					echo ("Use the space below to leave comments for each semester");
					echo ("</td>\n");
					echo ("</tr>\n");
					echo ("<tr>\n");
					}
					for ($i = 4; $i<7; $i++) {
						echo ("<td align=center>");
						$data = array("name" => "fall" . $i . "_" . $j, "tabindex" => ($i * 2) + 1);
						echo (form_input($data));
						echo ("</td>\n");
						echo ("<td align=center>\n");
						$data = array("name" => "spring" . $i . "_" . $j, "tabindex" => ($i * 2) + 2);
						echo (form_input($data));
						echo ("</td>\n");
					}
					echo ("</tr>\n");
				}
				echo ("<tr>\n");
				echo ("<td align=center colspan=6>\n");
				echo (form_submit(array("name" => "SubmitSchedule", "style" => "width: 150px; height: 30px;"), "Submit Schedule") . "   ");
				echo (form_reset(array("name" => "ResetSchedule", "style" => "width: 150px; height: 30px;"), "Reset Schedule"));
				echo ("</td>\n");
				echo ("</tr>\n");
				echo ("</table>\n");
				echo (form_close());
				?>
			</div>
		</div>
	</div>
</div>
</body>
</html>