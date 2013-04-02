<h1>People</h1>

<p class="btn-group">
	<a href="<?php echo $this->createUrl('new'); ?>" class="btn btn-primary">New Person</a>
</p>

<?php if (count($people)) : ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th><a href="<?php echo $this->createUrl('index', array('Person' => array('first_name' => 'ASC'))); ?>">First Name</a></th>
			<th>Last name</th>
			<th>Country</th>
			<th>City</th>
			<th>Address</th>
			<th>Email</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($people as $person) : ?>
		<tr>
			<td><?php echo $person->id; ?></td>
			<td><?php echo $person->first_name; ?></td>
			<td><?php echo $person->last_name; ?></td>
			<td><?php echo $person->country; ?></td>
			<td><?php echo $person->city; ?></td>
			<td><?php echo $person->address; ?></td>
			<td><?php echo $person->email; ?></td>
			<td><a href="<?php echo $this->createUrl('update', array('id' => $person->id)); ?>">Update</a></td>
			<td></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php else : ?>
	<p>No records found.</p>
<?php endif; ?>