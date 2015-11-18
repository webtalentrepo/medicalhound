!function( $ ) {
	"use strict"; // jshint ;_;
	
	$(document).ready(function () {
		
		$('[data-auto-open].dhvc-form-popup').each(function(){
			var $this = $(this),
				id = $this.attr('id'),
				open_delay = $this.data('open-delay'),
				auto_close = $this.data('auto-close'),
				close_delay = $this.data('close-delay'),
				one_time = $this.data('one-time'),
				open_timeout,
				close_timeout;
			clearTimeout(open_timeout);
			clearTimeout(close_timeout);
			open_timeout = setTimeout(function(){
				clearTimeout(close_timeout);	
				
				if(one_time){
					if(!$.cookie(id)){
						$('.dhvc-form-pop-overlay').show();
						$this.show();
						$.cookie(id,1,{ expires: 360 * 10 , path: "/" });
					}
				}else{
					$.cookie(id,0,{ expires: -1});
					$('.dhvc-form-pop-overlay').show();
					$this.show();
				}
			},open_delay);
			
			if(auto_close){
				close_timeout = setTimeout(function(){
					clearTimeout(open_timeout);
					$('.dhvc-form-pop-overlay').hide();
					$this.hide();
					
				},close_delay);
			}
			
		});
		
		$(document).on('click','[data-toggle="dhvcformpopup"]',function(e){
			e.stopPropagation();
			e.preventDefault();
			
			var $this = $(this);
			var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))); // strip for ie7
			if ($this.is('a')) e.preventDefault();
			$('.dhvc-form-pop-overlay').show();
			$target.show();
			$target.off('click').on('click',function(e){
				 if (e.target !== e.currentTarget) return
				$('.dhvc-form-pop-overlay').hide();
				$target.hide();
				
			});
		});
		
		$(document).on('click','.dhvc-form-popup-close',function(e){
			$('.dhvc-form-pop-overlay').hide();
			$(this).closest('.dhvc-form-popup').hide();
		});
		
		
		$('.dhvc-form-slider-control').each(function(){
			var $this = $(this);
			$this.slider({
				 min: $this.data('min'),
			     max: $this.data('max'),
			     range: ($this.data('type') == 'range' ? true : 'min'),
			     slide: function(event, ui){
			    	 if($this.data('type') == 'range'){
			    		 $this.closest('.dhvc-form-group').find('.dhvc-form-slider-value-from').text(ui.values[0]);
			    		 $this.closest('.dhvc-form-group').find('.dhvc-form-slider-value-to').text(ui.values[1]);
			    		 $this.closest('.dhvc-form-group').find('input[type="hidden"]').val(ui.values[0] + '-' + ui.values[1]).trigger('change');
			    	 }else{
			    		 $this.closest('.dhvc-form-group').find('.dhvc-form-slider-value').text(ui.value);
			    		 $this.closest('.dhvc-form-group').find('input[type="hidden"]').val(ui.value).trigger('change');
			    	 }
			     }
			});
			if($this.data('type') == 'range'){
				$this.slider('values',[0,$this.data('minmax')]);
			}else{
				$this.slider('value',$this.data('value'));
			}
		});
		
		
		var operators = {
		    '>': function(a, b) { return a > b },
		    '=': function(a, b) { return a == b },
		    '<': function(a, b) { return a < b }
		};
		var conditional_hook = function(e){
			var $this = $(e.currentTarget),
				form = $this.closest('form'),
				container_class = dhvcformL10n.container_class,
				master_container = $this.closest(container_class),
				master_value,
				is_empty,
				conditional_data = $this.data('conditional');
			
			master_value = $this.is(':checkbox') ? $.map(form.find('[data-conditional-name=' + $this.data('conditional-name') + '].dhvc-form-value:checked'),
	                function (element) {
						return $(element).val();
	            	})
	            : ($this.is(':radio') ? form.find('[data-conditional-name=' + $this.data('conditional-name') + '].dhvc-form-value:checked').val() : $this.val() );
	       is_empty = $this.is(':checkbox') ? !form.find('[data-conditional-name=' + $this.data('conditional-name') + '].dhvc-form-value:checked').length
                 : ( $this.is(':radio') ? !form.find('[data-conditional-name=' + $this.data('conditional-name') + '].dhvc-form-value:checked').val() : !master_value.length )  ;
	       
	       
	        if(is_empty){
	        	$.each(conditional_data,function(i,conditional){
	        		var elements = conditional.element.split(',');
	        		$.each(elements,function(index,element){
						var $this = form.find('.dhvc-form-control-'+element);
						$this.closest(container_class).addClass('dhvc-form-hidden');
					});
	        	});
	        	$.each(conditional_data,function(i,conditional){
					var elements = conditional.element.split(',');
		        	if(conditional.type == 'is_empty'){
		        		if(conditional.action == 'hide'){
							$.each(elements,function(index,element){
								var $this = form.find('.dhvc-form-control-'+element);
								$this.closest(container_class).addClass('dhvc-form-hidden');
								$this.trigger('change');
							});
						}else{
							$.each(elements,function(index,element){
								var $this = form.find('.dhvc-form-control-'+element);
								$this.closest(container_class).removeClass('dhvc-form-hidden');
								$this.trigger('change');
							});
						}
		        	}
	        	});
	        }else{
				$.each(conditional_data,function(i,conditional){
					var elements = conditional.element.split(',');
					
					if(master_container.hasClass('dhvc-form-hidden')) {
						$.each(elements,function(index,element){
							var $this = form.find('.dhvc-form-control-'+element);
							$this.closest(container_class).addClass('dhvc-form-hidden');
						});
					}else{
						if(conditional.type == 'not_empty'){
							if(conditional.action == 'hide'){
								$.each(elements,function(index,element){
									var $this = form.find('.dhvc-form-control-'+element);
									$this.closest(container_class).addClass('dhvc-form-hidden');
									$this.trigger('change');
								});
							}else{
								$.each(elements,function(index,element){
									var $this = form.find('.dhvc-form-control-'+element);
									$this.closest(container_class).removeClass('dhvc-form-hidden');
									$this.trigger('change');
								});
							}
						}else if(conditional.type == 'is_empty'){
							
							if(conditional.action == 'hide'){
								$.each(elements,function(index,element){
									var $this = form.find('.dhvc-form-control-'+element);
									$this.closest(container_class).removeClass('dhvc-form-hidden');
									$this.trigger('change');
								});
							}else{
								$.each(elements,function(index,element){
									var $this = form.find('.dhvc-form-control-'+element);
									$this.closest(container_class).addClass('dhvc-form-hidden');
									$this.trigger('change');
								});
							}
						}else{
							if($.isArray(master_value)){
								if($.inArray(conditional.value,master_value) > -1){
									if(conditional.action == 'hide'){
										$.each(elements,function(index,element){
											var $this = form.find('.dhvc-form-control-'+element);
											$this.closest(container_class).addClass('dhvc-form-hidden');
											$this.trigger('change');
										});
									}else{
										$.each(elements,function(index,element){
											var $this = form.find('.dhvc-form-control-'+element);
											$this.closest(container_class).removeClass('dhvc-form-hidden');
											$this.trigger('change');
										});
									}
								}else{
									if(conditional.action == 'hide'){
										$.each(elements,function(index,element){
											var $this = form.find('.dhvc-form-control-'+element);
											$this.closest(container_class).removeClass('dhvc-form-hidden');
											$this.trigger('change');
										});
									}else{
										$.each(elements,function(index,element){
											var $this = form.find('.dhvc-form-control-'+element);
											$this.closest(container_class).addClass('dhvc-form-hidden');
											$this.trigger('change');
										});
									}
								}
							}else{
								
						        if ($.isNumeric(master_value))
						        {
						        	master_value = parseInt(master_value);
						        }
						        if ($.isNumeric(conditional.value) &&  conditional.value !='0')
						        {
						        	conditional.value = parseInt(conditional.value);
						        }
								if(conditional.type != 'not_empty' && conditional.type != 'is_empty' && operators[conditional.type](master_value,conditional.value)){
									
									if(conditional.action == 'hide'){
										$.each(elements,function(index,element){
											var $this = form.find('.dhvc-form-control-'+element);
											$this.closest(container_class).addClass('dhvc-form-hidden');
											$this.trigger('change');
										});
									}else{
										$.each(elements,function(index,element){
											var $this = form.find('.dhvc-form-control-'+element);
											$this.closest(container_class).removeClass('dhvc-form-hidden');
											$this.trigger('change');
										});
									}
								}else{
									if(conditional.action == 'hide'){
										$.each(elements,function(index,element){
											var $this = form.find('.dhvc-form-control-'+element);
											$this.closest(container_class).removeClass('dhvc-form-hidden');
											$this.trigger('change');
										});
									}else{
										$.each(elements,function(index,element){
											var $this = form.find('.dhvc-form-control-'+element);
											$this.closest(container_class).addClass('dhvc-form-hidden');
											$this.trigger('change');
										});
									}
								}
							}
						}
					}
					
				});
	        }
		}
		var conditional_init = function(){
			$('form.dhvcform').each(function(){
				var form = $(this),
					master_box = form.find('.dhvc-form-conditional');
				
				
				$.each(master_box,function(){
					var masters = $(this).find('[data-conditional].dhvc-form-value');
					$(masters).bind('keyup change',conditional_hook);
					$.each(masters,function(){
						conditional_hook({currentTarget: $(this) });
					});
				});
			});
		};
		conditional_init();
		
		if($('.dhvc-form-datepicker').length){
			$('.dhvc-form-datepicker').datetimepicker({
				format: dhvcformL10n.date_format,
				lang: dhvcformL10n.datetimepicker_lang,
				timepicker:false,
				scrollMonth:false,
				scrollTime:false,
				scrollInput:false
			});
		}
		if($('.dhvc-form-timepicker').length){
			$('.dhvc-form-timepicker').datetimepicker({
				format: dhvcformL10n.time_format,
				lang: dhvcformL10n.datetimepicker_lang,
				datepicker:false,
				scrollMonth:false,
				scrollTime:true,
				scrollInput:false,
				step: parseInt(dhvcformL10n.time_picker_step)
			});
		}
		
		$.extend($.validator.messages, {
			required: dhvcformL10n.validate_messages.required,
			remote: dhvcformL10n.validate_messages.remote,
			email: dhvcformL10n.validate_messages.email,
			url: dhvcformL10n.validate_messages.url,
			date: dhvcformL10n.validate_messages.date,
			dateISO: dhvcformL10n.validate_messages.dateISO,
			number: dhvcformL10n.validate_messages.number,
			digits: dhvcformL10n.validate_messages.digits,
			creditcard: dhvcformL10n.validate_messages.creditcard,
			equalTo: dhvcformL10n.validate_messages.equalTo,
			maxlength: $.validator.format(dhvcformL10n.validate_messages.maxlength),
			minlength: $.validator.format(dhvcformL10n.validate_messages.minlength),
			rangelength: $.validator.format(dhvcformL10n.validate_messages.rangelength),
			range: $.validator.format(dhvcformL10n.validate_messages.range),
			max: $.validator.format(dhvcformL10n.validate_messages.max),
			min: $.validator.format(dhvcformL10n.validate_messages.min)
		});
		$.validator.addMethod("alpha", function(value, element, param) {
			return this.optional(element) || /^[a-zA-Z]+$/.test(value);
		},dhvcformL10n.validate_messages.alpha);
		
		$.validator.addMethod("alphanum", function(value, element, param) {
			return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
		},dhvcformL10n.validate_messages.alphanum);
		
		$.validator.addMethod("url", function(value, element, param) {
			value = (value || '').replace(/^\s+/, '').replace(/\s+$/, '');
             return this.optional(element) || /^(http|https|ftp):\/\/(([A-Z0-9]([A-Z0-9_-]*[A-Z0-9]|))(\.[A-Z0-9]([A-Z0-9_-]*[A-Z0-9]|))*)(:(\d+))?(\/[A-Z0-9~](([A-Z0-9_~-]|\.)*[A-Z0-9~]|))*\/?(.*)?$/i.test(value);
             
		},dhvcformL10n.validate_messages.url);
		$.validator.addMethod("zip", function(value, element, param) {
			return this.optional(element) || /(^\d{5}$)|(^\d{5}-\d{4}$)/.test(value);	
		},dhvcformL10n.validate_messages.zip);
		
		$.validator.addMethod("fax", function(value, element, param) {
			return this.optional(element) || /^(\()?\d{3}(\))?(-|\s)?\d{3}(-|\s)\d{4}$/.test(value);
		},dhvcformL10n.validate_messages.fax);
		
		$.validator.addMethod("cpassword", function(value, element, param) {
			var pass = $(element).data('validate-cpassword');
			return this.optional(element) || value === $(element).closest('form').find('#dhvc_form_control_'+pass).val();
		},dhvcformL10n.validate_messages.cpassword);
		
		$.validator.addMethod("extension", function(value, element, param) {
			param = typeof param === "string" ? param.replace(/,/g, "|") : "png|jpe?g|gif";
			return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
		}, dhvcformL10n.validate_messages.extension);
		
		$.validator.addMethod("recaptcha",function(value, element, param) {
			var isCaptchaValid = false;
			$.ajax({
			    url: dhvcformL10n.ajax_url,
			    type: "POST",
			    async: false,
			    data:{
			      action: 'dhvc_form_recaptcha',
			      recaptcha_challenge_field: Recaptcha.get_challenge(),
			      recaptcha_response_field: Recaptcha.get_response()
			    },success:function(resp){
			    	if(resp > 0){
			    		isCaptchaValid = true;
			    	}else{
			    		Recaptcha.reload();
			    	}
			    }
			});
			return isCaptchaValid;
		},dhvcformL10n.validate_messages.recaptcha);
		
		$.validator.addMethod("dhvcformcaptcha",function(value, element, param) {
			var isCaptchaValid = false;
			$.ajax({
			    url: dhvcformL10n.ajax_url,
			    type: "POST",
			    async: false,
			    data:{
			      action: 'dhvc_form_captcha',
			      answer: $(element).val(),
			    },success:function(resp){
			    	if(resp > 0){
			    		isCaptchaValid = true;
			    	}else{
			    		$(element).parent().find('img').get(0).src = dhvcformL10n.plugin_url + '/captcha.php?t='+Math.random();
			    	}
			    }
			});
			return isCaptchaValid;
		},dhvcformL10n.validate_messages.captcha);
		
		$.validator.addClassRules({
			'dhvc-form-required-entry':{
				required : true
			},
			'dhvc-form-validate-email':{
				email: true
			},
			'dhvc-form-validate-date':{
				date: true
			},
			'dhvc-form-validate-number':{
				number: true
			},
			'dhvc-form-validate-digits':{
				digits: true
			},
			'dhvc-form-validate-alpha':{
				alpha: true
			},
			'dhvc-form-validate-alphanum':{
				alphanum: true
			},
			'dhvc-form-validate-url':{
				url: true
			},
			'dhvc-form-validate-zip':{
				zip: true
			},
			'dhvc-form-validate-fax':{
				fax: true
			},
			'dhvc-form-validate-password':{
				required: true,
                minlength: 6
			},
			'dhvc-form-validate-cpassword':{
				required: true,
                minlength: 6,
                cpassword: true
			},
			'dhvc-form-validate-captcha':{
				required: true,
                dhvcformcaptcha: true
			},
			'dhvc-form-control-file':{
				extension:dhvcformL10n.allowed_file_extension
			}
		});
		
		$("form.dhvcform").each(function(){
			$(this).find('.dhvc-form-file').find('input[type=file]').bind('change',function(){
				$(this).closest('label').find('.dhvc-form-control').prop('value',$(this).val());
			});
			$(this).find('.dhvc-form-rate .dhvc-form-rate-star').tooltip({ html: true,container:$('body')});
			$(this).validate({
				onkeyup: false,
				onfocusout: false,
				onclick: false,
				errorClass: "dhvc-form-error",
				validClass: "dhvc-form-valid",
				errorElement: "span",
				errorPlacement: function(error, element) {
					if ( element.is( ':radio' ) || element.is( ':checkbox' ) )
						error.appendTo( element.parent().parent() );
					else if($(element).attr('id')=='recaptcha_response_field')
						error.appendTo($(element).closest('.dhvc-form-group-recaptcha') );
					else
						error.appendTo( element.parent().parent());
				},
				rules:{
					recaptcha_response_field:{
						required: true,
						recaptcha: true
					}
				},
				submitHandler: function(form){
					var user_ajax = $(form).data('use-ajax');
					var msg_container = $(form).closest('.dhvc-form-container').find('.dhvc-form-message');
					var recaptcha2_valid = true;
					var submit = $('.dhvc-form-submit');
					var dhvc_button_label = $(form).find('.dhvc-form-submit-label');
					var dhvc_ajax_spinner = $(form).find('.dhvc-form-submit-spinner');
					if($(form).find('.dhvc-form-recaptcha2').length){
						$.ajax({
						    url: dhvcformL10n.ajax_url,
						    type: "POST",
						    async: false,
						    data:{
						      action			 : 'dhvc_form_recaptcha2',
						      recaptcha2_response: grecaptcha.getResponse()
						    },
						    beforeSend: function(){
					        	submit.attr('disabled','disabled');
					        	dhvc_button_label.addClass('dhvc-form-submit-label-hidden');
					        	dhvc_ajax_spinner.show();
					        	msg_container.empty().fadeOut();
					        },
						    success:function(resp){
						    	submit.removeAttr('disabled');
					        	dhvc_button_label.removeClass('dhvc-form-submit-label-hidden');
					        	dhvc_ajax_spinner.hide();
						    	if(resp.success == false){
						    		recaptcha2_valid = false;
						    		$(resp.message).appendTo($(form).find('.dhvc-form-recaptcha2') );
						    	}
						    	
						    }
						});
					}
					if(user_ajax && recaptcha2_valid){
						 $.ajax({
					        url: dhvcformL10n.ajax_url,
					        type: "POST",
					        data: $(form).serialize(),
					        dataType: 'json',
					        beforeSend: function(){
					        	submit.attr('disabled','disabled');
					        	dhvc_button_label.addClass('dhvc-form-submit-label-hidden');
					        	dhvc_ajax_spinner.show();
					        	msg_container.empty().fadeOut();
					        },
					        success: function(resp) {
					        	submit.removeAttr('disabled');
					        	dhvc_button_label.removeClass('dhvc-form-submit-label-hidden');
					        	dhvc_ajax_spinner.hide();
					           if(resp.success){
					        	   if(resp.scripts_on_sent_ok){
					        		   $.each(resp.scripts_on_sent_ok, function(i, n) { eval(n) });
					        	   }
					        	   if(resp.on_success == 'message'){
					        		   msg_container.html(resp.message).fadeIn();
									   $(form).resetForm();
									   $(form).find('.dhvc-form-captcha').each(function(){
										   $(this).find('img').get(0).src = dhvcformL10n.plugin_url + '/captcha.php?t='+Math.random();
									   });
					        		   $('input[type="text"], textarea', $(form)).blur();
					        		   
					        		   if(!$(form).data('popup')){
						        		   $.smoothScroll({
												scrollTarget: msg_container,
												offset: -100,
												speed: 500
										  });
					        		   }
					        		   
					        	   }else{
					        		   window.location = resp.redirect_url;
					        	   }
					           }else{
					           		msg_container.html(resp.message).fadeIn();
								   $(form).resetForm();
				        		   $('input[type="text"], textarea', $(form)).blur();
				        		   
				        		   if(!$(form).data('popup')){
					        		   $.smoothScroll({
											scrollTarget: msg_container,
											offset: -100,
											speed: 500
									  });
				        		   }
					           }
					        }            
				         });
						return false;
					}
					if(recaptcha2_valid){
						form.submit();
					}
					return false;
				}
			}); 
		});
	});
	
}(window.jQuery);