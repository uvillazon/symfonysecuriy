var ALERT_TITLE = "ATENCION!";
var ALERT_BUTTON_TEXT = "Aceptar";
var adv = getQueryParam('advertencia');
if (adv == null) {
    createCustomAlert('AL INGRESAR A ESTE SISTEMA, USTED SE COMPROMETE A CUMPLIR CON LO ESTABLECIDO EN LA POLITICA DE  SEGURIDAD DE  INFORMACIÓN DE LA EMPRESA  Y CERTIFICA SER EL USUARIO DE INGRESO');
}
// console.log(adv);
if (document.getElementById && adv == null) {
    // window.alert = function (txt) {
    //     // createCustomAlert(txt);
    // }
}
function getQueryParam(name) {
    var regex = RegExp('[?&]' + name + '=([^&]*)');

    var match = regex.exec(location.search) || regex.exec(document.documentURI);
    return match && decodeURIComponent(match[1]);
}
function createCustomAlert(txt) {
    d = document;


    if (d.getElementById("modalContainer")) return;

    mObj = d.getElementsByTagName("body")[0].appendChild(d.createElement("div"));
    mObj.id = "modalContainer";
    mObj.style.height = d.documentElement.scrollHeight + "px";

    mHeaderObj = mObj.appendChild(d.createElement("div"));
    mHeaderObj.id = "modalHeaderContainer";
    mHeaderObj.style.visiblity = "visible";

    logoObj = mHeaderObj.appendChild(d.createElement("div"));
    logoObj.id = "logo_advertencia";
    logoObj.style.visiblity = "visible";

    alertObj = mObj.appendChild(d.createElement("div"));
    // alertObj = mHeaderObj.appendChild(d.createElement("div"));
    alertObj.id = "alertBox";
    if (d.all && !window.opera) alertObj.style.top = document.documentElement.scrollTop + "px";
    // console.log(d.documentElement.scrollWidth);
    // console.log(alertObj.offsetWidth);

    alertObj.style.left = (d.documentElement.scrollWidth - alertObj.offsetWidth) / 2 + "px";
    alertObj.style.visiblity = "visible";

    h1 = alertObj.appendChild(d.createElement("h1"));
    h1.appendChild(d.createTextNode(ALERT_TITLE));

    msg = alertObj.appendChild(d.createElement("p"));
    //msg.appendChild(d.createTextNode(txt));
    msg.innerHTML = txt;

    btn = alertObj.appendChild(d.createElement("a"));
    btn.id = "closeBtn";
    btn.appendChild(d.createTextNode(ALERT_BUTTON_TEXT));
    btn.href = "#";
    btn.focus();
    btn.onclick = function () {
        removeCustomAlert();
        return false;
    }

    alertObj.style.display = "block";

}

function removeCustomAlert() {
    document.getElementsByTagName("body")[0].removeChild(document.getElementById("modalContainer"));
}
function ful() {
    alert('Alert this pages');
}