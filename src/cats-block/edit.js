import ServerSideRender from '@wordpress/server-side-render';
import { __ } from '@wordpress/i18n';
import { SelectControl, 
    Toolbar,
    Button,
    Tooltip,
    PanelBody,
    PanelRow,
    FormToggle,
    ToggleControl,
    ToolbarGroup,
    Disabled, 
    RadioControl,
    RangeControl,
    TextControl,
    CheckboxControl,
    FontSizePicker } from '@wordpress/components';

    import {
        RichText,
        AlignmentToolbar,
        BlockControls,
        BlockAlignmentToolbar,
        InspectorControls,
        InnerBlocks,
        withColors,
        PanelColorSettings,
        getColorClassName
    } from '@wordpress/block-editor'
    ;
import { withSelect, widthDispatch } from '@wordpress/data';
import { useState } from '@wordpress/element';

const {
    withState
} = wp.compose;

const settingsidOptions = [
 ];

 wp.apiFetch({path: "/link-library/v1/settingslist"}).then(posts => {
    jQuery.each( posts, function( key, val ) {
        settingsidOptions.push( {label: 'Library #' + key + ': ' + val, value: key} );
    });
}).catch( 

)

const categoryOptions = [
];

wp.apiFetch({path: "/wp/v2/link_library_category?per_page=100"}).then(posts => {
    jQuery.each( posts, function( key, val ) {
        categoryOptions.push({label: val.name, value: val.id});
    });
}).catch( 

)
const edit = props => {
    const {attributes: { settings, categorylistoverride, excludecategoryoverride, targetlibrary, categorylistoverrideCSV, excludecategoryoverrideCSV }, className, setAttributes } = props;

    const setSettingsID = settings => {
        props.setAttributes( { settings } );
    };

    const setOverrideCategories = categorylistoverride => {
        props.setAttributes( { categorylistoverride } );
    };

    const setExcludeOverrideCategories = excludecategoryoverride => {
        props.setAttributes( { excludecategoryoverride } );
    };

    const setTargetLibrary = targetlibrary => {
        props.setAttributes( { targetlibrary } );
    };

    const setCategoryOverrideArrayCSV = categorylistoverrideCSV => {
        props.setAttributes( { categorylistoverrideCSV } );
    }

    const setExcludeCategoryOverrideArrayCSV = excludecategoryoverrideCSV => {
        props.setAttributes( { excludecategoryoverrideCSV } );
    }


    const inspectorControls = (
        <InspectorControls key="inspector">
            <PanelBody>
                <PanelRow>
                    <SelectControl
                        label="Library Configuration"
                        value={ settings }
                        options= { settingsidOptions }
                        onChange = { setSettingsID }
                    />
                </PanelRow>
            </PanelBody>
            <PanelBody title={ __( 'Configuration overrides' )} initialOpen={ false }>
                <PanelRow>
                    <span className="link-library-cat-override">
                    <SelectControl
                        multiple
                        label = "Override Categories to display"
                        help = "Select one or more categories to override library category list. Ctrl-Click to select multiple items or deselect an item."
                        value = { categorylistoverride }
                        options = { categoryOptions }
                        onChange = { setOverrideCategories }
                    />
                    </span>
                </PanelRow>
                <PanelRow>
                    <span className="link-library-cat-exclude-override">
                    <SelectControl
                        multiple
                        label = "Override Categories to be excluded"
                        help = "Select one or more categories to override excluded category list. Ctrl-Click to select multiple items or deselect an item."
                        value = { excludecategoryoverride }
                        options = { categoryOptions }
                        onChange = { setExcludeOverrideCategories }
                    />
                    </span>
                </PanelRow>
                <PanelRow>
                    <SelectControl
                        label="Target Library"
                        value={ targetlibrary }
                        options= { settingsidOptions }
                        onChange = { setTargetLibrary }
                    />
                </PanelRow>
            </PanelBody>
            <PanelBody title={ __( 'CSV category list overrides' )} initialOpen={ false }>
                <PanelRow>
                    <TextControl
                        label = "Comma-separated list of category IDs to display"
                        value = { props.attributes.categorylistoverrideCSV }
                        onChange = { setCategoryOverrideArrayCSV }
                    />
                </PanelRow>
                <PanelRow>
                    <TextControl
                        label = "Comma-separated list of category IDs to exclude"
                        value = { props.attributes.excludecategoryoverrideCSV }
                        onChange = { setExcludeCategoryOverrideArrayCSV }
                    />
                </PanelRow>
            </PanelBody>
        </InspectorControls>
    );
    return [
        <div className={ props.className } key="returneddata">
            <div className="ll-block-warning">Warning: Some Link Library features like Pagination, AJAX category switching and Masonry layout won't work as you build your page in the Block Editor but will work correctly when viewed on your site.</div>
            <ServerSideRender
                block="link-library/cats-block"
                attributes = {props.attributes}
            />
            { inspectorControls }

        </div>
    ];
};

export default edit;
