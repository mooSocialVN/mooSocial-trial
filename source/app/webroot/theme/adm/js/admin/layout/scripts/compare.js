jQuery.compare =
{
    add: function()
    {
        var item = jQuery('.compare_blank').clone().removeClass('compare_blank').show();
        jQuery('.compare_blank').parent().find('tr:last').before(item);
        this.init();
        return false;
    },
    
    remove: function(obj)
    {
        if(confirm("Are you sure ?"))
        {
            jQuery(obj).closest('tr').remove();
        }
        return false;
    },
    
    removeAll: function()
    {
        if(confirm("Are you sure ?"))
        {
            jQuery('.compare').not('.compare_blank').remove();
            this.init();
        }
        return false;
    },
    
    init: function()
    {
        jQuery('.compare_blank').hide();
        jQuery('.compare_type_value').hide();
        jQuery('.compare_type').each(function(){
            var item = jQuery(this).parent('td');
            switch (jQuery(this).val())
            {
                case 'text':
                    item.find('.type_text').show();
                    break;
                case 'yesno':
                    item.find('.type_yesno').hide();
                    if(item.find('.yesno_value').val() == 1)
                    {
                        item.find('.type_yes').show();
                    }
                    else 
                    {
                        item.find('.type_no').show();
                    }
                    break;
                default :
                    item.find('.type_text').show();
            }
        })
        if(jQuery('.compare').not('.compare_blank').length < 1)
        {
            jQuery('#removeAll').attr('disabled', 'true');
        }
        else 
        {
            jQuery('#removeAll').removeAttr('disabled');
        }
    },
    
    switchType:function(item)
    {
        item = item.parents('td');
        if(item.find('.type_text').is(':visible'))
        {
            item.find('.compare_type').val('yesno');
        }
        else 
        {
            item.find('.compare_type').val('text');
        }
        this.init();
        return false;
    },
    
    switchYesNo:function(item, val)
    {
        item.parent().find('.type_yesno').show();
        item.hide();
        item.closest('td').find('.yesno_value').val(val);
        return false;
    },
}

jQuery(window).load(function(){
    jQuery.compare.init();
})