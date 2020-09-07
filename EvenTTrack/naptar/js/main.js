//kitörli a classokat
function removeClass(elem, classNeve){
    if(elem.classList.contains(classNeve)){
        elem.classList.remove(classNeve);
    }
}


function removeAttribute(elem, attrNeve){
    if(elem.hasAttribute(attrNeve)){
        elem.removeAttribute(attrNeve);
    }
}