<?php

use Codeception\Util\Stub;

class PersonTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testValidation()
    {
        $person = new Person;
        $person->attributes = [
            'first_name' => 'Sherlock',
            'last_name' => 'Holmes',
            'country' => 'England',
            'city' => 'London',
            'address' => 'Baker Street 221',
            'email' => 'invalid',
        ];
        $person->validate();
        $this->assertTrue($person->hasErrors());
        $this->assertEquals(
            ['email' => ['This is not a valid e-mail address']],
            $person->getErrors()
        );
    }
}
