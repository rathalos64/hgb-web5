<?php require_once("C:/xampp/htdocs" . "/views/partials/header.php"); ?>

<section class="section">
    <div class="container has-text-centered">
		<img src="/assets/images/404.png" alt="Placeholder image" width="400" height="400">
	</div>
	<section class="hero has-text-centered">
		<div class="hero-body">
			<div class="container">
				<h1 class="title">
					Oh crap! Our intern fu***d up again. No, what we meant is,<br/>
					you found our easteregg site. Congratulations. You are the best!<br/> He he. 
				</h1>
			</div>
		</div>
		<hr />
		<p>
			For developers: the error is <strong><?= $message; ?></strong>
		</p>
	</section>
</section>

<?php require_once("C:/xampp/htdocs" . "/views/partials/footer.php"); ?>