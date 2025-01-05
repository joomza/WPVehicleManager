(function () {
    tinymce.PluginManager.add('jsvehiclemanager_featuredvehicles_button', function (editor, url) {
        editor.addButton('jsvehiclemanager_featuredvehicles_button', {
            title: jslang.main_fv_title,
            text: jslang.main_fv_text,
            icon: 'icon jsvehiclemanager-ouricon-img',
            onclick: function () {
                editor.windowManager.open({
                    title: jslang.window_fv_title,
                    width: 500,
                    height: 300,
                    autoScroll: true,
                    classes: 'jsvehiclemanagerjobseditorclass',
                    body: [
                        {type: 'listbox', name: 'jsvehiclemanagerpageid', label: jslang.detailpage, 'values': list_vmpages },
                        {type: 'listbox', name: 'style', label: jslang.slidestyle,
                            'values': [
                                {text: jslang.wholeslide , value: '1'},
                                {text: jslang.singleslide , value: '2'}
                            ]
                        },
                        {type: 'textbox', name: 'speed', label: jslang.slidespeed},
                        {type: 'textbox', name: 'posts_per_page', label: jslang.noofvehicles},
                        {type: 'textbox', name: 'heading', label: jslang.heading},
                        {type: 'textbox', name: 'description', label: jslang.description}
                    ],
                    onsubmit: function (e) {
                        var shcode = makeShortcoldefvehicle(e.data);
                        editor.insertContent(shcode);
                    }
                });
            }
        });
    });
})();

function makeShortcoldefvehicle(data) {
    var c = '[cm_featured_vehicles';
    c += ' jsvehiclemanagerpageid="' + data.jsvehiclemanagerpageid + '"';    
    c += ' style="' + data.style + '"';
    
    if (data.speed != '')
        c += ' speed="' + data.speed + '"';
    if (data.posts_per_page != '')
        c += ' posts_per_page="' + data.posts_per_page + '"';
    if (data.heading != '')
        c += ' heading="' + data.heading + '"';
    if (data.description != '')
        c += ' description="' + data.description + '"';

    c += ']';
    return c;
}
