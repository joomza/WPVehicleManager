(function () {
    tinymce.PluginManager.add('jsvehiclemanager_vmvehicles_button', function (editor, url) {
        editor.addButton('jsvehiclemanager_vmvehicles_button', {
            title: jslang.main_vehicles_title,
            text: jslang.main_vehicles_text,
            icon: 'icon jsvehiclemanager-ouricon-img',
            onclick: function () {
                editor.windowManager.open({
                    title: jslang.window_vehicles_title,
                    width: 500,
                    height: 300,
                    autoScroll: true,
                    classes: 'jsvehiclemanagerjobseditorclass',
                    body: [
                        {type: 'listbox', name: 'jsvehiclemanagerpageid', label: jslang.detailpage, 'values': list_vmpages },
                        {type: 'listbox', name: 'typeofvehicles', label: jslang.typeofvehicles,
                            'values': [
                                {text: jslang.latestvehicles, value: '1'},
                                {text: jslang.featuredvehicles, value: '2'}
                            ]
                        },
                        {type: 'listbox', name: 'number_of_columns', label: jslang.number_of_columns,
                            'values': [
                                {text: jslang.one_column , value: '1'},
                                {text: jslang.two_column , value: '2'},
                                {text: jslang.three_column , value: '3'},
                                {text: jslang.four_column , value: '4'},
                                {text: jslang.five_column , value: '5'},
                                {text: jslang.six_column , value: '6'}
                            ]
                        },
                        //{type: 'textbox', name: 'speed', label: jslang.slidespeed},
                        //{type: 'textbox', name: 'number_of_columns', label: jslang.number_of_columns},
                        {type: 'textbox', name: 'numberofvehicles', label: jslang.noofvehicles},
                        {type: 'textbox', name: 'heading', label: jslang.heading},
                        {type: 'textbox', name: 'description', label: jslang.description},
                        
                        
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
    var c = '[vehicle_manager_vm_vehicles';
    c += ' jsvehiclemanagerpageid="' + data.jsvehiclemanagerpageid + '"';    
    c += ' number_of_columns="' + data.number_of_columns + '"';
    c += ' typeofvehicles="' + data.typeofvehicles + '"';
    
    // if (data.speed != '')
    //     c += ' speed="' + data.speed + '"';
    if (data.numberofvehicles != '')
        c += ' numberofvehicles="' + data.numberofvehicles + '"';
    if (data.heading != '')
        c += ' heading="' + data.heading + '"';
    if (data.description != '')
        c += ' description="' + data.description + '"';
    
    c += ']';
    return c;
}
