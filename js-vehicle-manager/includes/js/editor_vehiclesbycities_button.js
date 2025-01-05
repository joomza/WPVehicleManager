(function () {
    tinymce.PluginManager.add('jsvehiclemanager_vmvehiclesbycities_button', function (editor, url) {
        editor.addButton('jsvehiclemanager_vmvehiclesbycities_button', {
            title: jslang.main_vehiclesbycities_title,
            text: jslang.main_vehiclesbycities_text,
            icon: 'icon jsvehiclemanager-ouricon-img',
            onclick: function () {
                editor.windowManager.open({
                    title: jslang.window_vehiclesbycities_title,
                    width: 500,
                    height: 300,
                    autoScroll: true,
                    classes: 'jsvehiclemanagerjobseditorclass',
                    body: [
                        {type: 'listbox', name: 'jsvehiclemanagerpageid', label: jslang.detailpage, 'values': list_vmpages },
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
                        {type: 'textbox', name: 'numberofcities', label: jslang.noofcities},
                        {type: 'textbox', name: 'heading', label: jslang.heading},
                        {type: 'textbox', name: 'description', label: jslang.description},
                        
                        
                    ],
                    onsubmit: function (e) {
                        var shcode = makeShortcoldefvehiclesbycities(e.data);
                        editor.insertContent(shcode);
                    }
                });
            }
        });
    });
})();

function makeShortcoldefvehiclesbycities(data) {
    var c = '[vehicle_manager_vm_vehicles_by_cities';
    c += ' jsvehiclemanagerpageid="' + data.jsvehiclemanagerpageid + '"';    
    c += ' number_of_columns="' + data.number_of_columns + '"';
    
    // if (data.speed != '')
    //     c += ' speed="' + data.speed + '"';
    if (data.numberofcities != '')
        c += ' numberofcities="' + data.numberofcities + '"';
    if (data.heading != '')
        c += ' heading="' + data.heading + '"';
    if (data.description != '')
        c += ' description="' + data.description + '"';
    
    c += ']';
    return c;
}
