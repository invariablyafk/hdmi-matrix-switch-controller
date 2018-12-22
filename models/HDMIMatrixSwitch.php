<?php

class HDMIMatrixSwitch {

	public function getStatus() {
        $output = shell_exec("./command-line-tools/hdmi-matrix-8x8");
		return json_decode($output, true);
	}

	public function sendCommand($command) {

		switch(strtolower($command)){

			case "a1";
				exec("./command-line-tools/hdmi-matrix-8x8 1 1", $output); // TV a SELECT inputl
				break;
			case "a2";
				exec("./command-line-tools/hdmi-matrix-8x8 1 2", $output); // TV a SELECT input2
				break;
			case "a3";
				exec("./command-line-tools/hdmi-matrix-8x8 1 3", $output); // TV a SELECT input3
				break;
			case "a4";
				exec("./command-line-tools/hdmi-matrix-8x8 1 4", $output); // TV a SELECT input4
				break;


			case "b1";
				exec("./command-line-tools/hdmi-matrix-8x8 2 1", $output); // TV b SELECT inputl
				break;
			case "b2";
				exec("./command-line-tools/hdmi-matrix-8x8 2 2", $output); // TV b SELECT input2
				break;
			case "b3";
				exec("./command-line-tools/hdmi-matrix-8x8 2 3", $output); // TV b SELECT input3
				break;
			case "b4";
				exec("./command-line-tools/hdmi-matrix-8x8 2 4", $output); // TV b SELECT input4
				break;


			case "c1";
				exec("./command-line-tools/hdmi-matrix-8x8 3 1", $output); // TV c SELECT inputl
				break;
			case "c2";
				exec("./command-line-tools/hdmi-matrix-8x8 3 2", $output); // TV c SELECT input2
				break;
			case "c3";
				exec("./command-line-tools/hdmi-matrix-8x8 3 3", $output); // TV c SELECT input3
				break;
			case "c4";
				exec("./command-line-tools/hdmi-matrix-8x8 3 4", $output); // TV c SELECT input4
				break;


			case "d1";
				exec("./command-line-tools/hdmi-matrix-8x8 4 1", $output); // TV d SELECT inputl
				break;
			case "d2";
				exec("./command-line-tools/hdmi-matrix-8x8 4 2", $output); // TV d SELECT input2
				break;
			case "d3";
				exec("./command-line-tools/hdmi-matrix-8x8 4 3", $output); // TV d SELECT input3
				break;
			case "d4";
				exec("./command-line-tools/hdmi-matrix-8x8 4 4", $output); // TV d SELECT input4
				break;

			case "all1";
				exec("./command-line-tools/hdmi-matrix-8x8 1", $output); // TV ALL SELECT inputl
				break;
			case "all2";
				exec("./command-line-tools/hdmi-matrix-8x8 2", $output); // TV ALL SELECT input2
				break;
			case "all3";
				exec("./command-line-tools/hdmi-matrix-8x8 3", $output); // TV ALL SELECT input3
				break;
			case "all4";
				exec("./command-line-tools/hdmi-matrix-8x8 4", $output); // TV ALL SELECT input4
				break;



		}
        
        print_r($output);

	}

}
