// Az összes naptari adatot betölti.  A program indulásakor hívódik meg, vagy ha a hónap változik a naptárban.
function kitoltesNaptar(){
    modositasNaptarDatumok();
    var kitoltendoHonap = {};
    var elozoHonapIndex;
    honap_adatok.forEach(function(honap, i){
        if(honap.ev == adatok.naptar.ev && honap.honap_index == adatok.naptar.honap){
            kitoltendoHonap = honap;
            elozoHonapIndex = i - 1;
        }
    });
    
    let napok = document.getElementsByTagName("td");
    let aktualisHonapSzam = 1;
    let elozoHonapSzam = honap_adatok[elozoHonapIndex].napok_szama - kitoltendoHonap.kezdo_nap + 1;
    let kovetkezoHonapSzam = 1;
    
    tisztitasCellak();
    for(let i = 0; i < napok.length; i++){
        
        // Kitölti az aktuális honapot.
        if(kitoltendoHonap.kezdo_nap <= i && aktualisHonapSzam <= kitoltendoHonap.napok_szama){
            kitoltesReszlegesHonapAdatok(napok[i], aktualisHonapSzam, kitoltendoHonap, "current");
            aktualisHonapSzam++;
            
        // Kitölti az előző honapop.
        } else if(aktualisHonapSzam <= kitoltendoHonap.napok_szama){
            kitoltesReszlegesHonapAdatok(napok[i], elozoHonapSzam, honap_adatok[elozoHonapIndex], "previous");
            elozoHonapSzam++;
            
        // Kitölti a következő honapot.
        } else {
            kitoltesReszlegesHonapAdatok(napok[i], kovetkezoHonapSzam, honap_adatok[elozoHonapIndex + 2], "next");
            kovetkezoHonapSzam++;
        }
    }
    valtoztatasSzin();
}

//Az aktuális hónapnak az adatait tölti ki, az aktuális napot átszinezü + az előző hónapnak a napjait, a kitöltesNaptarban hivodik meg
function kitoltesReszlegesHonapAdatok(nap, szam, honapObjektum, honap){
    nap.innerHTML = szam;
    if(honap == "current"){
        if(szam == adatok.aktualis_datum.datum && aNaptarHonapAzAktualisHonapE()){
            nap.setAttribute("id", "current-day");
        }
    } else {
        nap.classList.add("color");
        if(honap == "previous" && szam == honapObjektum.napok_szama){
            nap.classList.add("prev-month-last-day");
        }
    }
    
    uid = getUID(honapObjektum.honap_index, honapObjektum.ev, szam);
    nap.setAttribute("data-uid", uid);
    hozzacsatolasKepEsTooltipACellahoz(uid, nap);
}




// Ez a funkció visszaad egy egyedi id-t a honap,ev,nap alapján.
function getUID(honap, ev, nap){
    if(honap == 12){
        honap = 0;
        ev++;
    }
    return honap.toString() + ev.toString() + nap.toString();
}


//hozzáadja egy képet és egy classt a naptárhoz, amely segit megjeleniteni a jegyzet képét.
function hozzacsatolasKepEsTooltipACellahoz(uid, elem){
    for(let i = 0; i < posztok_tomb.length; i++){
        if(uid == posztok_tomb[i].id){
            elem.innerHTML += `<img src='kepek/jegyzet${posztok_tomb[i].jegyzet_szama}.png' alt='Egy Jegyzet'>`;
            elem.classList.add("tooltip");
            elem.innerHTML += `<span>${posztok_tomb[i].jegyzet}</span>`;
        }
    }
}



// Ez segit meghatározni hogy az adott honap az aktualis honap e..
// Azért kell hogy a kitoltesNaptar() ban be tudja állitani az adott nap színét.
function aNaptarHonapAzAktualisHonapE(){
    if(adatok.aktualis_datum.ev == adatok.naptar.ev && adatok.aktualis_datum.honap == adatok.naptar.honap){
        return true;
    } else {
        return false;
    }
}



// Az összes classt + attributumot kitörli a cellák elemei közül.
function tisztitasCellak(){
    torlesAktualisNapId();
    var tablaCellak = document.getElementsByTagName("td");
    for(let i = 0; i < tablaCellak.length; i++){
        removeClass(tablaCellak[i], "color");
        removeClass(tablaCellak[i], "prev-month-last-day");
        removeClass(tablaCellak[i], "tooltip");
        removeAttribute(tablaCellak[i], "style");
    }
}



// Ha a naptár módosul akkor kitörli az id-t ami meghatározza az adott napot.tisztitasCellakban hivodikmeg.
function torlesAktualisNapId(){
    if(document.getElementById("current-day")){
        document.getElementById("current-day").removeAttribute("id", "");
    }
}



// lekéri a naptár évét + folytatja 1-el , és ha a hónap száma túlmenne visszaállitja (decemberból január pl.).
function kovetkezoHonap(){
    if(adatok.naptar.honap != 11 || adatok.naptar.ev == 2018 || adatok.naptar.ev == 2019){
        adatok.naptar.honap++;
    }
    if(adatok.naptar.honap >= 12){
        adatok.naptar.honap = 0;
        adatok.naptar.ev++;
    }
    kitoltesNaptar();
}



// lekéri a naptár évét + csökkenti 1-el , és ha a hónap száma túlmenne visszaállitja csak forditba(januárból december pl.).
function elozoHonap(){
    if(adatok.naptar.honap != 11 || adatok.naptar.ev == 2019){
        adatok.naptar.honap--;
    }
    if(adatok.naptar.honap <= -1){
        adatok.naptar.honap = 11;
        adatok.naptar.ev--;
    }
    kitoltesNaptar();
}



// A hónapokat lehessen nyilakkal változtatni.
document.onkeydown = function(e) {
    switch (e.keyCode) {
        case 37: elozoHonap(); break;
        case 39: kovetkezoHonap(); break;
    }
};