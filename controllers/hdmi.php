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
					'name'     => 'Office TV'
				)
			),
			'inputs' => array(
				'1' => 'Xbox One S',
				'2' => 'Xbox One Classic',
				'3' => 'Playstation 4',
				'6' => 'Playstation 3',
				'7' => 'Chromecast',
				'5' => 'Raspberry Pi',
				'4' => 'BMO',
				'8' => 'Other'
			)
		);

		$this->setVars($viewVars);
		$this->loadView('hdmi');
	}

	public function actionStatus(){

		$this->layout = false;

        if(file_exists("inputs.json")){
            $data    = json_decode(file_get_contents("inputs.json"), true);
            $elapsed = time() - $data['timestamp'];
            if($elapsed < 30){
                unset($data['timestamp']);
                echo json_encode($data);
                die();
            }
        }

		$hdmiSwitch = new HDMIMatrixSwitch();
		$data = @$hdmiSwitch->getStatus();
        $data['timestamp'] = time();
		file_put_contents("inputs.json", json_encode( $data ));
		unset($data['timestamp']);
		echo json_encode( $data );;
		die();

	}

	public function actionSet($command){
		$this->layout = false;

		$hdmiSwitch = new HDMIMatrixSwitch();
		$hdmiSwitch->sendCommand($command);

        unlink("inputs.json");

		die('Sent');
	}
}

?>
