<?php
/**
 * People controller
 * @author Alan Willms
 */
class PeopleController extends Controller
{
	/**
	 * List people
	 */
	public function actionIndex()
	{
		$filtering = array();

		if (isset($_GET['Person'])) {

			// Input is checked in AR model!
			$filtering['order'] = $_GET['Person'];
		}

		$people = Person::all($filtering);

		$this->render('index', array('people' => $people));
	}

	/**
	 * Create person
	 */
	public function actionnew()
	{
		$person = new Person;

		if (isset($_POST['Person'])) {

			// Model will filter user input.. don't worry!
			$person->attributes = $_POST['Person'];

			if ($person->save()) {
				
				$this->redirect('index');
			}
		}

		$this->render('new', array('person' => $person));
	}
}