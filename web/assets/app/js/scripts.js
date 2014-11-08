var Sale = {
	fieldPrefix: 'kermesse_kermessebundle_sales_salesLines_',

	changeCount: function (o, val) {
		var container = $(o.parentNode);

		var countInput = container.find("[id^='kermesse_kermessebundle_sales_salesLines_'][id$='_count']");;

		var count = parseInt(countInput.val());

		if ((val < 0 && count > 0) || val > 0) {
			countInput.val(count + val);

			countInput.trigger('change');
		}
	},

	minus: function (o) {
		var me = Sale;

		me.changeCount(o, -1);
	},

	plus: function (o) {
		var me = Sale;

		me.changeCount(o, 1);
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

	$("[name='kermesse_kermessebundle_sales']").on ('submit', function (event) {
		var total = parseFloat($('#kermesse_kermessebundle_sales_priceTotal').val());
		if (total > 0.0) {
			$("kermesse_kermessebundle_sales_submit").html('Wait...');
			$("kermesse_kermessebundle_sales_submit").disabled(true);
		} else {
			event.preventDefault();
		}
	})
});