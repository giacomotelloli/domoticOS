
 var numeroInfo=0;
var numeroValori=0;

function sendCommand() {
   
    var comando="";
 if(document.getElementById("comando").value==""){
    document.getElementById("conversazione").innerHTML +="H.A.L. : Dovresti scrivere qualcosa, se hai problemi digita 'aiuto' <br />";
    return;
 }else{
    document.getElementById("conversazione").innerHTML +="TU :"+document.getElementById("comando").value + "<br />";
 comando=document.getElementById("comando").value;
 document.getElementById("comando").value="";

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
     var testo = this.responseText;
     var xml=xhttp.responseXML;
        var elementi=xml.getElementsByTagName("messaggio");
            var messaggio=elementi[0].childNodes[0].childNodes[0].nodeValue;
            var tipoMex=elementi[0].getAttribute("tipoMex");

            if((tipoMex=="errore")||(tipoMex=="messaggio")){
                document.getElementById("conversazione").innerHTML+=messaggio;
            }else if(tipoMex=="info"){
               
                var ris= document.getElementById("risultati");
                if(ris.hasChildNodes()){
                    var ultimoNum=ris.lastElementChild.getAttribute("id");
                ultimoNum++;
                }else{
                    ultimoNum=0;
                }
                
                
                var nuovoMex=document.createElement("div");
                    nuovoMex.setAttribute("id",ultimoNum);
                    nuovoMex.setAttribute("class","mexInfo");

                var divChiudi=document.createElement("div");
                    divChiudi.setAttribute("style","margin:1%;");

                var buttChiudi=document.createElement("button");
                    buttChiudi.setAttribute("class","pulsanteChiudi");
                    buttChiudi.setAttribute("onclick","chiudi("+ultimoNum+")");
                var textButton=document.createTextNode("chiudi");
                    buttChiudi.appendChild(textButton);

                    divChiudi.appendChild(buttChiudi);
                    nuovoMex.appendChild(divChiudi);
                    nuovoMex.innerHTML+=messaggio;
                
                    ris.appendChild(nuovoMex);
            }
  
     }
     };
    xhttp.open("GET", "hal_process.php?comando="+comando,true);
    xhttp.send();

}
}

function chiudi(numero){
    var elem=document.getElementById(numero);
    elem.remove();
}

function getStanze(nomePiano){
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        var testo = this.responseText;
        document.getElementById("listaStanze").innerHTML=testo;

    };
    xhttp.open("GET", "getStanze.php?piano="+nomePiano,true);
    xhttp.send();
}

