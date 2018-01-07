<?php require_once(getenv("PROJECT_ROOT") . "/views/partials/header.php"); ?>

<section class="hero">
<div class="hero-body">
	<div class="container">
		<p class="title">
			Add article <i class="fa fa-shopping-cart"></i>
		</p>
		<p class="subtitle">
			Enter the name of the article you want to add. Duplicates are allowed.
		</p>
	</div>
</div>
</section>

<hr>

<section class="section">
    <div class="container">
		<form action="/home/article/add" method="POST">
			<div class="field has-addons">
				<input type="hidden" name="listId" value="<?= e($listId) ?>"/>
				<div class="control is-expanded">
					<input class="input is-info is-large" type="text" name="title" placeholder="Title of the article">
				</div>
				<div class="control">
					<button type="submit" class="button is-info is-large">
						<i class="fa fa-plus"></i>
					</button>
				</div>
			</div>
			<div class="field">
				<div class="control is-expanded">
					<textarea class="textarea is-info is-large" type="text" name="description" placeholder="Description of the article"></textarea>
				</div>
			</div>
		</form>
	</div>
</section>

<?php require_once(getenv("PROJECT_ROOT") . "/views/partials/footer.php"); ?>