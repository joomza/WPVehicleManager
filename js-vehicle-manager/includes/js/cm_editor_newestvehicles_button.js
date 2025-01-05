(function () {
    tinymce.PluginManager.add('jsvehiclemanager_newestvehicles_button', function (editor, url) {
        editor.addButton('jsvehiclemanager_newestvehicles_button', {
            title: jslang.main_newv_title,
            text: jslang.main_newv_text,
            icon: 'icon jsvehiclemanager-ouricon-img',
            onclick: function () {
                editor.windowManager.open({
                    title: jslang.window_newv_title,
                    width: 500,
                    height: 300,
                    autoScroll: true,
                    classes: 'jsvehiclemanagerjobseditorclass',
                    body: [
                        {type: 'listbox', name: 'jsvehiclemanagerpageid', label: jslang.detailpage, 'values': list_vmpages },
                        {type: 'listbox', name: 'style', label: jslang.slidestyle,
                            'values': [
                                {text: jslang.styleone , value: '1'},
                                {text: jslang.styletwo , value: '2'},
                                {text: jslang.stylethree , value: '3'},
                                {text: jslang.stylefour , value: '4'},
                            ]
                        },
                        {type: 'textbox', name: 'posts_per_page', label: jslang.noofvehicles},
                        {type: 'textbox', name: 'heading', label: jslang.heading},
                        {type: 'textbox', name: 'description', label: jslang.description}
                    ],
                    onsubmit: function (e) {
                        var shcode = makeShortcoldenewvehicle(e.data);
                        editor.insertContent(shcode);
                    }
                });
            }
        });
    });
})();

function makeShortcoldenewvehicle(data) {
    var c = '[cm_newest_vehicles';
    c += ' jsvehiclemanagerpageid="' + data.jsvehiclemanagerpageid + '"';    
    c += ' style="' + data.style + '"';

    if (data.posts_per_page != '')
        c += ' posts_per_page="' + data.posts_per_page + '"';
    if (data.heading != '')
        c += ' heading="' + data.heading + '"';
    if (data.description != '')
        c += ' description="' + data.description + '"';

    c += ']';
    return c;
}
