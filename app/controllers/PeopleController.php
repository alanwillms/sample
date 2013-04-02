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
}