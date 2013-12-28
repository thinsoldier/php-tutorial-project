<?php
require_once 'lib/common.php';

session_start();

// Connect to the database, run a query, handle errors
$pdo = getPDO();
$posts = getAllPosts($pdo);

$notFound = isset($_GET['not-found']);

?>
<!DOCTYPE html>
<html>
	<head>
		<title>A blog application</title>
		<?php require 'templates/head.php' ?>
	</head>
	<body>
		<?php require 'templates/title.php' ?>

		<?php if ($notFound): ?>
			<div class="error box">
				Error: cannot find the requested blog post
			</div>
		<?php endif ?>

		<div class="post-list">
			<?php foreach ($posts as $row): ?>
				<div class="post-synopsis"> 
					<h2>
						<?php echo htmlEscape($row['title']) ?>
					</h2>
					<div class="meta">
						<?php echo convertSqlDate($row['created_at']) ?>

						(<?php echo countCommentsForPost($pdo, $row['id']) ?> comments)
					</div>
					<p>
						<?php echo htmlEscape($row['body']) ?>
					</p>
					<div class="post-controls">
						<a
							href="view-post.php?post_id=<?php echo $row['id'] ?>"
						>Read more...</a>
						<?php if (isLoggedIn()): ?>
							|
							<a
								href="edit-post.php?post_id=<?php echo $row['id'] ?>"
							>Edit</a>
						<?php endif ?>
					</div>
				</div>
			<?php endforeach ?>
		</div>

	</body>
</html>
