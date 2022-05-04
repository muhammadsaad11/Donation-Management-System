<?php if(count($errors_login) > 0) : ?>
	<div>
		<?php foreach ($errors_login as $error) : ?>
		
			<p><?php echo $error ?></p>
		<?php endforeach ?>

	</div>
<?php endif ?>