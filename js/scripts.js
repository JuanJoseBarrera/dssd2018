$(document).ready(function() {
	$("#nroClienteDiv").hide();
});

function showNroCliente() {
	if ($("#rol").val() == 2) {
		$("#nroClienteDiv").show();
	} else {
		$("#nroClienteDiv").hide();
	}
}

function addField() {
	var intId = $("#lista").length + 1;
	var parentDiv = $("<div class=\"col-lg-offset-4 parent\"></div>");
	var objectInput = "<div class=\"col-md-6\"><input class=\"form-control col-md-4\" type=\"text\" name=\"objeto[]\" id=\"contenido_" + intId + " \" value=\"Ingrese Objeto\"></div>";
	var removeButton = $("<div class=\"col-md-4\"><input type=\"button\" class=\"btn btn_default col-md-1\" value=\"-\" /></div>");
	removeButton.click(function() {
		$(this).parent().remove();
	});
	parentDiv.append(objectInput);
	parentDiv.append(removeButton);
	$("#lista").append(parentDiv);
};