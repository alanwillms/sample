<?php 
$I = new WebGuy($scenario);
$I->wantTo('ensure people crud works');
$I->amOnPage('/');

$I->expectTo('create a new person');
$I->click('New Person');
$I->fillField('First name', 'Sherlock');
$I->fillField('Last name', 'Holmes');
$I->fillField('Email', 'detective@example.com');
$I->fillField('Address', 'Baker Street 221B');
$I->fillField('City', 'London');
$I->fillField('Country', 'England');
$I->click('Save');
$I->see('People');

$I->expectTo('edit a person');
$I->click('Update');
$I->fillField('First name', 'John');
$I->fillField('Last name', 'Watson');
$I->click('Save');
$I->see('People');
$I->dontSee('Sherlock');
$I->dontSee('Holmes');
$I->see('John');
$I->see('Watson');

$I->expectTo('delete a person');
$I->click('Delete');
$I->click('Delete');
$I->see('People');
$I->dontSee('John');
$I->dontSee('Watson');

