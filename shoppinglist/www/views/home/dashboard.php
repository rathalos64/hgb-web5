<?php require_once(getenv("PROJECT_ROOT") . "/views/partials/header.php"); ?>

<section class="hero">
<div class="hero-body">
	<div class="container">
		<p class="title">
			Welcome <?= e($user->getUsername()) ?> <i class="fa fa-hand-spock-o"></i>
		</p>
		<p class="subtitle">
			View your actions below
		</p>
	</div>
</div>
</section>

<hr>

<section class="section">
    <div class="container">
		
		<div class="tile is-ancestor">
		  
			<div class="tile is-parent is-1"></div>

			<a class="tile is-parent" href="/home/list/add">
				<article class="tile is-child box has-text-centered">
					<h2 class="subtitle">Add list</h2>
					<div class="content">
						<i class="fa fa-plus fa-2x"></i>
					</div>	
				</article>
			</a>

			<div class="tile is-parent is-1"></div>

			<a class="tile is-parent" href="/home/list">
				<article class="tile is-child box has-text-centered">
					<h2 class="subtitle">View and edit lists</h2>
					<div class="content">
						<i class="fa fa-edit fa-2x"></i>
					</div>	
				</article>
			</a>

			<div class="tile is-parent is-1"></div>

			<a class="tile is-parent" href="/home/audit">
				<article class="tile is-child box has-text-centered">
					<h2 class="subtitle">View audit log</h2>
					<div class="content">
						<i class="fa fa-comment-o fa-2x"></i>
					</div>	
				</article>
			</a>

			<div class="tile is-parent is-1"></div>

		</div>

	</div>
</section>

<?php require_once(getenv("PROJECT_ROOT") . "/views/partials/footer.php"); ?>