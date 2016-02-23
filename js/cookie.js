//Ezt a kódot innen nyúltam:
//http://www.w3schools.com/js/js_cookies.asp
//Utólag is köszi!

//Létrehoz egy sütit a megadott névvel és a megadott értékkel
//(param) string cname: a süti neve
//(param) string cvalue: a süti értéke
//(param) int exdays: hány nap múlva járjon le a süti
//(return) void
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

//Visszaadja az adott nevű süti értékét
//(param) string cname: a süti neve
//(return) string: a süti értéke, vagy üres string, ha nincs ilyen süti
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}