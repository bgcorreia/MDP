$(document).ready(function(){
	$('.alert-danger').hide();
	$("#loading").hide();
	$("#creatPlot").hide();
	$("#creatPlot").click(function(){
		$("#loading").fadeIn(1000);
	});
});

$(document).on('input', '#stan', function() {
	$('#stanVal').html( $(this).val() );
});

$(document).on('input', '#pertubed', function() {
	$('#pertubedVal').html( $(this).val() );
});

var Upload = {
	one: 0,
	two: 0,
	three: 0,
	num: 0,
	lod1: 0,
	lod2: 0,
	lod3: 0,
	showButton: 0,
	All: function(num){
		var url_atual = window.location.href;
		var url_site = "http://mdp.sysbio.tools/"
		var formData = new FormData($('#formUpload')[0]),
		num = Upload.num,
		inputFile = $('[data-prog="'+num+'"]'),
		progressBar = $('[data-prog="'+num+'"] .progress-bar');
		if(Upload.one == 0 && num == 1 || Upload.two == 0 && num == 2 || Upload.three == 0 && num == 3){
			$.ajax({
				type: 'POST',
				url: '/assets/scripts/upload.php',
				processData: false,
				contentType: false,
				data: formData,
				xhr: function(){
					xhr = new window.XMLHttpRequest();

					if(num == 1){
						xhr.upload.addEventListener("progress", function(evt1){
							if(evt1.lengthComputable){
								var percentComplete1 = evt1.loaded / evt1.total;

								progressBar.animate({'width': (percentComplete1 * 100)+'%'});

								console.log(Math.round(percentComplete1 * 100));
								console.log('EXPRESSION SIZE: ' + (evt1.total));
								console.log('EXPRESSION PERCENT: ' + (percentComplete1 * 100));
								console.log('EXPRESSION LOADED: ' + (evt1.loaded));


								if(percentComplete1 >= 1){
									evt1.total = 0;
									evt1.loaded = 0;
									console.log(evt1.total);
									console.log(evt1.loaded);
									console.log(xhr.responseText);
								}
							}

		
						}, true);

						return xhr;

					}else if(num == 2){
						xhr.upload.addEventListener("progress", function(evt2){
							if(evt2.lengthComputable){
								var percentComplete2 = evt2.loaded/evt2.total;

								progressBar.animate({'width': (percentComplete2 * 100)+'%'});

								console.log(Math.round(percentComplete2 * 100));
								console.log('Size Expression: ' + (evt2.total));
								console.log('phenotypicData: ' + (percentComplete2 * 100));
								console.log('phenotypicData LOADED: ' + (evt2.loaded));
							}
						}, false); 

						return xhr;

					}else if(num == 3){
						xhr.upload.addEventListener("progress", function(evt3){
							if(evt3.lengthComputable){
								var attach_id = "pathwaysGMT";
								var size = $('#'+attach_id)[0].files[0].size;
								Upload.lod3 = evt3.loaded - $('#expressionData')[0].files[0].size;
								var percentComplete3 = Math.abs(Upload.lod3 / size);
								if(percentComplete3> 5000){
									percentComplete3= 0;
								}

								progressBar.animate({'width': (percentComplete3 * 100)+'%'});

								console.log(Math.round(percentComplete3 * 100));
								console.log('Size Expression: ' + (size));
								console.log('GMT: ' + (percentComplete3 * 100));
								console.log('GMT LOADED: ' + (Math.abs(Upload.lod3)));
								console.log('GMT TOTAL: ' + (evt3.total));
							}
						}, false);

						return xhr;
					}
				},
				beforeSend: function(){
					inputFile.fadeIn(0);
					progressBar.addClass('progress-bar-animated');
				},
				complete: function(){
					progressBar.addClass('bg-success');
					progressBar.html("Upload Complete");
					progressBar.removeClass('progress-bar-animated');
				},
				error: function(data){
					console.log(data);
				},
				success: function(data){
					progressBar.addClass('bg-success');
					progressBar.html("Upload Complete");
					progressBar.removeClass('progress-bar-animated');
					if(num == 1){
						Upload.showButton =Upload. showButton + 1;
					}
					if(num == 2){
						if (data.error) {
							$('.alert-danger').html("<i class='fas fa-exclamation-circle'></i> "+data.error);
							$('.alert-danger').fadeIn(200);
							if ( $("#phenotypicData").val() ) {
								$("#param").append("<option>Select</option>");
							}

						} else if (data.classes1) {
							$('.alert-danger').fadeOut(200);
							if ( $("#phenotypicData").val() ) {
								$("#param").html("");
								Upload.showButton = Upload.showButton + 1;
								$.each(data.classes1, function() {
									$("#param").append("<option>"+this+"</option>");
								});
							}
						}
						if(url_atual == url_site  && Upload.showButton == 2){
							$("#creatPlot").fadeIn(500);
						}
					} else if(num == 3){
						if (data.error) {
							$('.alert-danger').html("<i class='fas fa-exclamation-circle'></i> "+data.error);
							$('.alert-danger').fadeIn(200);
							if ( $("#pathwaysGMT").val() ) {
								$("#param2").append("<option>Select</option>");
							}
						} else if(data.classes2) {
							$('.alert-danger').fadeOut(200);
							if ($("#pathwaysGMT").val()) {
								$("#param2").html("");

								$.each(data.classes2, function() {
									$("#param2").append("<option>"+this+"</option>");
								});
								Upload.showButton = Upload.showButton + 1;
							}
						}
						if(url_atual == url_site+"pages/pathways" && Upload.showButton == 3){
							$("#creatPlot").fadeIn(500);
						}
					}
				}
			});
		}
	}
}
$('#formUpload').submit(function(){
	Upload.All();
	return false;
});

$('input[type=file]').change(function(){
	var a = $(this),
		b = a.val(),
		c = b.substr(b.lastIndexOf('\\') + 1),
		d = a.attr('data-id');
	a.next().next().html(c);
	Upload.num = d;
	$('#formUpload').submit();
});
