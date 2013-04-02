<h1>People</h1>

<p>
	<a href="<?php echo $this->createUrl('new'); ?>" class="btn btn-primary">New Person</a>
</p>

<?php
$grid = new GridViewHelper;
$grid->className = 'Person';
$grid->listedAttributes = Person::getAttributesNames();
$grid->actionLinks = array(
	'update' => 'Update',
	'delete' => 'Delete',
);
$grid->objects = $people;

echo $grid->render($this);
