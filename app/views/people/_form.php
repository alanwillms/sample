<form method="POST" class="form-horizontal">

	<div class="control-group">
		<label class="control-label" for="Person_first_name">First name</label>
		<div class="controls">
			<input type="text" id="Person_first_name" name="Person[first_name]" value="<?php echo $person->first_name; ?>" />
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="Person_last_name">Last name</label>
		<div class="controls">
			<input type="text" id="Person_last_name" name="Person[last_name]" value="<?php echo $person->last_name; ?>" />
		</div>
	</div>

	<div class="form-actions">
		<input type="submit" value="Save" class="btn btn-primary" />
		<a href="<?php echo $this->createUrl('index'); ?>" class="btn">Cancel</a>
	</div>

</form>