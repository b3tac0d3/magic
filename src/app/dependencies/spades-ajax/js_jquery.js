// Streamlined PHP AJAX Development Engine System

/**************************************************************************************
	Ajax anything with a href
**************************************************************************************/
$(document).ready(function(){
	/* ajax request standard functions 
		Optional attributes:
			loadtype[html]: prepend, append, html(*complete page load*)
			excon[error]: container to be affected by ajax
			loader[progress1]: alternate load image other than the standard 
				
	*/
	$(document).on('click', '.spadeMe', function(e){
		e.preventDefault();
		
		var el = $(this); //a, li, etc
		var excon = $(el.attr('excon'));
		var href = el.attr('href');
		var sdata = el.attr('rel');
		var conf = el.attr('confirm');
		var callMe = el.attr('callback');
		var par = el.attr('par');
		
		if(conf) if(confirm(conf) != true) return false;
		
		$.ajax({
			type: "GET",
			url: href,
			data: sdata,
			dataType: 'JSON',
			success: function(ret){
				ajaxSuccess(el, excon, ret);
				if ($("#colorbox").css("display")=="block") $.colorbox.resize();
			},
			error: function(ret){
				console.log("%c xComm Error! There was an error processing this data!! The script returned the following text:", 'background: #222; color: #bada55');
				console.log("%c %s", "color: #FF0000", ret.responseText);
				return;
			}
		});
	});
});

/*************************************************************************************
	Ajax any form 
*************************************************************************************/
$(document).ready(function(){
	$(document).on('submit', '.spadeForm', function ajaxFrm(e){
		e.preventDefault();
	
		var el = $(this);
		var enc = el.attr('enctype');
		var href = el.attr('action');
		var sdata = el.serialize();
		var rel = el.attr('rel');
		var method = el.attr('method');
			if(!method) method = 'POST';
		var excon = el.attr('excon');
		var cururl = location.href;
		
		el.find('button').prop('disabled', true);
		el.find('.form_message').html("Please wait...");
		
		// ajax forms with image data
		if(enc == 'multipart/form-data'){
			var formData = new FormData();
			var inpName;
			
			$.each($("input[type=file]"), function(i) {
				var th = $(this);
				inpName = th.attr('name');
				$.each(th[0].files, function (i, file){
					formData.append(inpName+'['+i+']', file);
				});
			});
			
			$.each($("input[type!=file]"), function() {
				formData.append($(this).attr('name'), $(this).val());
			});

			$.ajax({
				url: href,
				type: 'POST',
				data: formData,
				dataType: 'JSON',
				contentType: false,
				processData: false,
				success: function (ret) {
					ajaxSuccess(el, excon, ret);
					if ($("#colorbox").css("display")=="block") $.colorbox.resize();
				}
			});
		// ajax every other form with more simple parameters
		}else{
			$.ajax({
				type: method,
				url: href,
				data: sdata+"&curlocation="+cururl,
				dataType: 'JSON',
				success: function(ret){
					ajaxSuccess(el, excon, ret);
					if ($("#colorbox").css("display")=="block") $.colorbox.resize();
				},
				error: function(ret){
					console.log("%c b3tac0d3 xComm plugin Error report! There was an error processing this data!! The script returned the following text:", 'background: #222; color: #bada55');
					console.log("%c %s", "color: #FF0000", ret.responseText);
                    console.log(ret);
					//console.log(JSON.stringify(error));
					return;
				}
			});//$.ajax
		}
	}); //spadeForm
});//$(doc).ready

function ajaxSuccess(el, excon, ret){
	// if the page is going to change other than refresh, the php forces the change
	
	// refresh the page
	if(ret.refresh == 1){
		location.reload();
		el.find('button').prop('disabled', false);
		return false;
	}
	
	// open a colorbox (can be a subsquent colorbox called from a colorbox as well)
	if(ret.redirCb == 1){
		cbOpen(ret.redirCbLink);
		return false;
	}
	
	// redirect if the script calls for it
	if(ret.redirOn == 1){
		window.location = ret.redirect;
		return false;
	}
	
	// if there's an external (or internal) container and the status isn't set to throw a message
	if(excon && ret.status != 0){
		$(excon).html(ret.html);
		el.find('button').prop('disabled', false);
		return false;
	}
	
	// if there's an alert to pop up
	if(ret.alertOn == 1){
		alert(ret.alertTxt);
		return false;
	}
	
	// show bad inputs
	if(ret.badInputs){
		y = JSON.stringify(ret.badInputs);
		y = JSON.parse(y);
		for (var i = 0, len = y.length; i < len; i++){
			$(y[i]).addClass('error');
		}
	}
	
	// if we make it here (and there's no excon), the message needs to be displayed
	el.find('.form_message')
		.addClass(ret.classes)
		.html(ret.message);
		el.find('button').prop('disabled', false);
		// scroll to top of form 
		$('body').scrollTop(el.offset().top);
}