function aggiungiPezzo(tipoPezzo){
    if(tipoPezzo=="numero"){
       var divContenitore=document.createElement("div");

        var labelValMax=document.createElement("label");
        labelValMax.setAttribute("class","label text");

        var inputValMax=document.createElement("input");
        inputValMax.setAttribute("type","number");
        inputValMax.setAttribute("name","valMax");
        inputValMax.setAttribute("class","text");

        var spanValMax=document.createElement("span");
        spanValMax.innerHTML="Valore Massimo";

        labelValMax.appendChild(spanValMax);
        labelValMax.appendChild(inputValMax);
        divContenitore.appendChild(labelValMax);

        var labelValMin=document.createElement("label");
        labelValMin.setAttribute("class","label text");

        var inputValMin=document.createElement("input");
        inputValMin.setAttribute("type","number");
        inputValMin.setAttribute("name","valMin");
        inputValMin.setAttribute("class","text");

        var spanValMin=document.createElement("span");
        spanValMin.innerHTML="Valore Minimo";

        labelValMin.appendChild(spanValMin);
        labelValMin.appendChild(inputValMin);
        divContenitore.appendChild(labelValMin);


        var labelUnitaMisura=document.createElement("label");
        labelUnitaMisura.setAttribute("class","label text");
        
        var inputValUnita=document.createElement("input");
        inputValUnita.setAttribute("type","text");
        inputValUnita.setAttribute("name","valUnita");
        inputValUnita.setAttribute("class","text");

        var spanValUnita=document.createElement("span");
        spanValUnita.innerHTML="Unit&agrave; di Misura";

        labelUnitaMisura.appendChild(spanValUnita);
        labelUnitaMisura.appendChild(inputValUnita);
        divContenitore.appendChild(labelUnitaMisura);

        document.getElementById("contenutoValori").innerHTML="";
        document.getElementById("contenutoValori").appendChild(divContenitore);
        return;
    }else if(tipoPezzo=="parole"){
        var divContenitore=document.createElement("div");
        var divScroll=document.createElement("div");
        divScroll.setAttribute("id","divValori");
        divScroll.setAttribute("style","overflow:scroll");

        
        var pulsanteAggiuntaInput=document.createElement("div");
        pulsanteAggiuntaInput.setAttribute("onclick","aggiungiInput()");
        pulsanteAggiuntaInput.setAttribute("class","pulsanteAggiunta");
        pulsanteAggiuntaInput.innerHTML="Aggiungi Valore";

        var labelNomeVal=document.createElement("label");
        labelNomeVal.setAttribute("class","label text");

        var inputNomeVal=document.createElement("input");
        inputNomeVal.setAttribute("type","text");
        inputNomeVal.setAttribute("class","label text");
        inputNomeVal.setAttribute("placeholder","nome valore");
        inputNomeVal.setAttribute("name",numeroValori);
        numeroValori++;

        labelNomeVal.appendChild(inputNomeVal);
        divScroll.appendChild(labelNomeVal);
        divContenitore.appendChild(pulsanteAggiuntaInput);
        divContenitore.appendChild(divScroll);

        document.getElementById("contenutoValori").innerHTML="";
        document.getElementById("contenutoValori").appendChild(divContenitore);
        return;
    }
}
function eseguiCodiceIDE(fileStato){
    var codice=document.getElementById("areaTestoCodice").value;
    var codiceCorr=codice.replace("+"," piu");
    if(verificaCodice()){

        var xhttp = new XMLHttpRequest();
        
         xhttp.onreadystatechange = function ()
         {
             if((this.readyState == 4)&&(this.status === 200))
             {
                     var messaggio = this.responseText;
                     document.getElementById("contenitoreRisposta").innerHTML=messaggio;
             }
         }
         xhttp.open("POST","eseguiCodiceDiretto.php", true);
         xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
         xhttp.send("codice="+codiceCorr+"&fileStato="+fileStato);
    }else{
        alert("scrivi bene il codice");
    }

}

function aggiungiInput(){
    var divTextBox=document.getElementById("divValori");

    var labelNomeVal=document.createElement("label");
    labelNomeVal.setAttribute("class","label text");

    var textBox=document.createElement("input");
    textBox.setAttribute("type","text");
    textBox.setAttribute("class","label text");
    textBox.setAttribute("placeholder","nome valore");
    textBox.setAttribute("name",numeroValori);
    numeroValori++;

    var inputValori=document.getElementById("numMaxValori");
    inputValori.setAttribute("value",numeroValori);
    labelNomeVal.appendChild(textBox);
    divTextBox.appendChild(labelNomeVal);
    return;    
}

