function modositasAktualisDatumok(){
    const maiNap = new Date();
    
    let datum = maiNap.getDate();
    let nap = maiNap.getDay();
    let honap = maiNap.getMonth();
    let ev = maiNap.getFullYear();
    
    adatok.aktualis_datum.nap = nap;
    adatok.aktualis_datum.honap = honap;
    adatok.aktualis_datum.ev = ev;
    adatok.aktualis_datum.datum = datum;
    
    adatok.naptar.honap = honap;
    adatok.naptar.ev = ev;
    
    document.getElementById("cur-year").innerHTML = ev;
    document.getElementById("cur-day").innerHTML = forditasAHetkoznapNevere(nap);
    document.getElementById("cur-date").innerHTML = datum;
    document.getElementById("cur-month").innerHTML = forditasAHonapNevere(honap);
}

function modositasNaptarDatumok(){
    document.getElementById("cal-year").innerHTML = adatok.naptar.ev;
    document.getElementById("cal-month").innerHTML = forditasAHonapNevere(adatok.naptar.honap);
}

function forditasAHetkoznapNevere(nap){
    switch(nap){
        case 0: return "Vasárnap";
        case 1: return "Hétfő";
        case 2: return "Kedd";
        case 3: return "Szerda";
        case 4: return "Csütörtök";
        case 5: return "Péntek";
        case 6: return "Szombat";
    }
}

function forditasAHonapNevere(honap){
    switch(honap){
        case 0: return "Január";
        case 1: return "Február";
        case 2: return "Március";
        case 3: return "Április";
        case 4: return "Május";
        case 5: return "Junius";
        case 6: return "Julius";
        case 7: return "Agusztus";
        case 8: return "Szeptember";
        case 9: return "Október";
        case 10: return "November";
        case 11: return "December";
    }
}
