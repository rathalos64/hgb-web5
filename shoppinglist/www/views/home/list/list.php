<?php require_once(getenv("PROJECT_ROOT") . "/views/partials/header.php"); ?>

<section class="hero">
<div class="hero-body">
	<div id="active" class="container">
		<p class="title">
			<?= e($list->getTitle()) ?>

			<?php $color = \App\Utils::listStateToColor(e($list->getState())); ?>
			<span class="tag is-<?= $color ?> is-medium">
				<?= \App\Utils::listStateToDisplayShort(e($list->getState())) ?>
			</span>
		</p>
		<p class="subtitle">
			<?php if ($list->getDescription() == ""): ?>
				No Description
			<?php else: ?>
				<?= e($list->getDescription()) ?>
			<?php endif ?>
		</p>
		<p class="subtitle">
			<a href="/home/article/add?listId=<?= e($listId) ?>">
				<span><i class="icon fa fa-shopping-cart"></i></span>&nbsp;&nbsp;Add new article
			</a>
			<br/>
			<a id="edit">
				<span><i id="edit" class="icon fa fa-edit"></i></span>&nbsp;&nbsp;Edit list
			</a>
		</p>
	</div>
	<div id="inactive" class="container" style="display: none">
		<form action="/home/list/edit" method="POST">
			<input type="hidden" name="listId" value="<?= e($listId) ?>"/>
			<div class="field">
				<label class="label">Title</label>
				<div class="control">
					<input class="input" name="title" type="text" placeholder="The title of the list" value="<?= e($list->getTitle()) ?>">
				</div>
			</div>

			<div class="field">
				<label class="label">Description</label>
				<div class="control">
					<input class="input" name="description" type="text" placeholder="The description of the list" value="<?= e($list->getDescription())?>">
				</div>
			</div>
			<div class="field">
				<div class="control">
					<button class="button is-link" type="submit">Update</button>
				</div>
			</div>
			<div class="field">
				<div class="control">
					<a id="edit-end">
						<span><i id="edit-end" class="icon fa fa-times"></i></span>&nbsp;&nbsp;End edit
					</a>
				</div>
			</div>
		</form>
	</div>
</div>
</section>

<hr>

<nav class="level">
  <div class="level-item has-text-centered">
    <div>
      <p class="heading">Articles</p>
      <p class="title"><?= e($list->getNumberOfArticles()) ?></p>
    </div>
  </div>
  <div class="level-item has-text-centered">
    <div>
      <p class="heading">Finished</p>
      <p class="title"><?= e($list->getFinishedArticles()) ?></p>
    </div>
  </div>
</nav>

<hr>

<?php if (count($articles) > 0): ?>
<section class="section">
    <div class="container">
		
		<table class="table table is-fullwidth">
			<thead>
				<tr>
					<th>Title</th>
					<th>Description</th>
					<th>State</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($articles as $article): ?>
				<tr>
					<td><?= e($article->getTitle()) ?></td>
					<td><?= e($article->getDescription()) ?></td>
					<?php $state = e($article->getState()); ?>
					<?php if ($state != \App\Model\Article::STATE_UNFINISHED): ?>
						<td>
							<a href="/home/article/unfinish?listId=<?= e($listId) ?>&amp;articleId=<?= e($article->getId()) ?>">
								<span class="icon has-text-success">
									<i class="icon fa fa-check fa-2x"></i>
								</span>
							</a>
						</td>
					<?php else: ?>
						<td>
							<a href="/home/article/finish?listId=<?= e($listId) ?>&amp;articleId=<?= e($article->getId()) ?>">
								<span class="icon has-text-danger">
									<i class="icon fa fa-times fa-2x"></i>
								</span>
							</a>
						</td> 
					<?php endif ?>
					<td>
						<a href="/home/article/delete?listId=<?= e($listId) ?>&amp;articleId=<?= e($article->getId()) ?>">
							<span class="icon has-text-danger">
								<i class="icon fa fa-trash-o fa-2x"></i>
							</span>
						</a>
					</td>
				</tr>
			<?php endforeach ?>
			</tbody>
		</table>

		<nav class="pagination">
			<ul class="pagination-list">
				<?php for($i = 1; $i <= $pages; $i++): ?>
					<li>
						<a 
							href="/home/list/edit?listId=<?= e($listId) ?>&amp;page=<?= e($i) ?>" 
							class="pagination-link <?php if($i == $page): ?>is-current<?php endif ?>">
							<?= e($i) ?>
						</a>
					</li>
				<?php endfor ?>
			</ul>
		</nav>
	</div>
</section>
<?php endif ?>

<?php require_once(getenv("PROJECT_ROOT") . "/views/partials/footer.php"); ?>