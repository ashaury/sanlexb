/**
* @id			$Id$
* @author 		Joomla Bamboo
* @package  	JB Library
* @copyright 	Copyright (C) 2006 - 2010 Joomla Bamboo. http://www.joomlabamboo.com  All rights reserved.
* @license  	GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
*/
function updateDatabase(baseurl){
	var lsXmlHttp;
	//alert(baseurl);
	var buttonbox = document.getElementById('buttonbox');
	buttonbox.innerHTML='<img name="loading" src="'+baseurl+'plugins/system/jblibrary/images/pleasewait.gif" border="0" align="absmiddle" alt="loading"/> Processing...';
	try	{
			lsXmlHttp=new XMLHttpRequest();
		} catch (e) {
			try	{ lsXmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try { lsXmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {
					alert("Your browser does not support AJAX!");
				}
			}
		}
	lsXmlHttp.onreadystatechange=function() {
		if(lsXmlHttp.readyState==4){
			setTimeout(function(){ 
				//alert(lsXmlHttp.responseText);
				buttonbox.innerHTML=lsXmlHttp.responseText;
			},500);
			setTimeout(function(){
				buttonbox.innerHTML=lsXmlHttp.responseText;
			},2000);
		}
	}			
		lsXmlHttp.open("GET",baseurl+'plugins/system/jblibrary/install/install.php',true);
	lsXmlHttp.send(null);
}