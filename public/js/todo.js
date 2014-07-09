$(document).ready(function(){
	function validateMail(mail) {
		var match = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		return match.test(mail);
	}
	
	$("#btnSendMail").on("click", function(e){
		e.preventDefault();
		if(!validateMail($("#tfMailRecover").val())) {
			$("#tfMailRecover").attr("value", "");
			$("#tfMailRecover").attr("placeholder","Ese no es un correo valido!");
			}
	});

	$(".btnUpdate").on("click", function(){
		var tarea = $(this).closest("tr").children("td#todoNom").text();
		var descr = $(this).closest("tr").children("td#todoDes").text();
		var fS = $(this).closest("tr").children("td#todoDS").text();
		var fE = $(this).closest("tr").children("td#todoDE").text();
		var idTodo = $(this).closest("tr").attr("id");
		$("#utdTarea").val(tarea);
		$("#uidDescr").val(descr);
		$("#uidtfDS").val(fS);
		$("#uidtfDE").val(fE);
		$("#idTodo").val(idTodo);
	});

	$(".btnUpTodo").on("click", function(){
		var idTodo = $("#idTodo").val();
		var tarea = $("#utdTarea").val();
		var descr = $("#uidDescr").val();
		var fs = $("#uidtfDS").val();
		var fe = $("#uidtfDE").val();

		$.ajax({
			type: "POST",
			url: "todo.php",
			data: {idTodo: idTodo, action: "update", tarea: tarea, descr: descr, fs:fs, fe:fe},
			success: function(info) {
				 location.reload();
			},
		 	error: function (jqXHR, estado, error){
		 		console.log(estado);
		 		console.log(error);
		 	},
		 	complete: function(jqXHR, estado){
		 		console.log(estado);
		 	},
		 	timeout: 10000
		});	
	});

	$(".btnHecho").on("click", function(){
		var stado = $(this).closest("td").prev("td").find("span");
		var idTodo = $(this).closest("tr").attr("id");
		$.ajax({
			beforeSend: function(){
				var spin = "<i class='uk-icon-spinner uk-icon-spin'></i>";
		 		$("#msg").append(spin + " Procesando");
			},
			type: "POST",
			url: "todo.php",
			data: {idTodo: idTodo, action: "done"},
			success: function(info) {
				$("#msg").html("");
				stado.html("<span id='estado' class='uk-text-bold uk-text-success'>Hecho</span>");
			}
		});	
	});

	$(".btnDelete").on("click", function(){
		 var idTodo = $(this).closest("tr").attr("id");
		 $.ajax({
		 	beforeSend: function(){
		 		var spin = "<i class='uk-icon-spinner uk-icon-spin'></i>";
		 		$("#msg").append(spin + " Procesando");
		 	},
		 	type : "POST",
		 	url : "todo.php",
		 	data : {idTodo: idTodo, action: "delete"},
		 	success: function (info){
		 		console.log(info);
		 		location.reload();
		 	},
		 	error: function (jqXHR, estado, error){
		 		console.log(estado);
		 		console.log(error);
		 	},
		 	complete: function(jqXHR, estado){
		 		console.log(estado);
		 	},
		 	timeout: 10000
		 });
	});

});