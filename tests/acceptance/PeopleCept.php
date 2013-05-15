<?php
$I = new WebGuy($scenario);
$I->wantTo('register a new person');
$I->amOnPage('/');
$I->click('New Person');

$I->fillField('Person[first_name]', 'Testy');
$I->fillField('Person[last_name]', 'McTester');
$I->fillField('Person[email]', 'example@example.com');
$I->fillField('Person[address]', 'Testers Street 19th');
$I->fillField('Person[city]', 'Testerville');
$I->fillField('Person[country]', 'Testland');
$I->click('Save');

$I->see('Testy');
$I->see('McTester');