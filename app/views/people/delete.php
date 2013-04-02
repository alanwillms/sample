<h1>Delete Person</h1>

<form method="POST" class="form-horizontal">

	<p>
		Are you sure you want to remove 
		<strong><?php echo htmlspecialchars($person->first_name); ?></strong>
		from the database?
	</p>

	<div class="form-actions">
		<input type="submit" value="Delete" class="btn" />
		<input type="hidden" value="<?php echo htmlspecialchars($person->id); ?>" name="id" />
		<a href="<?php echo $this->createUrl('index'); ?>" class="btn btn-primary">Cancel</a>
	</div>

</form>