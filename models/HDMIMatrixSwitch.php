<?php

class HDMIMatrixSwitch {

	protected $serialPort = "/dev/cu.usbserial-ftDIDIW0";
	
	protected $scanningInPacket = false;
	protected $packet           = "";
	protected $packetHeader     = 0x61;
	protected $packetFooter     = 0x7a;
	protected $packetLength     = 14;

	private function decodeInputValue($value){
		switch($value){
			case chr( 0x1 ):
				return "Input 1";
				break;
			case chr( 0x2 ):
				return "Input 2";
				break;
			case chr( 0x4 ):
				return "Input 3";
				break;
			case chr( 0x8 ):
				return "Input 4";
				break;
		}
	}
	
	private function decodePacket($packet){
	
		$decodedData = array();
		$packet = str_split($packet);
	
		// Verify Header
		if(	$packet[0] != chr( $this->packetHeader )){
			return "Invalid Header";
		}

		// Verify Footer
		if(	$packet[12] != chr( $this->packetFooter )){
			return "Invalid Footer";
		}

		// Read TV A - Input
		$decodedData['TV_A']        = $this->decodeInputValue( $packet[5] );

		// Read TV B - Input
		$decodedData['TV_B']        = $this->decodeInputValue( $packet[6] );
	
		// Read TV C - Input
		$decodedData['TV_C']        = $this->decodeInputValue( $packet[7] );
	
		// Read TV D - Input
		$decodedData['TV_D']        = $this->decodeInputValue( $packet[8] );

		// Read Power Status
		$decodedData['Power']		= ($packet[10] == chr( 0x1 )) ? "On" : "Standby";
	
		return $decodedData;
	}

	public function getStatus() {

		return [];
		
		/*

		// Connect to serial port.
		$this->serialFileHandle = fopen($this->serialPort, "r");

		$returnVal = false;

		while($this->serialFileHandle != false){
			$byte = fread($this->serialFileHandle, 1);

			if($byte == chr( $this->packetHeader )){
				$scanningInPacket = true;
			}
	
			if($scanningInPacket){
				$packet .= $byte;
				if(strlen($packet) >= $this->packetLength){
					$scanningInPacket = false;
					$returnVal =  $this->decodePacket($packet);
					if(is_array($returnVal)) { break; }
					$packet = "";
				}
			}
		}
		
		if($this->serialFileHandle)
			fclose($this->serialFileHandle);
		
		return $returnVal;
		
		*/

	}
	
	public function sendCommand($command) {

		/*
		$this->serialFileHandle = fopen($this->serialPort, "w");

		$fp = $this->serialFileHandle;
		$sendByte = function($byte) use ($fp) {
			fwrite($fp, chr($byte));
		};

		$commandBytes = array();
		*/

		switch(strtolower($command)){

			case "a1";
				exec("./command-line-tools/hdmi-matrix 1 1"); // TV a SELECT inputl 
				break;
			case "a2";
				exec("./command-line-tools/hdmi-matrix 1 2"); // TV a SELECT input2 
				break;
			case "a3";
				exec("./command-line-tools/hdmi-matrix 1 3"); // TV a SELECT input3 
				break;
			case "a4";
				exec("./command-line-tools/hdmi-matrix 1 4"); // TV a SELECT input4 
				break;
		
	
			case "b1";
				exec("./command-line-tools/hdmi-matrix 2 1"); // TV b SELECT inputl 
				break;
			case "b2";
				exec("./command-line-tools/hdmi-matrix 2 2"); // TV b SELECT input2 
				break;
			case "b3";
				exec("./command-line-tools/hdmi-matrix 2 3"); // TV b SELECT input3 
				break;
			case "b4";
				exec("./command-line-tools/hdmi-matrix 2 4"); // TV b SELECT input4 
				break;
		
		
			case "c1";
				exec("./command-line-tools/hdmi-matrix 3 1"); // TV c SELECT inputl 
				break;
			case "c2";
				exec("./command-line-tools/hdmi-matrix 3 2"); // TV c SELECT input2 
				break;
			case "c3";
				exec("./command-line-tools/hdmi-matrix 3 3"); // TV c SELECT input3 
				break;
			case "c4";
				exec("./command-line-tools/hdmi-matrix 3 4"); // TV c SELECT input4 
				break;
		
		
			case "d1";
				exec("./command-line-tools/hdmi-matrix 4 1"); // TV d SELECT inputl 
				break;
			case "d2";
				exec("./command-line-tools/hdmi-matrix 4 2"); // TV d SELECT input2 
				break;
			case "d3";
				exec("./command-line-tools/hdmi-matrix 4 3"); // TV d SELECT input3 
				break;
			case "d4";
				exec("./command-line-tools/hdmi-matrix 4 4"); // TV d SELECT input4  
				break;
		
			case "pwr";
				//$commandBytes = array(0x10, 0xef, 0xd5, 0x7b); // power cycle 
				break;

		}

		/*
		if(isset($commandBytes)){
			foreach($commandBytes as $byte){
				$sendByte($byte);
				usleep(50000);		// 50 microseconds (ms)
			}
		}

		fclose($this->serialFileHandle);
		
		*/
	}

}