function modificaNomeVariabile(nomeVecchio,pathFileVariabili){
    var nomeNuovo=document.getElementById("testoNome").value;
    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function ()
    {
        if((this.readyState == 4)&&(this.status === 200))
        {
                var messaggio = this.responseText;
                alert(messaggio);
        }
    }
    xhttp.open("POST","modificaNomeVariabile.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("nomeVecchio="+nomeVecchio+"&pathXml="+pathFileVariabili+"&nomeNuovo="+nomeNuovo);
}

function eliminaValoreVariabile(nomeVariabile,pathFileVariabili){

    var indiceSelezionato=document.getElementById("listaValori").options.selectedIndex;
    var valoreDaEliminare=document.getElementById("listaValori").options.item(indiceSelezionato).text;
    
    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function ()
    {
        if((this.readyState == 4)&&(this.status === 200))
        {
                var messaggio = this.responseText;
                alert(messaggio);
                window.location.reload();
        }
    }
    xhttp.open("POST","eliminaValoreVariabile.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("nomeVariabile="+nomeVariabile+"&pathXml="+pathFileVariabili+"&valoreDaEliminare="+valoreDaEliminare);
}

function salvaModifiche(nomeVariabile,pathFileVariabili){
    var testoNome=document.getElementById("testoNome").value;
    var unitaMisura=document.getElementById("unitaMisura").value;
    var valoreMax=document.getElementById("valoreMax").value;
    var valoreMin=document.getElementById("valoreMin").value;

    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function ()
    {
        if((this.readyState == 4)&&(this.status === 200))
        {
                var messaggio = this.responseText;
                alert(messaggio);
                window.location.reload();
        }
    }
    xhttp.open("POST","salvaModificheVariabile.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("nomeVariabile="+nomeVariabile+"&pathXml="+pathFileVariabili+"&nomeCambiato="+testoNome+"&nuovaUnita="+unitaMisura+"&nuovoMax="+valoreMax+"&nuovoMin="+valoreMin);
}

function aggiungiValoreVariabile(nomeVariabile,pathFileVariabili){

    
    var valoreDaAggiungere=document.getElementById("testoNuovoNome").value;
    
    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function ()
    {
        if((this.readyState == 4)&&(this.status === 200))
        {
                var messaggio = this.responseText;
                alert(messaggio);
                window.location.reload();
        }
    }
    xhttp.open("POST","aggiungiValoreVariabile.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("nomeVariabile="+nomeVariabile+"&pathXml="+pathFileVariabili+"&valoreDaAggiungere="+valoreDaAggiungere);
}

function modificaAspetto(nomeVariabile,path){
    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function ()
    {
        if((this.readyState == 4)&&(this.status === 200))
        {
                var messaggio = this.responseText;
                document.getElementById("contenitoreModifiche").innerHTML=messaggio;
        }
    }
    xhttp.open("POST","restituisciCodiceVariabile.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("nomeVariabile="+nomeVariabile+"&pathXml="+path);

}

function checkComandi(oggetto,stanza){
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if((this.readyState == 4)&&(this.status == 200))
        {
                var messaggio = this.responseText;
               
                document.getElementById("contenitoreRisposta").innerHTML=messaggio;
        }
    }
    xhttp.open("POST","scansionaMemo.php",false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("oggetto="+oggetto+"&stanza="+stanza);
    
    var xhttp1 = new XMLHttpRequest();
    xhttp1.onreadystatechange = function ()
    {
        if((this.readyState == 4)&&(this.status == 200))
        {
                var messaggio2 = this.responseText;
               
                document.getElementById("listaPromemoria").innerHTML=messaggio2;
        }
    }
    xhttp1.open("POST","visualizzaMemo.php",false);
    xhttp1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp1.send("oggetto="+oggetto+"&stanza="+stanza);
    
}

function salvaCodice(pathFileComandi,pathCartellaComandi){
    var nomeFile=document.getElementById("nomeFile").value;
    var livelloComando=document.getElementById("livCom").value;
    if((nomeFile!="")&&(livelloComando!="")){
        nomeFile=nomeFile+".xml";
    var codice=document.getElementById("areaTestoCodice").value;
    var codiceCorr=codice.replace("+"," piu");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if((this.readyState == 4)&&(this.status === 200))
        {
                var messaggio = this.responseText;
                document.getElementById("contenitoreRisposta").innerHTML=messaggio;
        }
    }
    xhttp.open("POST", "salvaFileComando.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("pathFileComandi="+pathFileComandi+"&pathCartella="+pathCartellaComandi+"&nomeFile="+nomeFile+"&livelloComando="+livelloComando+"&codice="+codiceCorr);

    }else{
        alert("Devi valorizzare il nome del comando e il livello");
    }

}

function checkErrorXML(x)
{
xt="";
h3OK=1;
checkXML(x);
}

function checkXML(n)
{
var l,i,nam
nam=n.nodeName;
if (nam=="h3")
 {
 if (h3OK==0)
  {
  return;
  }
 h3OK=0
 }
if (nam=="#text")
 {
 xt=xt + n.nodeValue + "\n";
 }
l=n.childNodes.length;
for (i=0;i<l;i++)
 {
 checkXML(n.childNodes[i]);
 }
}

function validateXML(txt){

if (window.ActiveXObject){
  var xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
  xmlDoc.async=false;

  xmlDoc.loadXML(txt);
  if(xmlDoc.parseError.errorCode!=0){
    txt="Error Code: " + xmlDoc.parseError.errorCode + "\n";
    txt=txt+"Error Reason: " + xmlDoc.parseError.reason;
    txt=txt+"Error Line: " + xmlDoc.parseError.line;
    alert(txt);
    return false;
    }
  else
    {
    alert("No errors found ");
    return true;
    }
  }

else if (document.implementation.createDocument)
  {
    try
    {

    var text=txt;
    var parser=new DOMParser();
    var xmlDoc=parser.parseFromString(text,"application/xml");
    }
    catch(err){
    alert("Errore parsing");
    }
    if (xmlDoc.getElementsByTagName("parsererror").length>0){
    checkErrorXML(xmlDoc.getElementsByTagName("parsererror")[0]);
    alert("Errore");
    return false;
    }
    else{
    alert("No errors found");
    return true;
    }
 }
else{

 alert('Your browser cannot handle XML validation');
 }

}

function verificaCodice(){
    var codice=document.getElementById("areaTestoCodice").value;
    return validateXML(codice);
    
    
}

function eseguiCodice(stringaGet){
    var xhttp = new XMLHttpRequest();
   
    xhttp.onreadystatechange = function ()
    {
        if((this.readyState == 4)&&(this.status === 200))
        {
                var xml = this.responseText;
                document.getElementById("contenitoreRisposta").innerHTML=xml;
        }
    }
    xhttp.open("GET", "eseguiCodice.php?"+stringaGet, true);
    xhttp.send();
}

$(document).ready(function(){
    $("#pulsanteElimina").click(function(){
       if($("#nomeFile").val()!=""){
        
        $.post("eliminaComando.php",{comando:$("#nomeFile").val()},
        function(data,status){
            if(status=="success"){
                $("#contenitoreRisposta").html(data);
                $("#livCom").val("");
                $("#livCom").attr("placeholder","livello del comando");
                $("#"+$("#nomeFile").val()).remove();
                $("#nomeFile").val("");
                $("#nomeFile").attr("placeholder","nome del comando");
                $("#areaTestoCodice").text("<?xml version=\"1.0\" encoding=\"UTF-8\"?> \n <codice xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"../../../grammatica.xsd\"> \n <listaVariabili> \n </listaVariabili> \n </codice>");
            }
        });
       }else{
           alert("devi selezionare un comando")
       }
    });
});


function riempiCodice(path,pathCom,nomeComando,livello){

document.getElementById("nomeFile").value=nomeComando;
document.getElementById("livCom").value=livello;

    var xhttp = new XMLHttpRequest();
   
    xhttp.onreadystatechange = function ()
    {
        if((this.readyState == 4)&&(this.status === 200))
        {
                var testo = this.responseText;
               document.getElementById("areaTestoCodice").value=testo;
                
        }
    }
    xhttp.open("GET", "restituisciCodice.php?pathCod="+path+"&pathCom="+pathCom, true);
    xhttp.send();
}
