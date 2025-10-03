
	const myTabs = document.querySelectorAll(".custom-tabs ul.nav-tabs > li");  
	const panes = document.querySelectorAll(".custom-tabs .tab-pane");
	const tabAction = Object.keys(myTabs).map((tab)=>{
    myTabs[tab].addEventListener("click", (e)=> {

      makeInactive(myTabs);
      activateTab(e);
      makeInactive(panes);
      activateTabContent(e);
     
      e.preventDefault();
  	});
	});
	             
   /*
    *Makes a tab and it's content incactive
    */
  function makeInactive(items) {
               
    const content = Object.keys(items).map((item)=> {
      items[item].classList.remove("active");
            
    });  
         
  }
             
    /*
     *Display the selected tab.
     */
  function activateTab(e) {
                 
  	//refers to the element whose event listener triggered the event
    const clickedTab = e.currentTarget;
    clickedTab.classList.add("active");
	                 
	}
	             
	  /*
	   * Display the selected tab content.
	   */
	function activateTabContent(e) {
	                 
	   // gets the element on which the event originally occurred
	   const anchorReference = e.target;
	   const activePaneID = anchorReference.getAttribute("href");
	   const activePane = document.querySelector(activePaneID);
	   activePane.classList.add("active");     
	}
