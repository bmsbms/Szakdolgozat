var modal = document.getElementById("modal");


function megnyitasModal(szam){
    modal.open = true;
    modal.classList.add("fade-in");
    switch(szam) {
        case 1: adatok.aktualis_modal_popup = 1; break;
        case 2: adatok.aktualis_modal_popup = 2; break;
    }
}



function bezarasModal(){
    modal.open = false;
}


modal.addEventListener("animationend", function(){
    if(modal.classList.contains("fade-in")){
        modal.classList.remove("fade-in");
        switch(adatok.aktualis_modal_popup) {
            case 1: kedvencSzinKivalaszto(); break;
            case 2: megnyitasPoszt(); break;
        }
    }
    
    if(modal.classList.contains("fade-out")){
        modal.classList.remove("fade-out");
        bezarasModal();
    }
});