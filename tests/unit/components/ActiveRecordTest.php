<?php
use Codeception\Util\Stub;

class ActiveRecordTest extends \Codeception\TestCase\Test
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

    // tests
    public function testMassiveSetter()
    {
        $person = $this->getObject();

        $attributes = array('last_name' => 'something');

        $person->attributes = $attributes;

        $settedAttributes = $person->attributes;

        foreach ($settedAttributes as $key => $value) {
            if (!$settedAttributes[$key]) {
                unset($settedAttributes[$key]);
            }
        }

        $this->assertEquals($attributes, $settedAttributes);
        $this->assertEquals($person->last_name, $attributes['last_name']);
    }

    public function testErrorsList()
    {
        $person = $this->getObject();

        $person->addError('address', 'Address is invalid');

        $this->assertEquals($person->getErrors(), array('address' => array('Address is invalid')));
        $this->assertEquals($person->getErrors('address'), array('Address is invalid'));
        $this->assertEquals($person->getErrors('first_name'), array());

        $this->assertTrue($person->hasErrors());
        $this->assertTrue($person->hasErrors('address'));
        $this->assertFalse($person->hasErrors('first_name'));
    }

    public function getObject()
    {
        return new Person;
    }

}