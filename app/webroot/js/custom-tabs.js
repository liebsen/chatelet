const myTabs = document.querySelectorAll(".custom-tabs ul.nav-tabs > li");  
const panes = document.querySelectorAll(".custom-tabs .tab-pane");
const tabAction = Object.keys(myTabs).map((tab)=>{
  myTabs[tab].addEventListener("click", (e) => {
    makeInactive(myTabs);
    activateTab(e);
    makeInactive(panes);
    activateTabContent(e);
    e.preventDefault();
	});
});

function makeInactive(items) {
  const content = Object.keys(items).map((item)=> {
    items[item].classList.remove("active");
  });  
}

function activateTab(e) {
	//refers to the element whose event listener triggered the event
  const clickedTab = e.currentTarget;
  const hash = $(clickedTab).find('a').prop('href').split('#')[1]
  clickedTab.classList.add("active");
  location.hash = hash
}

function activateTabContent(e) {	                 
	// gets the element on which the event originally occurred
	const anchorReference = e.target;
  const href = anchorReference.getAttribute("href")
	const activePaneID = href ? href.replace('#','.').replace('.', '.pane-') : '';
	const activePane = document.querySelector(activePaneID);
	activePane.classList.add("active");     
}

document.addEventListener('DOMContentLoaded', (event) => {
  // console.log('DOM fully loaded and parsed');
	if(location.hash && document.querySelector(`a[href="${location.hash}"]`)) {
		document.querySelector(`a[href="${location.hash}"]`).click()
	}
});
