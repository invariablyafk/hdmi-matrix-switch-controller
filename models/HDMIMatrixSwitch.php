<?php

class HDMIMatrixSwitch {

	public function getStatus() {
        $output = shell_exec("./command-line-tools/hdmi-matrix-8x8");
		return json_decode($output, true);
	}

	public function sendCommand($command) {


        $command = strtolower(trim($command));
        
        if(strlen($command) == 2){
            $tv    = intval(ord($command[0]) - ord('a') + 1);
            $input = intval($command[1]);
            exec("./command-line-tools/hdmi-matrix-8x8 $tv $input", $output); // set single Input
        }
        
        if(strlen($command) == 4){
            $input = intval($command[3]);
            exec("./command-line-tools/hdmi-matrix-8x8 $input", $output); // set all inputs
        }

        print_r($output);

	}

}
