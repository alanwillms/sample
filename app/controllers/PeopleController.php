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

	// TODO CHECK SAFE ATTRIBUTES

	/**
	 * Create person
	 */
	public function actionNew()
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

	/**
	 * Update person
	 */
	public function actionUpdate()
	{
		// Model will filter user input.. don't worry!
		$person = Person::findByPk($_GET['id']);

		if (isset($_POST['Person'])) {

			$person->attributes = $_POST['Person'];

			if ($person->save()) {
				
				$this->redirect('index');
			}
		}

		$this->render('update', array('person' => $person));
	}
}