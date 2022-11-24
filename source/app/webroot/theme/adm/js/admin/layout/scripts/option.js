jQuery.option =
{
    add: function(obj)
    {
        var item = jQuery(obj).closest('div.row').prev().clone();
        item.find('input:text').val('');
        item.find('input:checkbox').parent().removeClass('checked');
        item.find('input:radio').parent().removeClass('checked');
        item.find('input:checkbox').removeAttr('checked');
        item.find('input:radio').removeAttr('checked');
        
        var ch = item.find('input:checkbox').clone();
        item.find('input:checkbox').parents('.checker').before(ch);
        item.find('input:checkbox').parents('.checker').remove();
        item.find('input:checkbox').uniform();
        
        var ch = item.find('input:radio').clone();
        item.find('input:radio').parents('.radio').before(ch);
        item.find('input:radio').parents('.radio').remove();
        item.find('input:radio').uniform();
        
        jQuery(obj).closest('div.row').before(item);
        jQuery.uniform.update();
        this.init();
        return false;
    },
    
    remove: function(obj)
    {
        if(confirm("Are you sure ?"))
        {
            jQuery(obj).parents('.option-item').remove();
        }
        this.init();
        return false;
    },
    
    init: function()
    {
        var checkbox_name = jQuery('#checkbox_name').val();
        var radio_name = jQuery('#radio_name').val();
        jQuery('.option-holder').each(function(){
            var item = jQuery(this).find('.option-item');
            if(item.length < 2)
            {
                item.find('a.option-remove').hide();
            }
            else
            {
                item.find('a.option-remove').show();
            }
        })
        jQuery('.option-item').each(function(index){
            $(this).find('input[type=checkbox]').attr('name', checkbox_name + '[' + index + ']');
            $(this).find('input[type=radio]').val(index);
        })
        
    },
    
    optionType: function(val)
    {
        jQuery('.value-option').hide();
        switch(val)
        {
            case "text":
                $('#value-text').show();
                break;
            case "radio":
            case "select":
                $('.value-radio').show();
                $('.value-checkbox').hide();
                $('#value-select').show();
                break;
            case "checkbox":
                $('.value-checkbox').show();
                $('.value-radio').hide();
                $('#value-select').show();
                break;
            case "textarea":
                $('#value-textarea').show();
                break;
            case "timezone":
                $('#value-timezone').show();
                break;
            case "language":
                $('#value-language').show();
                break;
        }
    }
}

jQuery(window).load(function(){
    jQuery.option.init();
    jQuery.option.optionType(jQuery('#type_id').val());
})

jQuery(document).on('change', '#type_id', function(){
    jQuery.option.optionType(jQuery(this).val());
})
