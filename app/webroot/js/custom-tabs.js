
document.addEventListener('DOMContentLoaded', (event) => {
  function makeInactive(items) {
    const content = Object.keys(items).map((item)=> {
      items[item].classList.remove("active");
    });  
  }

  function activateTab(e) {
    //refers to the element whose event listener triggered the event
    const clickedTab = e.currentTarget;
    const hash = $(clickedTab).prop('href').split('#')[1]
    $(clickedTab).parents('ul').find('li').removeClass("active");
    $(clickedTab).find('li').addClass("active");
    location.hash = hash
  }

  function activateTabContent(e) {             
    const href = $(e.target).attr("href") ?? $(e.target).parents('a').attr("href")
    const activePaneID = href ? href.replace('#','.').replace('.', '.pane-') : '';
    setTimeout(function(){
      const activePane = $(activePaneID);
      activePane.addClass("active");     
    }, 100)
  }

  const myTabs = document.querySelectorAll(".custom-tabs ul.list-group > a");  
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
