<?php require_once(getenv("PROJECT_ROOT") . "/views/partials/header.php"); ?>

<section class="hero">
<div class="hero-body">
	<div class="container">
		<p class="title">
			View and edit lists <i class="fa fa-edit"></i>
		</p>
		<p class="subtitle">
			See all your lists below. In order to edit the list, click on it. <br>
			If you want to add articles, click either on the article icon <i class="fa fa-shopping-cart"></i> in the list panel
			or click on the list and see there the "Add article" section.
		</p>
	</div>
</div>
</section>

<hr>

<section class="section">
    <div class="container">
		
		<div class="tile is-ancestor">
			
			<?php foreach ($lists as $list): ?>
					<article class="tile is-child message is-primary is-medium">
						<div class="message-header">
							<p><strong><?= e($list->getTitle()) ?></strong> | 
								<?php if ($list->getState() == \App\Model\Liste::STATE_LEFT_ARTICLES): ?>  
									<?= e($list->getUnfinishedArticles) ?> 
								<?php endif ?>
								<?= \App\Utils::listStateToDisplay(e($list->getState())) ?>
							</p>
						</div>
						<div class="message-body">
							<?php if ($list->getDescription() == null): ?>
								No description.
							<?php else: ?>
								<?= e($list->getDescription()) ?>
							<?php endif ?>
							<hr>
							<span class="icon">
								<a><i class="fa fa-shopping-cart"></i></a>
							</span>
							<span class="icon">
								<a><i class="fa fa-edit"></i></a>
							</span> 
							<span class="icon">
								<a><i class="fa fa-trash-o"></i></a>
							</span>
					</article>

				</div>
			<?php endforeach ?>
		
		</div>
		
	</div>
</section>

<?php require_once(getenv("PROJECT_ROOT") . "/views/partials/footer.php"); ?>