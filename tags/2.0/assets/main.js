jQuery(document).ready(function(e) {
   
    jQuery('#classic_plugin_switch').bootstrapSwitch('size', 'small');
	jQuery('#classic_plugin_switch').bootstrapSwitch('onColor', 'success');
	jQuery('#classic_plugin_switch').bootstrapSwitch('offColor', 'danger');
	
	jQuery('#plugin_switch').bootstrapSwitch('size', 'small');
	jQuery('#plugin_switch').bootstrapSwitch('onColor', 'success');
	jQuery('#plugin_switch').bootstrapSwitch('offColor', 'danger');

	
	jQuery(function() { 
    jQuery('#save-gua-settings').click(function(e) {
        	var property_id	=	jQuery('#web_property_id').val();
			var ajax_url	=	jQuery('#ajax_url').val();
			if(jQuery('#in_footer').is(':checked')){
				var in_footer	=	'on';	
			}else{
				var in_footer	=	'off';
			}
			
			if(jQuery('#plugin_switch').is(':checked')){
				var plugin_switch	=	'on';	
			}else{
				var plugin_switch	=	'off';
			}
			
			if(jQuery('#track_links').is(':checked')){
				var track_links	=	'on';	
			}else{
				var track_links	=	'off';
			}
			
			if(property_id.indexOf('UA-') == -1){
				jQuery('#web_property_id').parent('.col-sm-9').addClass('has-error');
				jQuery('.error').css('color', '#F00').removeClass('hide');
				
			}else{
				//alert('ok proceed on ajax');
				$.ajax({
        			url: ajax_url,
        			data: {
            				'action':'save_google_universal_analytics_settings',
            				'plugin_switch' : plugin_switch,
							'in_footer' : in_footer,
							'property_id' : property_id,
							'track_links' : track_links,
        				},
        			success:function(data) {
            		jQuery('#web_property_id').parent('.has-error').removeClass('has-error');
					jQuery('.error').addClass('hide');
					jQuery('.form-horizontal .alert').fadeIn().removeClass('hide');
					jQuery('.form-horizontal .alert').delay(3000).fadeOut(500);		
						
        			},
					error: function(errorThrown){
						
					}
    });
				
			
			}
	    });		
});


jQuery(function(){
	
	//classic settings event
		
		jQuery('#save-classic-settings').click(function(e) {
			
        	var classic_property_id	=	jQuery('#classic_web_property_id').val();
			
			var ajax_url	=	jQuery('#ajax_url').val();
			if(jQuery('#classic_in_footer').is(':checked')){
				var classic_in_footer	=	'on';	
			}else{
				var classic_in_footer	=	'off';
			}
			
			if(jQuery('#classic_plugin_switch').is(':checked')){
				var classic_plugin_switch	=	'on';	
			}else{
				var classic_plugin_switch	=	'off';
			}
			
			
			if(classic_property_id.indexOf('UA-') == -1){
				jQuery('#classic_web_property_id').parent('.col-sm-9').addClass('has-error');
				jQuery('.error').css('color', '#F00').removeClass('hide');
				
			}else{
				//alert('ok proceed on ajax');
				$.ajax({
        			url: ajax_url,
        			data: {
            				'action':'save_google_classic_analytics_settings',
            				'classic_plugin_switch' : classic_plugin_switch,
							'classic_in_footer' : classic_in_footer,
							'classic_property_id' : classic_property_id,
        				},
        			success:function(data) {
            		jQuery('#classic_web_property_id').parent('.has-error').removeClass('has-error');
					jQuery('.error').addClass('hide');
					jQuery('.form-horizontal .alert').fadeIn().removeClass('hide');
					jQuery('.form-horizontal .alert').delay(3000).fadeOut(500);		
						
        			},
					error: function(errorThrown){
						
					}
    });
				
			
			}
	    });	
});


});