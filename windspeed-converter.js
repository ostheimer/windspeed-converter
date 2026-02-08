// Windspeed Converter - Main conversion script
;jQuery.noConflict();
jQuery(document).ready(function($) {
	$('.input_field').keyup(function() {
		input = $(this).val();
		last = input.substr(input.length-1,1);
		if(last != '.') {
			if($(this).attr('name') == 'kmh') {
				if (input.indexOf(",") >= 0) {
					$('.message').text(wsconv_messages.usecomma);
				} else {
					mph = input * 0.621371192;
					beaufort = get_beaufort('kmh',input);
					ms = input*0.277777778;
					knots = input*0.539956803;
					
					$('input[name|="mph"]').val(parseFloat(mph).toFixed(2));
					$('input[name|="beaufort"]').val(beaufort);
					$('input[name|="ms"]').val(parseFloat(ms).toFixed(2));
					$('input[name|="knots"]').val(parseFloat(knots).toFixed(2));
					$('.message').text('');
				}
			}
			
			if($(this).attr('name') == 'mph') {
				if (input.indexOf(",") >= 0) {
					$('.message').text(wsconv_messages.usecomma);
				} else {
					kmh = input*1.609344
					beaufort = get_beaufort('mph',input);
					ms = input*0.44704;
					knots = input*0.868976242;
					
					$('input[name|="kmh"]').val(parseFloat(kmh).toFixed(2));
					$('input[name|="beaufort"]').val(beaufort);
					$('input[name|="ms"]').val(parseFloat(ms).toFixed(2));
					$('input[name|="knots"]').val(parseFloat(knots).toFixed(2));
					$('.message').text('');
				}
			}
			
			if($(this).attr('name') == 'beaufort') {
				convert_beaufort(input);
				if ((input.indexOf(".") >= 0) || (input.indexOf(",") >= 0)) {
					$('input[name|="kmh"]').val('-');
					$('input[name|="mph"]').val('-');
					$('input[name|="ms"]').val('-');
					$('input[name|="knots"]').val('-');
					$('.message').text(wsconv_messages.mustinteger);
				} else {
					if(input > 12 || input < 0) {
						$('input[name|="kmh"]').val('-');
						$('input[name|="mph"]').val('-');
						$('input[name|="ms"]').val('-');
						$('input[name|="knots"]').val('-');
						$('.message').text(wsconv_messages.numberbetween);
					} else {
						$('input[name|="kmh"]').val(kmh);
						$('input[name|="mph"]').val(mph);
						$('input[name|="ms"]').val(ms);
						$('input[name|="knots"]').val(knots);
						$('.message').text('');
					}
				}
			}
			
			if($(this).attr('name') == 'ms') {
				if (input.indexOf(",") >= 0) {
					$('.message').text(wsconv_messages.usecomma);
				} else {
					kmh = input*3.6;
					mph = input * 2.23693629;
					beaufort = get_beaufort('ms',input);
					knots = input*1.94384449;
					
					$('input[name|="kmh"]').val(parseFloat(kmh).toFixed(2));
					$('input[name|="mph"]').val(parseFloat(mph).toFixed(2));
					$('input[name|="beaufort"]').val(beaufort);
					$('input[name|="knots"]').val(parseFloat(knots).toFixed(2));
					$('.message').text('');
				}
			}
			
			if($(this).attr('name') == 'knots') {
				if ((input.indexOf(".") >= 0) || (input.indexOf(",") >= 0)) {
					$('.message').text(wsconv_messages.mustinteger);
				} else {
					kmh = input/0.539956803;
					mph = input/0.868976242;
					beaufort = get_beaufort('knots',input);
					ms = input/1.94384449;
					
					$('input[name|="kmh"]').val(parseFloat(kmh).toFixed(2));
					$('input[name|="mph"]').val(parseFloat(mph).toFixed(2));
					$('input[name|="beaufort"]').val(beaufort);
					$('input[name|="ms"]').val(parseFloat(ms).toFixed(2));
					$('.message').text('');
				}
			}
		}
	});
});
