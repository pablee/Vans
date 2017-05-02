function crearBase()
	{		
	//alert("creando base");
	xhttp = new XMLHttpRequest();
	if (this.readyState == 4 && this.status == 200)			
			{
			document.getElementById("lista").innerHTML=this.responseText;							
			document.getElementById("barra").value="";					
			}
	xhttp.open("GET", "php/crearBase.php", true);		
	xhttp.send();	
	}

var articulos = 0;
function ingresarBarras(event)
	{	
	if(event.which == 13 || event.keyCode == 13 || event==0 || event=="guardar" || event=="consultar")
		{
		if(event=="guardar")
			{		
			var barra = "guardar";
			document.getElementById("cantidad").innerHTML="<th id='cantidad'> Cantidad </th>";					
			}
			else if(event=="consultar")
				{
				var barra = "consultar";
				}
				else{
					var barra = document.getElementById("barra").value;
					//Cuenta los articulos ingresados
					if(barra!=""&&barra!="guardar")
						{
						articulos +=1;
						document.getElementById("contador").innerHTML = articulos;	
						}
					}	
	
		//Procesa la solicitud en base al valor pasado en "barra"
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function()
			{
			if (this.readyState == 4 && this.status == 200)			
				{
				document.getElementById("lista").innerHTML=this.responseText;							
				document.getElementById("barra").value="";
				}
			};
		xhttp.open("GET", "php/cargarBarras.php?barra="+barra, true);		
		xhttp.send();	
		
		//Toma el ultimo articulo ingresado a la "lista" y lo añade al "listado" de todos los articulos
		var ultimoIngreso = document.getElementById("lista").innerHTML;			
		if(barra!="guardar")
			{
			document.getElementById("listado").innerHTML+=ultimoIngreso;		
			}
			else{
				document.getElementById("listado").innerHTML="";
				}
		}
	}

//Resta del contador los articulos borrados
function restar()
	{
	articulos -=1;
	document.getElementById("contador").innerHTML = articulos;
	};
	
//Borra el articulo del listado final	
function sacarArticulo(id)
	{
	//alert(id);
	xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function()	
		{					
		if (this.readyState == 4 && this.status == 200)
				{							
				document.getElementById(id).innerHTML="";							
				document.getElementById("barra").value="";
				}
		};
		
	xhttp.open("GET", "php/cargarBarras.php?id="+id, true);		
	xhttp.send();							
	}


/*
Excel export script works on IE7+, Firefox and Chrome.	
Just create a blank iframe:
<iframe id="txtArea1" style="display:none"></iframe>
Call this function on:
<button id="btnExport" onclick="fnExcelReport();"> EXPORT </button>	
*/
function fnExcelReport()
	{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('articulos'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
		{     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
		}

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
		{
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
		}  
		else{                 //other browser not tested on IE 11
			sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  
			}
			
		return (sa);
	}			

	
