var Sale = {
	fieldPrefix: 'kermesse_kermessebundle_sales_salesLines_',

	minus: function (row) {
		alert(row);
	},

	plus: function (row) {
		alert(row);
	},

	update: function () {

		var me = Sale;

		var total = 0.0;

		var countLines = $("[id^='kermesse_kermessebundle_sales_salesLines_'][id$='_count']").length;

		for (var i = 0; i < countLines; i++) {

			var punitId = me.fieldPrefix + i.toString() + '_priceUnit';
			var countId = me.fieldPrefix + i.toString() + '_count';
			var ptotalId = me.fieldPrefix + i.toString() + '_priceTotal';

			var punit = $("#" + punitId).val();
			var count = $("#" + countId).val();

			if (count >= 0) {
				$("#"+ptotalId).val(punit * count);
				total += (punit * count);
			} else {
				$("#" + countId).val(0);
			}
		}

		$('#kermesse_kermessebundle_sales_priceTotal').val(total);
	}
};

$( document ).ready(function () {
	$("[id^='kermesse_kermessebundle_sales_salesLines_'][id$='_count']").on( "change", {}, Sale.update );
});