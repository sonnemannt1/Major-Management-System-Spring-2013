
	// todo: mouseleave handler for tabs

	var currentTab = 0;
	
	function tab_enter(tabID) {
		if (tabID == 0) {
			if (currentTab == 1 || currentTab == 2 || currentTab == 3 || currentTab == 4) {
				document.getElementById("firstTab").className = "tabHover";
				return;
			}
		}
		if (tabID == 1) {
			if (currentTab == 0 || currentTab == 2 || currentTab == 3 || currentTab == 4) {
				document.getElementById("secondTab").className = "tabHover";
				return;
			}
		}
		if (tabID == 2) {
			if (currentTab == 0 || currentTab == 1 || currentTab == 3 || currentTab == 4){
				document.getElementById("thirdTab").className = "tabHover";
				return;
			}
		}
		if (tabID == 3) {
			if (currentTab == 0 || currentTab == 1 || currentTab == 2 || currentTab == 4) {
				document.getElementById("fourthTab").className = "tabHover";
			}
		}
		if (tabID == 4) {
			if (currentTab == 0 || currentTab == 1 || currentTab == 2 || currentTab == 3) {
				document.getElementById("fifthTab").className = "tabHover";
			}
		}
	}

	function tab_leave(tabID) {
		if (currentTab == 0) {
			document.getElementById("secondTab").className = "inactiveTab";
			document.getElementById("thirdTab").className = "inactiveTab";
			document.getElementById("fourthTab").className = "inactiveTab";
			document.getElementById("fifthTab").className = "inactiveTab";
		}
		if (currentTab == 1) {
			document.getElementById("firstTab").className = "inactiveTab";
			document.getElementById("thirdTab").className = "inactiveTab";
			document.getElementById("fourthTab").className = "inactiveTab";
			document.getElementById("fifthTab").className = "inactiveTab";
		}
		if (currentTab == 2){
			document.getElementById("firstTab").className = "inactiveTab";
			document.getElementById("secondTab").className = "inactiveTab";
			document.getElementById("fourthTab").className = "inactiveTab";
			document.getElementById("fifthTab").className = "inactiveTab";
		}
		if (currentTab == 3) {
			document.getElementById("firstTab").className = "inactiveTab";
			document.getElementById("secondTab").className = "inactiveTab";
			document.getElementById("thirdTab").className = "inactiveTab";
			document.getElementById("fifthTab").className = "inactiveTab";
		}
		if (currentTab == 4) {
			document.getElementById("firstTab").className = "inactiveTab";
			document.getElementById("secondTab").className = "inactiveTab";
			document.getElementById("thirdTab").className = "inactiveTab";
			document.getElementById("fourthTab").className = "inactiveTab";
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
				document.getElementById("fourthTab").className = "inactiveTab";
				document.getElementById("fifthTab").className = "inactiveTab";
				document.getElementById("firstTabContent").className = "activeTabContent";
				document.getElementById("secondTabContent").className = "inactiveTabContent";
				document.getElementById("thirdTabContent").className = "inactiveTabContent";
				document.getElementById("fourthTabContent").className = "inactiveTabContent";
				document.getElementById("fifthTabContent").className = "inactiveTabContent";
			}
		}
		if (tabID == 1) { // tabID 1 indicates the second tab was clicked, so show the content in the second tab and set the current tab
			if (currentTab != 1) {
				currentTab = 1;
				document.getElementById("secondTab").className = "selectedTab";
				document.getElementById("firstTab").className = "inactiveTab";
				document.getElementById("thirdTab").className = "inactiveTab";
				document.getElementById("fourthTab").className = "inactiveTab";
				document.getElementById("fifthTab").className = "inactiveTab";
				document.getElementById("secondTabContent").className = "activeTabContent";
				document.getElementById("firstTabContent").className = "inactiveTabContent";
				document.getElementById("thirdTabContent").className = "inactiveTabContent";
				document.getElementById("fourthTabContent").className = "inactiveTabContent";
				document.getElementById("fifthTabContent").className = "inactiveTabContent";
			}
		}
		if (tabID == 2) { // tabID 2 indicates the third tab was clicked, so show the content in the third tab and set the current tab
			
			if (currentTab != 2) {
				currentTab = 2;
				document.getElementById("thirdTab").className = "selectedTab";
				document.getElementById("secondTab").className = "inactiveTab";
				document.getElementById("firstTab").className = "inactiveTab";
				document.getElementById("fourthTab").className = "inactiveTab";
				document.getElementById("fifthTab").className = "inactiveTab";
				document.getElementById("thirdTabContent").className = "activeTabContent";
				document.getElementById("secondTabContent").className = "inactiveTabContent";
				document.getElementById("firstTabContent").className = "inactiveTabContent";
				document.getElementById("fourthTabContent").className = "inactiveTabContent";
				document.getElementById("fifthTabContent").className = "inactiveTabContent";
			}
		}
		if (tabID == 3) {
			if (currentTab != 3){
				currentTab = 3;
				document.getElementById("fourthTab").className = "selectedTab";
				document.getElementById("secondTab").className = "inactiveTab";
				document.getElementById("firstTab").className = "inactiveTab";
				document.getElementById("thirdTab").className = "inactiveTab";
				document.getElementById("fifthTab").className = "inactiveTab";
				document.getElementById("secondTabContent").className = "inactiveTabContent";
				document.getElementById("firstTabContent").className = "inactiveTabContent";
				document.getElementById("thirdTabContent").className = "inactiveTabContent";
				document.getElementById("fourthTabContent").className = "activeTabContent";
				document.getElementById("fifthTabContent").className = "inactiveTabContent";
			}
		}
		if (tabID == 4) {
			if (currentTab != 4){
				currentTab = 4;
				document.getElementById("fourthTab").className = "inactiveTab";
				document.getElementById("secondTab").className = "inactiveTab";
				document.getElementById("firstTab").className = "inactiveTab";
				document.getElementById("thirdTab").className = "inactiveTab";
				document.getElementById("fifthTab").className = "selectedTab";
				document.getElementById("secondTabContent").className = "inactiveTabContent";
				document.getElementById("firstTabContent").className = "inactiveTabContent";
				document.getElementById("thirdTabContent").className = "inactiveTabContent";
				document.getElementById("fourthTabContent").className = "inactiveTabContent";
				document.getElementById("fifthTabContent").className = "activeTabContent";
			}
		}
	}

	function logout() {
		document.getElementById("logoutForm").submit();
	}