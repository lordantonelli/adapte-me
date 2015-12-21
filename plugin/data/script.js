try{

	var html_inicial = document.body.innerHTML; 
	//document.body.innerHTML = '<div class="jquery-waiting-base-container">Carregando...</div>' + html_inicial;

  var meta = document.createElement('meta');
  meta.name = "viewport";
  meta.content = "width=320px, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0";
  document.getElementsByTagName('head')[0].appendChild(meta);

} catch(E) {};



self.port.on("getElements", function(logado, name_menu, selectors) {

  var elements = document.querySelectorAll(selectors);
  var code_menu = null;

  if(elements.length > 0 && logado == true){
    //document.body.innerHTML = '<div class="jquery-waiting-base-container">Carregando...</div><div id="page"><div class="header fixed"><a href="#WWxkV2RXUlJQVDA9"></a>Menu</div><div id="global">' + html_inicial + '</div></div>';
    document.body.innerHTML = '<div id="page"><div class="header fixed"><a href="#'+ name_menu + '"></a><span id="name-menu-adapte-me">Carregando...</span></div><div id="global">' + html_inicial + '</div></div>';
    code_menu = elements[0].outerHTML.replace(/\n/g, ""); 
  }
  self.port.emit("gotElement", code_menu);

});

