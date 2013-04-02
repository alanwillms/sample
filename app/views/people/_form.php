<?php if ($person->hasErrors()) : ?>
<div class="alert alert-error">
	<ul>
	<?php foreach ($person->getErrors() as $attribute => $errors) : ?>
		<li><?php echo implode('. ', $errors); ?></li>
	<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>

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

	<div class="control-group">
		<label class="control-label" for="Person_email">E-mail</label>
		<div class="controls">
			<input type="email" id="Person_email" name="Person[email]" value="<?php echo $person->email; ?>" />
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="Person_address">Address</label>
		<div class="controls">
			<input type="text" id="Person_address" name="Person[address]" value="<?php echo $person->address; ?>" />
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="Person_city">City</label>
		<div class="controls">
			<input type="text" id="Person_city" name="Person[city]" value="<?php echo $person->city; ?>" />
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="Person_country">Country</label>
		<div class="controls">
			<input type="text" id="Person_country" name="Person[country]" value="<?php echo $person->country; ?>" />
		</div>
	</div>

	<div class="form-actions">
		<input type="submit" value="Save" class="btn btn-primary" />
		<a href="<?php echo $this->createUrl('index'); ?>" class="btn">Cancel</a>
	</div>

</form>