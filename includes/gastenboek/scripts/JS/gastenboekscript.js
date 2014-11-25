$(document).ready(function(){

    chat.init();

});

var chat = {

    // data holds variables for use in the class:

    data : {
        lastID         : 0,
        noActivity    : 0
    },

    // Init binds event listeners and sets up timers:

    init : function(){

        // Using the defaultText jQuery plugin, included at the bottom:
        $('#name').defaultText('Nickname');
        $('#email').defaultText('Email (Gravatars are Enabled)');

        // Converting the #chatLineHolder div into a jScrollPane,
        // and saving the plugin's API in chat.data:

        chat.data.jspAPI = $('#chatLineHolder').jScrollPane({
            verticalDragMinHeight: 12,
            verticalDragMaxHeight: 12
        }).data('jsp');

        // We use the working variable to prevent
        // multiple form submissions:

        var working = false;

        // Logging a person in the chat:

        $('#loginForm').submit(function(){

            if(working) return false;
            working = true;

            // Using our tzPOST wrapper function
            // (defined in the bottom):

            $.tzPOST('login',$(this).serialize(),function(r){
                working = false;

                if(r.error){
                    chat.displayError(r.error);
                }
                else chat.login(r.name,r.gravatar);
            });

            return false;
        });