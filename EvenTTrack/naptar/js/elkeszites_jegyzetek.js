function napraKattintas(e){
    adatok.posztok_tomb.aktualis_poszt_id = e.dataset.uid;
    azAktualisNapnakVanJegyzete(adatok.posztok_tomb.aktualis_poszt_id);
    megnyitasModal(2);
}


function megnyitasPoszt(){
    var sablon = document.getElementById("make-note");
    sablon.removeAttribute("hidden");
    
    if(!adatok.posztok_tomb.aktualis_poszt_uj){
        document.getElementById("edit-post-it").value = posztok_tomb[adatok.posztok_tomb.aktualis_poszt_index].jegyzet;
    }
}


function bekuldesPoszt(){
    const ertek = document.getElementById("edit-post-it").value;
    document.getElementById("edit-post-it").value = "";
    let szam = getRandom(1, 6);
    let poszt = {
        id: adatok.posztok_tomb.aktualis_poszt_id,
        jegyzet_szama: szam,
        jegyzet: ertek
    }
    
    if(adatok.posztok_tomb.aktualis_poszt_uj){
        posztok_tomb.push(poszt);
        ajax({uj_jegyzet_uid: poszt.id, uj_jegyzet_szine: poszt.jegyzet_szama, uj_jegyzet_szovege: poszt.jegyzet});
    } else {
        posztok_tomb[adatok.posztok_tomb.aktualis_poszt_index].jegyzet = poszt.jegyzet;
        ajax({modositas_jegyzet_uid: posztok_tomb[adatok.posztok_tomb.aktualis_poszt_index].id, modositas_jegyzet_szovege: poszt.jegyzet});    
    }
    
    kitoltesNaptar();
    var sablon = document.getElementById("make-note").setAttribute("hidden", "hidden");
    modal.classList.add("fade-out");
}


function getRandom(min, max) {
    return Math.floor(Math.random() * (max - min) ) + min;
}


function azAktualisNapnakVanJegyzete(uid){
    for(var i = 0; i < posztok_tomb.length; i++){
        if(posztok_tomb[i].id == uid){
            adatok.posztok_tomb.aktualis_poszt_uj = false;
            adatok.posztok_tomb.aktualis_poszt_index = i;
            return;        
        }
    }
    adatok.posztok_tomb.aktualis_poszt_uj = true;
}


function torlesJegyzet(){
    document.getElementById("edit-post-it").value = "";
    let torolnivaloIndex;
    if(!adatok.posztok_tomb.aktualis_poszt_uj){
        torolnivaloIndex = adatok.posztok_tomb.aktualis_poszt_index;
    }
    if(torolnivaloIndex != undefined){
        ajax({torles_jegyzet_uid: posztok_tomb[torolnivaloIndex].id});
        posztok_tomb.splice(torolnivaloIndex, 1);
        
    }
    kitoltesNaptar();
    var sablon = document.getElementById("make-note").setAttribute("hidden", "hidden");
    modal.classList.add("fade-out");
}
        