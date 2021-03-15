<h2 class="text-center">{type_description}</h2>
<div class="container container-background">
	<div style="display:flex;">
		<div>
			<img src="{thumbnail}">
		</div>
		<div class="book-container">
			<h3 class="text-center">{title}</h3>
			{authors}
				<h4 class="text-center">Author: {author}</h4>
			{/authors}
			<p class="text-center">{description}</p>
			<div style="display:flex;">
				<button type="button" class="btn btn-info button-alignment" style="margin-right:15px;" onclick="submit_review(1)">Yes</button>
				<button type="button" class="btn btn-secondary" onclick="submit_review(0)">No</button>
			</div>
		</div>
	</div>
	<input id="item_id" type="hidden" value="{id}"/>
</div>
<div style="margin-top:15px;">
	<div id="success_handler" class="d-none response-handler book-container">
		<div class="alert alert-success text-center">Thank you for reviewing.</div>
		<a href="{base_url}items/load" class="btn btn-primary">Rate another item</a>
	</div>
	<div id="error_handler" class="d-none response_handler text-center">
		<div class="alert alert-danger">There was an error submitting the review.</div>
	</div>
</div>
<input id="base_url" type="hidden" value="{base_url}">