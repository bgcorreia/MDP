$('#formUpload').submit(function(e){
	e.preventDefault();
	var formData = new FormData(this);
	for (var pair of formData.entries()) {
		console.log(pair[0] + " = " + pair[1]);
	}
	$.ajax({
		url : "./assets/scripts/upload.php",
		type: "POST",
		processData: false,
		contentType: false,
		data: formData,
		success: function(data){
			console.info(data);
			if (data.error) {
				console.info(data.error);
				if ( $("#phenotypicData").val() ) {
					$("#param").append("<option>Select</option>");
				}
				if ( $("#pathwaysGMT").val() ) {
					$("#param2").append("<option>Select</option>");
				}
				console.log( data );
			} else if (data.classes) {
				console.log( data );
				if ( $("#phenotypicData").val() ) {
					$("#param").html("");
					$.each(data.classes, function() {
						$("#param").append("<option>"+this+"</option>");
					});
				}
				if ( $("#pathwaysGMT").val() ) {
					$("#param2").html("");
					$.each(data.classes, function() {
						$("#param2").append("<option>"+this+"</option>");
					});
				}
			}
		},
		error: function(data) {
			$("body").html(data.responseText);
		}	
	});
});

$('#formData').submit(function(e){
	e.preventDefault();
	var formIngo = new FormData(this);
	for (var pair of formIngo.entries()) {
		console.log(pair[0] + " = " + pair[1]);
	}
	$.ajax({
		url : "./assets/scripts/plot.php",
		type: "POST",
		processData: false,
		contentType: false,
		data: formIngo,
		success: function(data){
			console.info(data);
		}
	});
});

pendingUpload = [];

$('input[type=file]').change(function(){
	var a = $(this),
		b = a.val(),
		c = b.substr(b.lastIndexOf('\\') + 1),
		d = a.attr("name");
	a.next().next().html(c);
	if (typeof(pendingUpload[d]) == "undefined") {
		pendingUpload.push(d);
	}
	console.log(pendingUpload.length);
});