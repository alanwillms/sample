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
	// TODO FLASH MESSAGES

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
	 * Update a person
	 */
	public function actionUpdate()
	{
		$person = $this->loadModel($_GET['id']);

		if (isset($_POST['Person'])) {

			$person->attributes = $_POST['Person'];

			if ($person->save()) {
				
				$this->redirect('index');
			}
		}

		$this->render('update', array('person' => $person));
	}

	/**
	 * Delete a person
	 */
	public function actionDelete()
	{
		if (isset($_POST) && isset($_POST['id'])) {

			$person = $this->loadModel($_POST['id']);
			$person->delete();

			$this->redirect('index');
		}
		
		$person = $this->loadModel($_GET['id']);
		
		$this->render('delete', array('person' => $person));
	}

	/**
	 * Load person model
	 * @param integer $id
	 * @throws Exception
	 */
	public function loadModel($id)
	{
		// AR will take care of input data...
		$model = $person = Person::findByPk($id);

		if (!$model) {
			throw new Exception('Record not found', 404);
		}

		return $model;
	}
}