(function () {
    var mediaUploader;        
    tinymce.PluginManager.add('jsvehiclemanager_searchvehicles_button', function (editor, url) {
        editor.addButton('jsvehiclemanager_searchvehicles_button', {
            title: jslang.main_vsearch_title,
            text: jslang.main_vsearch_text,
            icon: 'icon jsvehiclemanager-ouricon-img',
            onclick: function () {
                editor.windowManager.open({
                    title: jslang.window_vsearch_title,
                    width: 500,
                    height: 300,
                    autoScroll: true,
                    classes: 'jsvehiclemanagerjobseditorclass',
                    body: [
                        {type: 'listbox', name: 'jsvehiclemanagerpageid', label: jslang.detailpage, 'values': list_vmpages },
                        {type: 'listbox', name: 'style', label: jslang.searchvehiclestyle,
                            'values': [
                                {text: jslang.styleone , value: '1'},
                                {text: jslang.styletwo , value: '2'},
                                {text: jslang.stylethree , value: '3'},
                                {text: jslang.stylefour , value: '4'},
                            ]
                        },
                        {type: 'textbox', name: 'title', label: jslang.title},
                        {type: 'textbox', name: 'shortdescription', label: jslang.shortdescription},
                        {type: 'textbox', name: 'background_image', label: jslang.backgroundimage , classes: 'jsvmbgimage'},
                        {
                            type: 'button',
                            name: 'my_upload_button',
                            label: '',
                            text: jslang.selectbgimage,
                            classes: 'jsvm_my_upload_button',
                            onclick: function( e ) {
                                // If the uploader object has already been created, reopen the dialog
                                if (mediaUploader) {
                                    mediaUploader.open();
                                    return;
                                }
                                // Extend the wp.media object
                                mediaUploader = wp.media.frames.file_frame = wp.media({
                                    title: jslang.selectbgimage,
                                    button: {
                                        text: jslang.selectimage
                                    }
                                    , multiple: false 
                                });
                                // When a file is selected, grab the URL and set it as the text field's value
                                mediaUploader.on('select', function() {
                                    attachment = mediaUploader.state().get('selection').first();
                                    jQuery('input.mce-jsvmbgimage').val(attachment.id);
                                });
                                // Open the uploader dialog
                                mediaUploader.open();                                
                            },
                        },                        
                    ],
                    onsubmit: function (e) {
                        var shcode = makeShortcoldevehiclesearch(e.data);
                        editor.insertContent(shcode);
                    }
                });
            }
        });
    });
})();

function makeShortcoldevehiclesearch(data) {
    var c = '[cm_vehicle_search';
    c += ' jsvehiclemanagerpageid="' + data.jsvehiclemanagerpageid + '"';    
    c += ' style="' + data.style + '"';

    if (data.title != '')
        c += ' title="' + data.title + '"';
    if (data.shortdescription != '')
        c += ' shortdescription="' + data.shortdescription + '"';
    if (data.background_image != '')
        c += ' background_image="' + data.background_image + '"';

    c += ']';
    return c;
}