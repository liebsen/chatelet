

document.addEventListener('DOMContentLoaded', (event) => {


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
    const href = $(e.target).attr("href") ?? $(e.target).parent().attr("href")
    const activePaneID = href ? href.replace('#','.').replace('.', '.pane-') : '';
    setTimeout(function(){
      const activePane = $(activePaneID);
      activePane.addClass("active");     
    }, 100)
  }

  const myTabs = document.querySelectorAll(".custom-tabs ul.nav-tabs > li");  
  const panes = document.querySelectorAll(".custom-tabs .tab-pane");
  const tabAction = Object.keys(myTabs).map((tab)=>{
    myTabs[tab].addEventListener("click", (e) => {
      e.preventDefault();
      makeInactive(myTabs);
      activateTab(e);
      makeInactive(panes);
      activateTabContent(e);
    });
  });


  // console.log('DOM fully loaded and parsed');
	if(location.hash && document.querySelector(`a[href="${location.hash}"]`)) {
		document.querySelector(`a[href="${location.hash}"]`).click()
	}
});
