jQuery(function() {
    var $customFieldCheckbox = $('.customfield-checkbox').prop('checked'),
        $customFields        = $('#gaddon-setting-row-mappedFieldsCustom, #_gform_setting_mappedFieldsCustom_container');

    // If checkbox is checked show custom fields
    if( $customFieldCheckbox ) {
        $customFields.show();
    }
});