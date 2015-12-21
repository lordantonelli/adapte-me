// Import the page-mod API
const pageMod = require("sdk/page-mod");
// Import the tabs API
const tabs = require("sdk/tabs");
// Import the self API
const self = require("sdk/self");
var data = require("sdk/self").data;
// Import the simple-storage API
const ss = require("sdk/simple-storage");
// Import the request API
const Request = require("sdk/request").Request;
// Import the request windows/utils
const utils = require('sdk/window/utils');
// get a global window reference
const recent = utils.getMostRecentBrowserWindow();
// Import the timers API
var { setInterval } = require("sdk/timers");


const {Cu} = require("chrome");
const {ctypes} = Cu.import("resource://gre/modules/Prompt.jsm");


// Variable of URL to request menu settings
var url_adapte_me = "http://cafe.intermidia.icmc.usp.br:22080/adapte-me/pt-br/login/";
var url_adapte_me_login =    "http://cafe.intermidia.icmc.usp.br:22080/adapte-me/pt-br/login/login_plugin";
//var url_adapte_me_login = "http://143.107.231.215:22080/adapte-me/pt-br/login/login_plugin";
var url_adapte_me_cadastro = "http://cafe.intermidia.icmc.usp.br:22080/adapte-me/pt-br/login/register";
//var url_adapte_me_cadastro = "http://143.107.231.215:22080/adapte-me/pt-br/login/register";
var url_parser_ameg = "http://agua.intermidia.icmc.usp.br:8080/ameg/adapte-me";


// check if the variables already exist
if ( !ss.storage.logado ){
	// Variables to store the user identification of the Adapte-me application
	ss.storage.identify = "";
	ss.storage.name = "";
	ss.storage.logado = false;
	ss.storage.menu = "mmenu";
	ss.storage.config = "";
	ss.storage.name_menu = "_" + Number(new Date());
}

var selector = "div.menuNavTopo, div#menu-conteudo, ul#menuHome";

 
// Create a page-mod
// It will run a script whenever a ".org" URL is loaded
// The script replaces the page contents with a message
pageMod.PageMod({
  include: "*",
  contentStyleFile: [data.url("style.css")],
  contentScriptFile: [data.url("script.js")],
  contentScriptWhen: "ready",
  onAttach: function(worker) {
    worker.port.emit("getElements", ss.storage.logado, ss.storage.name_menu, selector);
    worker.port.on("gotElement", function(elementContent) {
      
      request_menu(elementContent);

    });
  }
});

function request_menu(code_menu){

	//console.log("CODIGO MENU: " + code_menu);

	if(typeof code_menu !== 'undefined' && code_menu != "" && code_menu != null){

		Request({
		  url: url_parser_ameg,
		  content: {code_menu: code_menu, type_menu: ss.storage.menu, config_menu: ss.storage.config, name_menu: ss.storage.name_menu },
		  onComplete: function (response) {
		  	console.log("RESPONSE: " + response);
		      if(ss.storage.logado == true){
		      	tabs.activeTab.attach({
			      	contentScriptFile: [data.url("jquery.js"), data.url("jquery.mmenu.min.all.js")],
			      	contentScript: ""
			      				+ "$('head').append('<style>#" + ss.storage.name_menu + "{visibility:hidden;}</style>');"
			      				//+ "$(document).ready(function(){$('nav#WWxkV2RXUlJQVDA9').mmenu({extensions: ['multiline', 'pageshadow', 'border-full'],'navbars': [{'position': 'top','content': ['prev','title','close']}]}); });"
			      				+ response.json.js
			      				+ "$( 'body' ).append('" + response.json.html + "'); "
			      				+ "$( 'head' ).append('" + response.json.css + "');"
			      				+ "$(document).ready(function(){ $('#name-menu-adapte-me').html('MENU'); $('#" + ss.storage.name_menu + "').css('visibility', 'visible'); $('.header a').addClass('icon-menu-adapte-me-loaded'); });"
			      				//+ "$('head').append('<link href=\"http://multi-level-push-menu.make.rs/demo/jquery.multilevelpushmenu.css\" type=\"text/css\" rel=\"stylesheet\" />');"
			      });
		      } else {
		      	// TODO something
		      }
		  }
		}).post();
	}

	tabs.activeTab.attach({
		contentScriptFile: [data.url("jquery.js")],
	});
}


var menuId;

// Include the "Adapte-me!" item on the main menu
menuId = recent.NativeWindow.menu.add("Adapte-me!", null, function() {
	adapteMe(recent);
});


function adapteMe(window) {

	if(ss.storage.logado == false){
		var p = new Prompt({
		  window: window,
		  title: "Adapte-me!",
		  buttons: ["OK", "Cancelar", "Cadastrar"]
		}).addTextbox({
		  value: "",
		  id: "username",
		  hint: "Digite seu e-mail:",
		  autofocus: true
		}).addPassword({
		  value: "",
		  id: "password",
		  hint: "Digite sua senha:",
		}).show(function(dados) {
			if(dados.button == 0){ 
				request_login(dados);
			} else if(dados.button == 2) {
				tabs.open(url_adapte_me_cadastro);
			}
		});

	}else{
		var p = new Prompt({
		  window: window,
		  title: "Bem-vindo " + ss.storage.name + "!",
		  buttons: ["Atualizar", "Sair", "Confgurações"]
		}).show(function(dados) {
		  	if(dados.button == 0){ 
				if(ss.storage.identify != ""){
					Request({
					  url: url_adapte_me_login,
					  content: {identify: ss.storage.identify},
					  onComplete: function (response) {
					      if(response.json.logado == true){
					      	ss.storage.name = response.json.name;
							ss.storage.menu = response.json.menu;
							ss.storage.config = response.json.config;
					      	recent.NativeWindow.toast.show("Configurações atualizadas com sucesso!", "short");
					      } else {
					      	recent.NativeWindow.toast.show("Não foi possível atualizar as configurações.", "short");
					      }
					  }
					}).post();
				}
			} else if(dados.button == 1) {
				ss.storage.identify = "";
				ss.storage.name = "";
				ss.storage.logado = false;
			} else if(dados.button == 2) {
				tabs.open(url_adapte_me);
			}
		});

	}
}



function request_login(dados){

	if(dados.username != "" && dados.password != ""){
		Request({
		  url: url_adapte_me_login,
		  content: {email: dados.username, password: dados.password},
		  onComplete: function (response) {
		      if(response.json.logado == true){
		      	ss.storage.identify = response.json.identify;
		      	ss.storage.name = response.json.name;
				ss.storage.logado = true;
				ss.storage.menu = response.json.menu;
				ss.storage.config = response.json.config;
				recent.NativeWindow.toast.show("Login realizado com sucesso!", "short");
		      } else {
		      	recent.NativeWindow.toast.show("Não foi possível realizar o login!\nE-mail ou senha estão incorretos.", "short");
		      }
		  }
		}).post();
	} else {
		recent.NativeWindow.toast.show("E-mail ou senha estão em brancos!", "short");
	}
}



// do something every 30 min
setInterval(function() {
	if(ss.storage.identify != ""){
		Request({
		  url: url_adapte_me_login,
		  content: {identify: ss.storage.identify},
		  onComplete: function (response) {
		      if(response.json.logado == true){
		      	ss.storage.name = response.json.name;
				ss.storage.menu = response.json.menu;
				ss.storage.config = response.json.config;
		      }
		  }
		}).post();
	}
}, 1800000);

