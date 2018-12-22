<?php

require_once('models/HDMIMatrixSwitch.php');

class HdmiController extends AppController
{
	public function actionIndex()
	{

		$viewVars = array(
			'tvs' => array(
				'TV_01' => array(
					'slug'     => 'a',
					'name'     => 'Living Room - Main TV'
				),
				'TV_02' => array(
					'slug'     => 'b',
					'name'     => 'Living Room - Side TV'
				),
				'TV_03' => array(
					'slug'     => 'c',
					'name'     => 'Bedroom TV'
				),
				'TV_04' => array(
					'slug'     => 'd',
					'name'     => 'Bedroom TV - Side TV'
				)
			),
			'inputs' => array(
				'Input 1' => 'Xbox One S',
				'Input 2' => 'Xbox One Classic',
				'Input 3' => 'Playstation 4',
				'Input 4' => 'BMO'
			)
		);

		$this->setVars($viewVars);
		$this->loadView('hdmi');
	}

	public function actionStatus(){

		$this->layout = false;

		$hdmiSwitch = new HDMIMatrixSwitch();
		echo json_encode( @$hdmiSwitch->getStatus() );
		die();

	}

	public function actionSet($command){
		$this->layout = false;

		$hdmiSwitch = new HDMIMatrixSwitch();
		$hdmiSwitch->sendCommand($command);

		die('Sent');
	}
}

?>
