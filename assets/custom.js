$(document).ready(function () {


	$("#titleP").autocomplete({
		source: "getproducts",

		select: function (event, ui) {


			//validação estoque
			if (ui.item.estoque >= 1) {
				stock = ui.item.estoque;
			} else {
				stock = ui.item.estoque;
				alert("O produto não consta em estoque");
			}

			data =
				ui.item.id +
				"*" +
				ui.item.codigo +
				"*" +
				ui.item.label +
				"*" +
				ui.item.tamanho +
				"*" +
				stock +
				"*" +
				ui.item.cor +
				"*" +
				ui.item.preco +
				"*" +
				ui.item.precoCusto;
			$('[name="titleP"]').val(data);
			console.log(data);
			$("#btn-agregar").val(data);
		}
	});
});

$("#btn-agregar").on("click", function () {
	data = $(this).val();
	if (data != "") {
		infoproducto = data.split("*");
		html = "<tr>";
		html += "<td>" + infoproducto[1] + "</td>"; //cod
		html += "<td>" + infoproducto[2] + "</td>"; //titulo
		html += "<td>" + infoproducto[3] + "</td>"; //tamanho
		html +=
			"<td><input type='number' min='0' name='quantity[]' value='1' class='quantity form-class'></td>";
		html += "<td>" + infoproducto[5] + "</td>"; //tamanho
		html +=
			"<td><input type='hidden' name='priceproduct[]' value='" +
			infoproducto[6] +
			"'>" +
			infoproducto[6] +
			"</td>";
		html +=
			"<td><input type='hidden' readonly='readonly' name='totalprice[]' value='" +
			infoproducto[6] +
			"'> <p>" +
			infoproducto[6] +
			"</p></td>";
		html +=
			"<td><input type='hidden' name='pricecost[]' value='" +
			infoproducto[7] +
			"'>" +
			infoproducto[7] +
			"</td>";
		html +=
			"<td><input type='hidden' readonly='readonly' name='cost[]' value='" +
			infoproducto[7] +
			"'> <p>" +
			infoproducto[7] +
			"</p></td>";
		html +=
			"<td><input type='hidden' name='stock[]' value='" +
			infoproducto[4] +
			"'></td>";
		html +=
			"<td><input type='hidden' name='idproduct[]' value='" +
			infoproducto[0] +
			"'></td>";
		html +=
			"<td><button type='button' class='btn btn-danger btn-remove-producto'><span class='fa fa-remove'></span></button></td>";
		html += "</tr>";
		$("#tbventas tbody").append(html);
		sumar();
		$("#btn-agregar").val(null);
		$("#product").val(null);
	} else {
		alertify.error("Selecione um produto");
	}
});

$(document).on("click", ".btn-remove-producto", function () {
	$(this)
		.closest("tr")
		.remove();
	sumar();
});

$(document).on("keyup mouseup", "#tbventas input.quantity", function () {
	quantity = Number($(this).val());
	priceproduct = Number(
		$(this)
		.closest("tr")
		.find("td:eq(5)")
		.text()
	);
	totalprice = quantity * priceproduct;
	$(this)
		.closest("tr")
		.find("td:eq(6)")
		.children("p")
		.text(totalprice.toFixed(2));
	sumar();

	pricecost = Number(
		$(this)
		.closest("tr")
		.find("td:eq(7)")
		.text()
	);
	console.log("preço" + pricecost);
	cost = quantity * pricecost;
	$(this)
		.closest("tr")
		.find("td:eq(8)")
		.children("p")
		.text(cost.toFixed(2))
	sumar();
});

function myFunction() {
	sumar();
}

function sumar() {
	subtotal = 0;
	$("#tbventas tbody tr").each(function () {
		subtotal =
			subtotal +
			Number(
				$(this)
				.closest("tr")
				.find("td:eq(6)")
				.text()
			);
	});

	totalcost = 0;
	$("#tbventas tbody tr").each(function () {
		totalcost =
			totalcost +
			Number(
				$(this)
				.closest("tr")
				.find("td:eq(8)")
				.text()
			);
	});



	$("input[name=subtotal]").val(subtotal.toFixed(2));
	descuento = Number($("input[name=descuento]").val());
	console.log(descuento);
	total = subtotal - descuento;
	$("input[name=total]").val(total.toFixed(2));
	$("input[name=totalcost]").val(totalcost.toFixed(2));

	$(".subtotal").text(subtotal.toFixed(2));
	$(".descuento").text(descuento.toFixed(2));
	$(".total").text(total.toFixed(2));
	$(".totalcost").text(totalcost.toFixed(2));
}
