jQuery(document).ready(function(){
    jQuery('.ptb_post').hide();
    var $rows_container = jQuery('.ptb_first_row');
    if($rows_container.length>0){
       $rows_container.each(function(){
                var $parent = jQuery(this).parent();
                $parent.find('img').addClass('ptb_image');
                if(!$parent.hasClass('ptb_post')){
                    jQuery(this).closest('.ptb_post').html($parent);
                }
	   });
    }
    jQuery('.ptb_post').show();
});