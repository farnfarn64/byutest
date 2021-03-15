function submit_review(rating) {
	$(".response-handler").addClass("d-none");

	var item_id = $("#item_id").val();

	var request = {
		item_id: item_id,
		rating: rating
	};

	var url = $("#base_url").val() + "items/rate";

	$.ajax({
		url: url,
		data: request,
		method: "POST"
	}).done(function(data) {
		if (data === "success") {
			$("#success_handler").removeClass("d-none");
		} else {
			$("#error_handler").removeClass("d-none");
		}
	});
}