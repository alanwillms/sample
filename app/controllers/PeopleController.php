<?php
/**
 * People controller
 * @author Alan Willms
 */
class PeopleController extends Controller
{
	/**
	 * List names
	 */
	public function actionIndex()
	{
		$this->render('index');
	}
}