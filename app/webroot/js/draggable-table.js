(function() {
  "use strict";
  
  const table = document.querySelector('.table');
  const tbody = table.querySelector('tbody');
  var currRow = null,
      row1,row2,
      dragElem = null,
      mouseDownX = 0,
      mouseDownY = 0,         
      mouseX = 0,
      mouseY = 0,      
      mouseDrag = false;  
  
  function init() {
    window.document.body.insertAdjacentHTML( 'afterbegin', '<div class="draggable-saved animated"><i class="fa fa-thumbs-o-up fa-lg"></i></div>' );
    bindMouse();
  }
  
  function bindMouse() {
    document.addEventListener('mousedown', (event) => {
      if(event.button != 0) return true;
      
      let target = getTargetRow(event.target);
      if(target) {
        currRow = target;
        addDraggableRow(target);
        currRow.classList.add('is-dragging');


        let coords = getMouseCoords(event);
        mouseDownX = coords.x;
        mouseDownY = coords.y;      

        mouseDrag = true;   
      }
    });
    
    document.addEventListener('mousemove', (event) => {
      if(!mouseDrag) return;
      
      let coords = getMouseCoords(event);
      mouseX = coords.x - mouseDownX;
      mouseY = coords.y - mouseDownY;  
      
      moveRow(mouseX, mouseY);
    });
    
    document.addEventListener('mouseup', (event) => {
      if(!mouseDrag) return;
      currRow.classList.remove('is-dragging');
      table.removeChild(dragElem);
      dragElem = null;
      mouseDrag = false;
      if(!row1) return;
      //const order1 = row1.attributes['data-order'].value
      //const ordernum = row2.attributes['data-order'].value
      const current = mouseY < 0 ? row1 : row2
      const ordernum = current.rowIndex
      const id = current.attributes['data-id'].value
      $.post(table.getAttribute('data-url'), {
        id: id,
        ordernum: ordernum
      }).then((res) => {
        row1.attributes['data-order'].value = ordernum
        //row2.attributes['data-order'].value = order1
        clearSelection()
        showDone()
      })
    })
  }  

  function showDone(){
    document.querySelector('.draggable-saved').classList.remove('chatOut')
    document.querySelector('.draggable-saved').classList.add('chatIn')
    setTimeout(() => {
      document.querySelector('.draggable-saved').classList.remove('chatIn')
      document.querySelector('.draggable-saved').classList.add('chatOut')
    }, 5000)
  }
  function clearSelection(){ 
    if (window.getSelection) {
      window.getSelection().removeAllRanges();
    }
    else if (document.selection) {
      document.selection.empty();
    }
  }
  
  function swapRow(row, index) {
     let currIndex = Array.from(tbody.children).indexOf(currRow)
     row1 = currIndex > index ? currRow : row
     row2 = currIndex > index ? row : currRow;
         
     tbody.insertBefore(row1, row2);
  }
    
  function moveRow(x, y) {
    dragElem.style.transform = "translate3d(" + x + "px, " + y + "px, 0)";
    
    let dPos = dragElem.getBoundingClientRect(),
        currStartY = dPos.y, currEndY = currStartY + dPos.height,
        rows = getRows();

    for(var i = 0; i < rows.length; i++) {
      let rowElem = rows[i],
          rowSize = rowElem.getBoundingClientRect(),
          rowStartY = rowSize.y, rowEndY = rowStartY + rowSize.height;

      if(currRow !== rowElem && isIntersecting(currStartY, currEndY, rowStartY, rowEndY)) {
        if(Math.abs(currStartY - rowStartY) < rowSize.height / 2)
          swapRow(rowElem, i);
      }
    }    
  }
  
  function addDraggableRow(target) {    
      dragElem = target.cloneNode(true);
      dragElem.classList.add('draggable-table__drag');
      dragElem.style.height = getStyle(target, 'height');
      dragElem.style.background = getStyle(target, 'backgroundColor');     
      for(var i = 0; i < target.children.length; i++) {
        let oldTD = target.children[i],
            newTD = dragElem.children[i];
        newTD.style.width = getStyle(oldTD, 'width');
        newTD.style.height = getStyle(oldTD, 'height');
        newTD.style.padding = getStyle(oldTD, 'padding');
        newTD.style.margin = getStyle(oldTD, 'margin');
      }      
      
      table.appendChild(dragElem);

    
      let tPos = target.getBoundingClientRect(),
          dPos = dragElem.getBoundingClientRect();
      dragElem.style.bottom = ((dPos.y - tPos.y) - tPos.height) + "px";
      dragElem.style.left = "-1px";    
    
      document.dispatchEvent(new MouseEvent('mousemove',
        { view: window, cancelable: true, bubbles: true }
      ));    
  }  
    
  function getRows() {
    return table.querySelectorAll('tbody tr');
  }    
  
  function getTargetRow(target) {
      let elemName = target.tagName.toLowerCase();

      if(elemName == 'tr') return target;
      if(elemName == 'td') return target.closest('tr');     
  }
  
  function getMouseCoords(event) {
    return {
        x: event.clientX,
        y: event.clientY
    };    
  }  
  
  function getStyle(target, styleName) {
    let compStyle = getComputedStyle(target),
        style = compStyle[styleName];

    return style ? style : null;
  }  
  
  function isIntersecting(min0, max0, min1, max1) {
      return Math.max(min0, max0) >= Math.min(min1, max1) &&
             Math.min(min0, max0) <= Math.max(min1, max1);
  }  
  
  
  
  init();
  
})();