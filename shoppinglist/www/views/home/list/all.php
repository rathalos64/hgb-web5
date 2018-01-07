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

		<?php if (count($lists) == 0): ?>
			<p class="content is-large">
				<span>No lists yet. <i class="fa fa-heartbeat"></i></span>
			</p>
		<?php endif ?>
		
		<?php for($i = 0; $i < $listRows; $i++): ?>
		<?php $row = array_splice($lists, 0, \App\Controller\ListController::COLUMNS); ?>
			
			<div class="tile is-ancestor">
				
				<?php $columns_filled = 0; ?>
				<?php foreach ($row as $list): ?>
					
					<div class="tile is-parent">
						<article class="tile is-child message is-primary is-medium">
							<div class="message-header">
								<?= e($list->getTitle()) ?>

								<?php if (e($list->getState() != \App\Model\Liste::STATE_NO_ARTICLES)): ?>
									| <?= e($list->getFinishedArticles()) ?>  / <?= e($list->getNumberOfArticles()) ?>
								<?php endif ?>

								<?php $color = \App\Utils::listStateToColor(e($list->getState())); ?>
								<span class="tag is-<?= $color ?> is-medium">
									<?= \App\Utils::listStateToDisplayShort(e($list->getState())) ?>
								</span>
							</div>
							<div class="message-body">
								<?php if ($list->getDescription() != null): ?>
									<p>
										<?= e($list->getDescription()) ?>
									</p>
									<hr>
								<?php endif ?>

								<p>
									<span class="icon">
										<a href="/home/article/add?listId=<?= e($list->getId()) ?>">
											<i class="fa fa-shopping-cart"></i>
										</a>
									</span>
									| Add articles
									
								</p>

								<p>
									<span class="icon">
										<a href="/home/list/edit?listId=<?= e($list->getId()) ?>">
											<i class="fa fa-edit"></i>
										</a>
									</span>
									| Edit list
									
								</p>

								<p>
									<span class="icon">	
										<a href="/home/list/delete?listId=<?= e($list->getId()) ?>">
											<i class="fa fa-trash-o"></i>
										</a>
									</span>
									| Delete list 
								</p>
								
							</div>
						</article>
					</div>

					<?php $columns_filled++; ?>

				<?php endforeach ?>

				<!-- if not all columns are filled, add placeholder -->
				<?php if ($columns_filled != \App\Controller\ListController::COLUMNS): ?>
					<?php for ($j = $columns_filled; $j < \App\Controller\ListController::COLUMNS; $j++): ?>
						<div class="tile is-parent"></div>
					<?php endfor ?>
				<?php endif ?>

			</div>

		<?php endfor ?>

		<nav class="pagination">
			<ul class="pagination-list">
				<?php for($i = 1; $i <= $pages; $i++): ?>
					<li>
						<a 
							href="/home/list?page=<?= e($i) ?>" 
							class="pagination-link <?php if($i == $page): ?>is-current<?php endif ?>">
							<?= e($i) ?>
						</a>
					</li>
				<?php endfor ?>
			</ul>
		</nav>

	</div>
</section>

<?php require_once(getenv("PROJECT_ROOT") . "/views/partials/footer.php"); ?>