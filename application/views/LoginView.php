<?php

	$this->load->helper("form");	

?>
<html>
<head>
<link rel="stylesheet" href="../../styles/default.css" />
<script type="text/javascript">

	// todo: mouseleave handler for tabs

	var currentTab = 0;

	function Load() {
	}

	function tab_enter(tabID) {
		if (tabID == 0) {
			if (currentTab == 1) {
				document.getElementById("loginTab").className = "tabHover";
				return;
			}
		}
		if (tabID == 1) {
			if (currentTab == 0) {
				document.getElementById("prospectTab").className = "tabHover";
				return;
			}
		}
	}

	function tab_leave(tabID) {
		if (currentTab == 0) {
			document.getElementById("prospectTab").className = "inactiveTab";
		}
		else {
			document.getElementById("loginTab").className = "inactiveTab";
		}
	}

	function tab_click(tabID) {
		// event handler for tabs
		if (tabID == 0) { // tabID 0 indicates the login tab was clicked, so show the content in the login tab and set the current tab
			if (currentTab == 1) {
				currentTab = 0;
				document.getElementById("loginTab").className = "selectedTab";
				document.getElementById("prospectTab").className = "inactiveTab";
				document.getElementById("loginContent").className = "activeTabContent";
				document.getElementById("prospectContent").className = "inactiveTabContent";
			}
		}
		else { // tabID 1 indicates the prospective users tab was clicked
			if (currentTab == 0) {
				currentTab = 1;
				document.getElementById("prospectTab").className = "selectedTab";
				document.getElementById("loginTab").className = "inactiveTab";
				document.getElementById("prospectContent").className = "activeTabContent";
				document.getElementById("loginContent").className = "inactiveTabContent";
			}
		}
	}
</script>
<title>Login</title>
</head>
<body onLoad="Load">
<?php echo(validation_errors()); ?>
<table align="center" style="height: 80%; width: auto">
<tr>
<td valign="middle">
<h2>Welcome to the Major Management System</h2>
</td>
</tr>
<tr>
<td align="center" valign="middle">
	<div class="centerTabs" id="tabs" align="center">
		<div class="tabContainer">
			<table style="position: relative; width: 100%; height: 100%;">
				<tr>
					<td id="loginTab" class="selectedTab" align="center" onMouseOver="tab_enter(0)" onClick="tab_click(0)" onMouseOut="tab_leave(0)">
						<p style="color: inherit">Sign In</p>
					</td>
	
				</tr>
			</table>
		</div>
		<div>
			<div id="loginContent" class="activeTabContent">
				<div style="margin-top: 10px; margin-left: 15%; margin-right: 15%">
				<table style="position: relative; width: 100%;">
					<tr>
					<td align=center valign=middle>
					<?php 
						echo form_open("/LoginController/ValidateForm");
						$userInput = array("type" => "text", "id" => "userName", "name" => "userName", 
										   "style" => "width: 40%; height: 20px;");
						$passwordInput = array("type" => "text", "id" =>"passWord", "name" => "passWord", 
											   "style" => "width: 40%; height: 20px");
						$submitButton = array("type" => "submit", "id" => "submit", "name" => "submit", 
											  "style" => "width: 18%; height: 25px", "value" => "Submit");
						$clearButton = array("type" => "button", "id" => "btnClear", "name" => "btnClear",
											 "style" => "width: 18%; height: 25px; margin-left: 4%", "value" => "Clear");
						echo(form_label("Username", "labelUser", null) . "<br />");
						echo (form_input($userInput) . "<br />");
						echo (form_label("Password") . "<br />");
						echo (form_password($passwordInput) . "<br />");
						echo (form_submit($submitButton));
						echo (form_input($clearButton));
						echo form_close(); 
					?>
					</td>
					</tr>
				</table>
				</div>
			</div>
			<div id="prospectContent" class="inactiveTabContent">
				<div style="margin-top: 10px; margin-left: 15%; margin-right: 15%">

					<?php 
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
	</div>
</td>
</tr>
</table>
</body>
</html>