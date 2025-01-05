(function() {
    tinymce.PluginManager.add('jsvm_gavickpro_tc_button', function( editor, url ) {
        editor.addButton( 'jsvm_gavickpro_tc_button', {
            text: 'My test button',
            icon: false,
            onclick: function() {
                editor.insertContent('Hello World!');
            }
        });
    });
})();