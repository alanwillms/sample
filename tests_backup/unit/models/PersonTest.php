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

    // tests
    public function testEmailValidation()
    {
        $person = $this->getValidObject();
        $person->email = 'invalid email';
        $this->assertFalse($person->save());
    }

    public function testRequiredAttributes()
    {
        $requiredAttributes = array('first_name', 'last_name', 'country', 'city', 'address', 'email');

        foreach ($requiredAttributes as $attribute) {
            $person = $this->getValidObject();
            $person->$attribute = null;
            $this->assertFalse($person->save());
        }
    }

    public function testSaving()
    {
        $person = $this->getValidObject();
        $person->first_name = 'Testé le Testá';
        $this->assertTrue($person->save());
        $this->codeGuy->seeInDatabase('people', array('first_name' => 'Testé le Testá'));
    }

    public function getValidObject()
    {
        $person = new Person;
        $person->attributes = array(
            'first_name' => 'Testy',
            'last_name'  => 'McTester',
            'email'      => 'example@example.com',
            'address'    => 'Testers Street 19th',
            'city'       => 'Testerville',
            'country'    => 'Testland',
        );
        return $person;
    }

}