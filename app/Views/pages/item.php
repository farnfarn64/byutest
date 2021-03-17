<h2 class="text-center">{type_description}</h2>
<div class="container container-background">
	<div>
		<img src="{thumbnail}">
	</div>
	<div class="book-container">
		<h3 class="text-center">{title}</h3>
		{authors}
			<h4 class="text-center">Author: {author}</h4>
		{/authors}
		<h4 class="text-center">{type_lowercase}</h4>
		<p class="text-center">{description}</p>
		<div class="button-container">
			<button type="button" class="btn btn-info button-alignment" onclick="submit_review(1)">Yes</button>
			<button type="button" class="btn btn-secondary" onclick="submit_review(0)">No</button>
		</div>
	</div>
	<input id="item_id" type="hidden" value="{id}"/>
</div>
<div class="handler-container">
	<div id="success_handler" class="d-none response-handler book-container">
		<div class="alert alert-success text-center">Thank you for reviewing.</div>
		<a href="{base_url}items/load" class="btn btn-primary">Rate another item</a>
	</div>
	<div id="error_handler" class="d-none response_handler text-center">
		<div class="alert alert-danger">There was an error submitting the review.</div>
	</div>
</div>
<input id="base_url" type="hidden" value="{base_url}">