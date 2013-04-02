<?php
$form = new ActiveForm($person);

$form->open();
	
$form->textInput('first_name');
$form->textInput('last_name');
$form->emailInput('email');
$form->textArea('address');
$form->textInput('city');
$form->textInput('country');

$form->buttons();

$form->close();