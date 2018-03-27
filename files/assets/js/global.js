$(document).ready(function(){
	$('.alert-danger').hide();
	$("#loading").hide();
    $("#creatPlot").click(function(){
        $("#loading").fadeIn(1000);
    });
});

var Upload = {
	one: 0,
	two: 0,
	three: 0,
	num: 0,
	All: function(num){
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
				cache: false,
				xhr: function(){
		if(num == 1){
                        var xhr1 = new window.XMLHttpRequest();
                        xhr1.upload.addEventListener("progress", function(evt1){
                            if(evt1.lengthComputable){
                                var percentComplete1 = evt1.loaded / size;
                                progressBar.animate({'width': (percentComplete1 * 100)+'%'});
                                console.log(Math.round(percentComplete1 * 100));
				console.log('Size Expression: ' + (size));
				console.log('EXPRESSION: ' + (percentComplete1 * 100));
				console.log('EXPRESSION LOADED: ' + (evt1.loaded));
				console.log('EXPRESSION TOTAL: ' + (evt1.total));
                            }
                        }, false);

			/*
                        xhr1.addEventListener("progress", function(evt1){
                            if(evt1.lengthComputable){
                                var percentComplete1 = evt1.loaded / evt1.total;
                                progressBar.animate({'width': Math.round(percentComplete1 * 100)+'%'});
                                console.log(percentComplete1);
                            }
                        }, false);
			*/

                        return xhr1;

                    }else if(num == 2){
                        var xhr2 = new window.XMLHttpRequest();
                        xhr2.upload.addEventListener("progress", function(evt2){
                            if(evt2.lengthComputable){
                                var attach_id = "phenotypicData";
                                var size = $('#'+attach_id)[0].files[0].size;
                                var percentComplete2 = evt2.loaded / size;
                                progressBar.animate({'width': (percentComplete2 * 100)+'%'});
                                console.log(Math.round(percentComplete2 * 100));
                                console.log('Size Phenotypic: ' + (size));
				console.log('PHENOTYPIC: ' + (percentComplete2 * 100));
                                console.log('PHENOTYPIC LOADED: ' + (evt2.loaded));
                                console.log('PHENOTYPIC TOTAL: ' + (evt2.total));
                            }
                        }, false);
			/*
                        xhr2.addEventListener("progress", function(evt2){
                            if(evt2.lengthComputable){
                                var percentComplete2 = evt2.loaded / evt2.total;
                                progressBar.animate({'width': Math.round(percentComplete2 * 100)+'%'});
                                console.log(percentComplete2);
                            }
                        }, false);
			*/

                        return xhr2;

                    }else if(num == 3){
                        var xhr3 = new window.XMLHttpRequest();
                        xhr3.upload.addEventListener("progress", function(evt3){
                            if(evt3.lengthComputable){
                                var percentComplete3 = evt3.loaded / evt3.total;
                                progressBar.animate({'width': (percentComplete3 * 100)+'%'});
                                console.log(Math.round(percentComplete3 * 100));
				console.log('GMT: ' + (percentComplete3 * 100));
                                console.log('GMT LOADED: ' + (evt3.loaded));
                                console.log('GMT TOTAL: ' + (evt3.total));
                            }
                        }, false);
			/*
                        xhr3.addEventListener("progress", function(evt3){
                            if(evt3.lengthComputable){
                                var percentComplete3 = evt3.loaded / evt3.total;
                                progressBar.animate({'width': Math.round(percentComplete3 * 100)+'%'});
                                console.log(percentComplete3);
                            }
                        }, false);
			*/

                        return xhr3;
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
								$.each(data.classes1, function() {
									$("#param").append("<option>"+this+"</option>");
								});
							}
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
							}
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
