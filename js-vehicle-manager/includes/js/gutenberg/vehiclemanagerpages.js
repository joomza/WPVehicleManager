var el = wp.element.createElement,
registerBlockType = wp.blocks.registerBlockType;
RichText = wp.editor.RichText;
blocks = wp.blocks;
BlockControls = wp.editor.BlockControls,
InspectorControls = wp.editor.InspectorControls;
TextControl = wp.components.TextControl;
SelectControl = wp.components.SelectControl;
__ = wp.i18n.__;
ServerSideRender = wp.components.ServerSideRender;

registerBlockType( 'jsvehiclemanager/jsvehiclemanagerpagesblock', {
    title: 'WP Vehicle Manager Pages',
    icon: 'universal-access-alt',
    category: 'layout',// category of block (need to check if i can define custom category)
    attributes: {
      vehiclemanagerpages:{
        type:'select',
        default:'1'
      }
    },

    edit: function( props ) {
        return el('div',{},
                el(ServerSideRender, {
                    block: "jsvehiclemanager/jsvehiclemanagerpagesblock",
                    attributes:  props.attributes
                }),
                
            el( 
                InspectorControls,{},
                el(
                    SelectControl,
                    {
                        type: 'number',
                        label: __( 'Vehicle Manager Pages' ),
                        value: props.attributes.vehiclemanagerpages,
                        onChange: function( value ) {
                            props.setAttributes( { vehiclemanagerpages: value } );
                        },
                        options: [
                          { value: '1', label: __( 'List Vehicle' ) },
                          { value: '2', label: __( ' Vehicle Search' ) },
                          { value: '3', label: __( 'Add Vehicle' ) },
                          { value: '4', label: __( 'My Vehicles' ) },
                          { value: '5', label: __( 'Control Panel' ) },
                          { value: '6', label: __( 'Comapre Vehicles' ) },
                          { value: '7', label: __( 'Shortlisted Vehicles' ) },
                          { value: '8', label: __( 'Vehicles By City' ) },
                          { value: '9', label: __( 'Vehicles By Type' ) },
                          { value: '10', label: __( 'Vehicles By Make' ) },
                          { value: '11', label: __( 'Sellers List' ) },
                          { value: '12', label: __( 'Sellers By City' ) },
                          { value: '13', label: __( 'Credits Pack' ) },
                          { value: '14', label: __( 'Credits Rate List' ) },
                          { value: '15', label: __( 'Purchase History' ) },
                          { value: '16', label: __( 'Credits Log' ) },
                          { value: '17', label: __( 'Vehicle Alert' ) },
                          { value: '18', label: __( 'Login' ) }
                          
                        ],
                    }
                )
            )
        )
    },
    save: function(props) {
        // Rendering in PHP
        return null;
    },
} )
