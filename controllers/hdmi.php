<?php

require_once('models/HDMIMatrixSwitch.php');

class HdmiController extends AppController
{
	public function actionIndex()
	{

		$viewVars = array(
			'tvs' => array(
				'TV_A' => array(
					'slug'     => 'a',
					'name'     => 'Living Room - Main TV'
				),
				'TV_B' => array(
					'slug'     => 'b',
					'name'     => 'Living Room - Side TV'
				),
				'TV_C' => array(
					'slug'     => 'c',
					'name'     => 'Bedroom TV'
				),
				'TV_D' => array(
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

		$hdmiSwitch = new HDMIMatrixSwitch();
		$status = @$hdmiSwitch->getStatus();
		if(is_array($status)){
			foreach($status as $tv_slug => $input){
				if($tv_slug != 'Power')
				$viewVars['tvs'][$tv_slug]['selected'] = $input;
			}
		}

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
