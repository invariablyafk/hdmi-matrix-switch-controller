<?php

// 9600,n,8,1,DTR=true
$serialPort = "/dev/cuaU0"; // Edit this to point to your serial port. 

exec("/bin/stty -f $serialPort 9600 sane raw cs8 hupcl cread clocal -echo -onlcr ");

// exec("/bin/stty -f $serialPort speed 9600 -parenb cs8 -cstopb ");

// Connect to serial port.
$fp = fopen($serialPort, "c+");
if(!$fp) die("Can't open device");

// Set blocking mode for writing
stream_set_blocking($fp,1);
fwrite($fp,"foo\n");

// Some Variable Declarations.
$scanningInPacket = false;
$packet           = "";
$packetHeader     = chr( 0x61 );
$packetFooter     = chr( 0x7a );
$packetLength     = 14;

// Set non blocking mode for reading
stream_set_blocking($fp,0);

// Declare ticks for signal handler.
declare(ticks = 1);

// signal handler function
function sig_handler($signo)
{

     switch ($signo) {
         case SIGTERM:
             fclose($fp);
             exit;
             break;
         case SIGHUP:
             // handle restart tasks
             break;
         case SIGUSR1:
             echo "Caught SIGUSR1...\n";
             break;
         default:
             // handle all other signals
     }

}

// setup signal handlers
//pcntl_signal(SIGTERM, "sig_handler");
//pcntl_signal(SIGHUP,  "sig_handler");
//pcntl_signal(SIGUSR1, "sig_handler");

// input value decoder
$decodeInputValue = function($value){
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
};

// packet decoder.
$decodePacket = function($packet) use ($packetHeader, $packetFooter, $decodeInputValue){
	
	$decodedData = array();
	$packet = str_split($packet);
	
	// Verify Header
	if(	$packet[0] != $packetHeader){
		return "Invalid Header";
	}

	// Verify Footer
	// if(	$packet[12] != $packetFooter){
	// 	return "Invalid Footer";
	// }


	// Read TV A - Input
	$decodedData['TV_A']        = $decodeInputValue( $packet[5] );

	// Read TV B - Input
	$decodedData['TV_B']        = $decodeInputValue( $packet[6] );
	
	// Read TV C - Input
	$decodedData['TV_C']        = $decodeInputValue( $packet[7] );
	
	// Read TV D - Input
	$decodedData['TV_D']        = $decodeInputValue( $packet[8] );
	
	
/*	
	// Read TV A - Memory
	$decodedData['TV_A_Memory'] = $decodeInputValue( $packet[1] );

	// Read TV B - Memory
	$decodedData['TV_B_Memory'] = $decodeInputValue( $packet[2] );
	
	// Read TV C - Memory
	$decodedData['TV_C_Memory'] = $decodeInputValue( $packet[3] );
	
	// Read TV D - Memory
	$decodedData['TV_D_Memory'] = $decodeInputValue( $packet[4] );	

	
	// Read Input 1 Connection
	$decodedData['Input_1_Cable']  = ( ord( $packet[9] ) & 8 ) ? "Connected" : "Disconnected";

	// Read TV AB Input Connection
	$decodedData['Input_2_Cable']  = ( ord( $packet[9] ) & 7 ) ? "Connected" : "Disconnected";

	// Read TV C Input Connection
	$decodedData['Input_3_Cable']  = ( ord( $packet[9] ) & 6 ) ? "Connected" : "Disconnected";
				
	// Read TV D Input Connection
	$decodedData['Input_4_Cable']  = ( ord( $packet[9] ) & 5 ) ? "Connected" : "Disconnected";
		
	// Read TV A Output Connection
	$decodedData['TV_A_Cable']     = ( ord( $packet[9] ) & 4 ) ? "Connected" : "Disconnected";

	// Read TV B Output Connection
	$decodedData['TV_B_Cable']     = ( ord( $packet[9] ) & 3 ) ? "Connected" : "Disconnected";

	// Read TV C Output Connection
	$decodedData['TV_C_Cable']     = ( ord( $packet[9] ) & 2 ) ? "Connected" : "Disconnected";
				
	// Read TV D Output Connection
	$decodedData['TV_D_Cable']     = ( ord( $packet[9] ) & 1 ) ? "Connected" : "Disconnected";

*/

	// Read Power Status
	$decodedData['Power']		= ($packet[10] == chr( 0x1 )) ? "On" : "Standby";
	
	// Read LED Status
	// $packet[11]
	
	return print_r($decodedData, true);
};


while($fp != false){
	$byte = fgetc($fp);

	if($byte === false){
      		usleep(50000);
      		continue;
  	} 

	if($byte == $packetHeader){
		$scanningInPacket = true;
	}
	
	if($scanningInPacket){
		$packet .= $byte;
		if(strlen($packet) >= $packetLength){
			$scanningInPacket = false;
			echo $decodePacket($packet);
			echo "\n";
			$packet = "";
		}
	}
}

fclose($fp);
