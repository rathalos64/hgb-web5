<?php require_once("../partials/header.php"); ?>

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
<!-- 
<div class="card">
<img src="/assets/images/404.png" alt="Placeholder image" width="400" height="400">
  <div class="card-content">
    <div class="media">
      <div class="media-content">
        <p class="title is-4">John Smith</p>
        <p class="subtitle is-6">@johnsmith</p>
      </div>
    </div>

    <div class="content">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit.
      Phasellus nec iaculis mauris. <a>@bulmaio</a>.
      <a href="#">#css</a> <a href="#">#responsive</a>
      <br>
      <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
    </div>
  </div>
</div> -->

<?php require_once("../partials/footer.php");