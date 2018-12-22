<?php

require_once('models/HDMIMatrixSwitch.php');

class HdmiController extends AppController
{
	public function actionIndex()
	{

		$viewVars = array(
			'tvs' => array(
				'a' => array(
					'name'     => 'Living Room - Main TV'
				),
				'b' => array(
					'name'     => 'Living Room - Side TV'
				),
				'c' => array(
					'name'     => 'Bedroom TV'
				),
				'd' => array(
					'name'     => 'Bedroom TV - Side TV'
				)
			),
			'inputs' => array(
				'1' => 'Xbox One S',
				'2' => 'Xbox One Classic',
				'3' => 'Playstation 4',
				'4' => 'BMO'
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
