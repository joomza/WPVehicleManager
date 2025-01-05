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

registerBlockType( 'jsvehiclemanager/jsvehiclemanagervehiclesblock', {
    title: 'WP Vehicle Manager Vehicles',
    icon: 'universal-access-alt',
    category: 'layout',// category of block (need to check if i can define custom category)
    attributes: {
        heading: {
            type: 'string',
            default: 'Latest Vehicles'
        },
        description: {
            type: 'string',
            default: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
        },
        typeofvehicles:{
            type:'select',
            default:'1'
        },
        numberofvehicles:{
            type:'string',
            default:'6'
        },
        number_of_columns:{
            type:'string',
            default:'3'
        }
    },
    edit: function( props ) {
        return el('div',{},
                el(ServerSideRender, {
                    block: "jsvehiclemanager/jsvehiclemanagervehiclesblock",
                    attributes:  props.attributes
                }),
                
            el( 
                InspectorControls,{},
                el(
                    TextControl, {
                        label: __( 'Heading' ),
                        value: props.attributes.heading,
                        onChange: function(value) {
                            props.setAttributes({heading: value});
                        }
                    }
                ),
                el(
                    TextControl, {
                        label: __( 'Description' ),
                        value: props.attributes.description,
                        onChange: function(value) {
                            props.setAttributes({description: value});
                        }
                    }
                ),
                el(
                    SelectControl,
                    {
                        type: 'number',
                        label: __( 'Type of Vehicles' ),
                        value: props.attributes.typeofvehicles,
                        onChange: function( value ) {
                            props.setAttributes( { typeofvehicles: value } );
                        },
                        options: [
                          { value: '1', label: __( 'Latest Vehicles' ) },
                          { value: '2', label: __( 'Featured Vehicles' ) },
                        ],
                    }
                ),
                el(
                    TextControl, {
                        label: __( 'Number of Vehicles' ),
                        value: props.attributes.numberofvehicles,
                        onChange: function(value) {
                            props.setAttributes({numberofvehicles: value});
                        }
                    }
                ),
                el(
                    TextControl, {
                        label: __( 'Number of Columns' ),
                        value: props.attributes.number_of_columns,
                        onChange: function(value) {
                            props.setAttributes({number_of_columns: value});
                        }
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
