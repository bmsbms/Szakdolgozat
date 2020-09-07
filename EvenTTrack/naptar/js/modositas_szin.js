// A fade in animáció után hívodik meg, ha az aktualis_modal_popup  1.
function kedvencSzinKivalaszto(){
    var sablon = document.getElementById("fav-color");
    sablon.removeAttribute("hidden");
}



// Akkor hivodik emg ha a szinek listájában rákattintuk valamelyik szinre
function modositasSzinAdatok(nev){
    torlesPipak();
    szin_adatok.forEach(function(tomb_adatok){
        if(nev == tomb_adatok.nev){
            adatok.aktualis_szin.szin = tomb_adatok.szin_kod;
            adatok.aktualis_szin.hatterSzin = tomb_adatok.hatterSzin_kod;
            adatok.aktualis_szin.szin_nev = tomb_adatok.nev;
        }
    });
    hozzaadasPipaAzAktualisSzinhez();
}



// Akkor hivodik meg ha a szin modosul.  A modositasSzinreKattintas() ban hivodik meg.
function valtoztatasSzin(){
    ajax({szin: adatok.aktualis_szin.szin_nev});
    var elemek;
    //console.log(adatok.aktualis_szin.szin_nev);
    elemek = document.getElementsByClassName("color");
        for(i=0; i < elemek.length; i++) {
          elemek[i].style.backgroundColor = adatok.aktualis_szin.szin;
    }
    
    elemek = document.getElementsByClassName("border-color");
        for(i=0; i < elemek.length; i++) {
          elemek[i].style.borderColor = adatok.aktualis_szin.szin;
    }
    
    elemek = document.getElementsByClassName("off-color");
        for(i=0; i < elemek.length; i++) {
          elemek[i].style.color = adatok.aktualis_szin.hatterSzin;
    }
}



// A szinek listájában lévő modositas gomb lenyomasakor hivodik meg.
function modositasSzinreKattintas(){
    valtoztatasSzin();
    var sablon = document.getElementById("fav-color");
    sablon.setAttribute("hidden", "hidden");
    modal.classList.add("fade-out");
}



// A modositasSzinAdatokban van.
function torlesPipak(){
    var pipak = document.getElementsByClassName("checkmark");
    for(let i = 0; i < pipak.length; i++){
        torlesElemek(pipak[i]);
    }
}



// Kitörli a pipat classt--> torlesPipak().
function torlesElemek(elem){
    elem.parentNode.removeChild(elem);
}



// Akkor hivodik emg amikor az oldal betölt modositasSzinAdatok()ban van.
function hozzaadasPipaAzAktualisSzinhez(){
    szin_elonezet = document.getElementsByClassName("color-preview");
    
    for(let i = 0; i < szin_elonezet.length; i++){
        if(szin_elonezet[i].id == adatok.aktualis_szin.szin_nev){
            szin_elonezet[i].innerHTML = "<i class='fas fa-check checkmark'></i>";
        }
    }
}