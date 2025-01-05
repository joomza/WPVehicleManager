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

registerBlockType( 'jsvehiclemanager/jsvehiclemanagervehiclesbycitiesblock', {
    title: 'WP Vehicle Manager Vehicles By Cities',
    icon: 'universal-access-alt',
    category: 'layout',// category of block (need to check if i can define custom category)
    attributes: {
        heading: {
            type: 'string',
            default: 'Vehicles By Cities'
        },
        description: {
            type: 'string',
            default: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.'
        },
        numberofcities:{
            type:'string',
            default:'6'
        },
        shownumberofvehiclespercity:{
            type:'select',
            default:'1'
        },
        number_of_columns:{
            type:'string',
            default:'3'
        }
    },

    edit: function( props ) {
        return el('div',{},
                el(ServerSideRender, {
                    block: "jsvehiclemanager/jsvehiclemanagervehiclesbycitiesblock",
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
                    TextControl, {
                        label: __( 'Number of cities' ),
                        value: props.attributes.numberofcities,
                        onChange: function(value) {
                            props.setAttributes({numberofcities: value});
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
                ),
                el(
                    SelectControl,
                    {
                        type: 'number',
                        label: __( 'Show number of vehicles per city' ),
                        value: props.attributes.shownumberofvehiclespercity,
                        onChange: function( value ) {
                            props.setAttributes( { shownumberofvehiclespercity: value } );
                        },
                        options: [
                          { value: '1', label: __( 'Yes' ) },
                          { value: '2', label: __( 'No' ) },
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
