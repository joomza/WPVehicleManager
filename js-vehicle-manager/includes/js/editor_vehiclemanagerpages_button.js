(function () {
    tinymce.PluginManager.add('jsvehiclemanager_vmpages_button', function (editor, url) {
        editor.addButton('jsvehiclemanager_vmpages_button', {
            title: jslang.main_vmpages_title,
            text: jslang.main_vmpages_text,
            icon: 'icon jsvehiclemanager-ouricon-img',
            onclick: function () {
                editor.windowManager.open({
                    title: jslang.window_vmpages_title,
                    width: 500,
                    height: 200,
                    autoScroll: true,
                    classes: 'jsvehiclemanagerjobseditorclass',
                    body: [
                        {
                            type: 'listbox', 
                            name: 'page', 
                            label: jslang.selectpage, 
                            'values': [
                                {text : jslang.listvehicles , value : '1'} ,
                                {text : jslang.searchvehicles , value : '2'} ,
                                {text : jslang.addvehicle , value : '3'} ,
                                {text : jslang.myvehicles , value : '4'} ,
                                {text : jslang.myprofile , value : '5'} ,
                                {text : jslang.comparevehicles , value : '6'} ,
                                {text : jslang.vehicledetail , value : '7'} ,
                                {text : jslang.shortlistedvehicles , value : '8'} ,
                                {text : jslang.vehiclesbycity , value : '9'} ,
                                {text : jslang.vehiclesbytype , value : '10'} ,
                                {text : jslang.vehiclesbymake , value : '11'} ,
                                {text : jslang.sellerlist , value : '12'} ,
                                {text : jslang.sellerdetail , value : '13'} ,
                                {text : jslang.creditspack , value : '14'} ,
                                {text : jslang.creditsratelist , value : '15'} ,
                                {text : jslang.purchasehistory , value : '16'} ,
                                {text : jslang.creditslog , value : '17'} ,
                                {text : jslang.vehiclealert , value : '18'} ,
                                {text : jslang.login , value : '19'} ,
                                {text : jslang.thankyou , value : '20'},
                                {text : jslang.sellersbycity , value : '21'},
                            ],
                            onselect : function(v) {                                
                                if(this.value() == 20){
                                    jQuery('input.mce-cm_buttonforty').parent().parent().show();
                                    // jQuery('input.mce-cm_buttonforty').show();
                                }else{
                                    // jQuery('input.mce-cm_buttonforty').hide();
                                    jQuery('input.mce-cm_buttonforty').parent().parent().hide();
                                }
                            },
                        },
                        {type: 'textbox', name: 'title', label: jslang.title , classes: 'jsvm_cm_buttonforty',},
                        {type: 'textbox', name: 'message', label: jslang.message , classes: 'jsvm_cm_buttonforty',},
                    ],
                    onsubmit: function (e) {
                        var shcode = makeShortcoldevmpages(e.data);
                        editor.insertContent(shcode);
                    }
                });
            }
        });
    });
})();

function makeShortcoldevmpages(data) {

    var c = '[cm_vehicle_manager_pages';
    if (data.page != '')
        c += ' page="' + data.page + '"';
    if (data.title != '')
        c += ' title="' + data.title + '"';
    if (data.message != '')
        c += ' message="' + data.message + '"';

    c += ']';
    return c;
}
