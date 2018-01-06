<?php require_once(getenv("PROJECT_ROOT") . "/views/partials/header.php"); ?>

<section class="hero">
<div class="hero-body">
	<div class="container">
		<p class="title">
			Add list <i class="fa fa-plus"></i>
		</p>
		<p class="subtitle">
			Enter the name of your list you want to add. Duplicates are allowed.
		</p>
	</div>
</div>
</section>

<hr>

<section class="section">
    <div class="container">
		<form action="/home/list/add" method="POST">
			<div class="field has-addons">
				<div class="control is-expanded">
					<input class="input is-info is-large" type="text" name="title" placeholder="Title of the list">
				</div>
				<div class="control">
					<button type="submit" class="button is-info is-large">
						<i class="fa fa-plus"></i>
					</button>
				</div>
			</div>
		</form>
	</div>
</section>

<?php require_once(getenv("PROJECT_ROOT") . "/views/partials/footer.php"); ?>