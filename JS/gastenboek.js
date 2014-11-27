$(document).ready(function() {
	chat.init();
});

var chat = {
	//Data bevat de variabelen die in de klasse gebruikt worden.
	data: {
		lastID: 0,
		noActivity: 0
	},
	
	// Init start de event listeners en maakt de timers op.
	init: function() {
		$('#name').defaultText('Gebruikersnaam');
        $('#email').defaultText('Email (Gravatars zijn actief)');
		
		// Zet de #chatLineHolder div om in een jScrollPane,
        // end sla de plugin's API op in chat.data:
        chat.data.jspAPI = $('#chatLineHolder').jScrollPane({
            verticalDragMinHeight: 12,
            verticalDragMaxHeight: 12
        }).data('jsp');
		
		// We gebruiken de working variabele om 
        // meedere form verzendingen te voorkomen:
        var working = false;
		
		// Iemand aanmelden in de chat
		$('#loginForm').submit(function() {
			if(working) return false;
			
            working = true;
			
			// Gebruiken onze tzPOST wrapper functie
            // (onderaan gedefinieerd):	
			$.tzPOST('login',$(this).serialize(),function(r){
                working = false;

                if(r.error){
                    chat.displayError(r.error);
                }
                else chat.login(r.name,r.gravatar);
            });
			
			return false;
		});
		
		$('#submitForm').submit(function() {
			var text = $('#chatText').val();

            if(text.length == 0){
                return false;
            }

            if(working) return false;
            working = true;
			
			// Een tijdelijke ID aan de chat toewijzen:
            var tempID = 't'+Math.round(Math.random()*1000000),
                params = {
                    id          : tempID,
                    author      : chat.data.name,
                    gravatar    : chat.data.gravatar,
                    text        : text.replace(/</g,'&lt;').replace(/>/g,'&gt;')
                };
			
			// Gebruiken onze addChatLine methode om de chat
            // meteen op het scherm te tonen, zonder te wachten tot
            // de AJAX request klaar is:
			chat.addChatLine($.extend({},params));
			
			// Gebruiken onze tzPOST wrapper methode om de chat
            // via een POST AJAX request te versturen:
			$.tzPOST('submitChat',$(this).serialize(),function(r){
                working = false;

                $('#chatText').val('');
                $('div.chat-'+tempID).remove();

                params['id'] = r.insertID;
                chat.addChatLine($.extend({},params));
            });	
			
			return false;	
		});
		
		// De user afmelden:

        $('a.logoutButton').live('click',function(){

            $('#chatTopBar > span').fadeOut(function(){
                $(this).remove();
            });

            $('#submitForm').fadeOut(function(){
                $('#loginForm').fadeIn();
            });

            $.tzPOST('logout');

            return false;
        });
		
		// Nakijken of de user al is aangemeld (Browser refresh)
        $.tzGET('checkLogged',function(r){
            if(r.logged){
                chat.login(r.loggedAs.name,r.loggedAs.gravatar);
            }
        });
		
		// Zelf uitvoerende timeout functies:
        (function getChatsTimeoutFunction(){
            chat.getChats(getChatsTimeoutFunction);
        })();

        (function getUsersTimeoutFunction(){
            chat.getUsers(getUsersTimeoutFunction);
        })();
	},
	
	// De login methode verbergt/toont 
	// de user login data en het submit form
    login : function(name, gravatar){

        chat.data.name = name;
        chat.data.gravatar = gravatar;
        $('#chatTopBar').html(chat.render('loginTopBar',chat.data));

        $('#loginForm').fadeOut(function(){
            $('#submitForm').fadeIn();
            $('#chatText').focus();
        });

    },
	
	// De render methode genereert de HTML opmaak
	// dat nodig is voor andere methodes:
	render: function(template, params) {
		var arr = [];
		
		switch(template) {
			case 'loginTopBar':
				arr = [
					'<span><img src="', params.gravatar, '" width="23" height="23" />',
					'<span class="name">', params.name,
					'</span><a href="" class="logoutButton rounded">Afmelden</a></span>'];
			break;	
			
			case 'chatLine':
				arr = [
					'<div class="chat chat-', params.id, ' rounded"><span class="gravatar"><img src="', params.gravatar,
					'" width="23" height="23" onload="this.style.visibility=\'visible\'" />', '</span><span class="author">', params.author,
					':</span><span class="text">',params.text,'</span><span class="time">',params.time,'</span></div>'];
			break;
			
			case 'user':
				arr = [
					'<div class="user" title="',params.name,'"><img src="',
					params.gravatar,'" width="30" height="30" onload="this.style.visibility=\'visible\'" /></div>'
				];
			break;
		}
		
		return arr.join('');
	},
	
	// De addChatLine methode voegt een chat entry toe aan de gastenboek
	addChatLine: function( params ) {
		// Alle tijden worden getoond in de tijdzone van de gebruiker
		var d = new Date();
		
		if( params.time ) {
			// PHP returns de tijd in UTC (GMT). We gebruiken het om het tijdsobject
			// te vullen en later het te tonen in de tijdzone van de gebruiker. JavaScript
			// Javascript converteert dit voor ons.
			d.setUTCHours(params.time.hours, params.time.minutes);
		}
		
		params.time = (d.getHours() < 10 ? '0' : '' ) + d.getHours()+':'+
					  (d.getMinutes() < 10 ? '0':'') + d.getMinutes();
					  
		var markup = chat.render('chatLine',params),
			exists = $('#chatLineHolder .chat-'+params.id);
			
		if (exists.length ){
			exists.remove();
		}
		
		if(!chat.data.lastID){
			// Als dit de eerste chat is,
			// verwijder de paragraaf dat zegt dat er geen zijn:
			$('#chatLineHolder p').remove();
		}
		
		// Als dit geen tijdelijke chat is:
		if(params.id.toString().charAt(0) != 't'){
			var previous = $('#chatLineHolder .chat-'+(+params.id - 1));
			if(previous.length){
				previous.after(markup);
			}
			else chat.data.jspAPI.getContentPane().append(markup);
		}
		else chat.data.jspAPI.getContentPane().append(markup);
		
		// Als we nieuwe content toevoegen,
		// moeten we de jScrollPane plugin herinitialiseren:
		chat.data.jspAPI.reinitialise();
		chat.data.jspAPI.scrollToBottom(true);
	},
	
	// Deze methode vraagt de laatste chats op
	// (sinds lastID), en voegt ze toe aan de pagina.
	getChats: function( callback ) {
		$.tzGET('getChats',{lastID: chat.data.lastID},function(r){
			
			for(var i=0;i<r.chats.length;i++){
				chat.addChatLine(r.chats[i]);
			}
			
			if(r.chats.length){
				chat.data.noActivity = 0;
				chat.data.lastID = r.chats[i-1].id;
			}
			else{
				// Als er geen chats ontvangen zijn, 
				// verhoog noActivity teller.
				chat.data.noActivity++;
			}
			
			if(!chat.data.lastID){
				chat.data.jspAPI.getContentPane().html('<p class="noChats">Nog geen chats</p>');
			}
			
			// Zet een timeout voor de volgende request,
			// afhankelijke van de chat activiteit:
			
			var nextRequest = 1000;
			
			// 2 seconden
			if(chat.data.noActivity > 3){
				nextRequest = 2000;
			}
			
			if(chat.data.noActivity > 10){
				nextRequest = 5000;
			}
			
			// 15 seconden
			if(chat.data.noActivity > 20){
				nextRequest = 15000;
			}

			setTimeout(callback,nextRequest);
		});
	},
	
	// Vraag een lijst met all gebruikers.
	getUsers: function( callback ) {
		$.tzGET('getUsers',function(r){
			
			var users = [];
			
			for(var i=0; i< r.users.length;i++){
				if(r.users[i]){
					users.push(chat.render('user',r.users[i]));
				}
			}
			
			var message = '';
			
			if(r.total<1){
				message = 'Er is niemand online';
			}
			else {
				message = r.total+' '+(r.total == 1 ? 'persoon':'mensen')+' online';
			}
			
			users.push('<p class="count">'+message+'</p>');
			
			$('#chatUsers').html(users.join(''));
			
			setTimeout(callback,15000);
		});
	},
	
	// Deze methode toont een foutmelding bovenaan het scherm:
	displayError : function(msg){
		var elem = $('<div>',{
			id		: 'chatErrorMessage',
			html	: msg
		});
		
		elem.click(function(){
			$(this).fadeOut(function(){
				$(this).remove();
			});
		});
		
		setTimeout(function(){
			elem.click();
		},5000);
		
		elem.hide().appendTo('body').slideDown();
	}
};

// Custom GET & POST wrappers:

$.tzPOST = function(action,data,callback){
	$.post('PHP/ChatControl.php?action='+action,data,callback,'json');
}

$.tzGET = function(action,data,callback){
	$.get('PHP/ChatControl.php?action='+action,data,callback,'json');
}

// Een custom jQuery methode voor placeholder tekst:

$.fn.defaultText = function(value){
	
	var element = this.eq(0);
	element.data('defaultText',value);
	
	element.focus(function(){
		if(element.val() == value){
			element.val('').removeClass('defaultText');
		}
	}).blur(function(){
		if(element.val() == '' || element.val() == value){
			element.addClass('defaultText').val(value);
		}
	});
	
	return element.blur();
}