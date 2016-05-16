<?php

// 9600,n,8,1,DTR=true
$serialPort = "/dev/cuaU0"; // Edit this to point to your serial port. 

exec("/bin/stty -f $serialPort 9600 sane raw cs8 hupcl cread clocal -echo -onlcr ");



$fp = fopen($serialPort, "c+");
if(!$fp) die("Can't open device");

usleep(50000);

// Set blocking mode for writing
stream_set_blocking($fp,1);

$sendByte = function($byte) use ($serialPort, $fp) {
	fwrite($fp, chr($byte));
};

$command = @$argv[1];

switch(strtolower($command)){

	case "a1";
		$commandBytes = array(0x00, 0xff, 0xd5, 0x7b); // TV a SELECT inputl 
		break;
	case "a2";
		$commandBytes = array(0x01, 0xfe, 0xd5, 0x7b); // TV a SELECT input2 
		break;
	case "a3";
		$commandBytes = array(0x02, 0xfd, 0xd5, 0x7b); // TV a SELECT input3 
		break;
	case "a4";
		$commandBytes = array(0x03, 0xfc, 0xd5, 0x7b); // TV a SELECT input4 
		break;
		
	
	case "b1";
		$commandBytes = array(0x04, 0xfb, 0xd5, 0x7b); // TV b SELECT inputl 
		break;
	case "b2";
		$commandBytes = array(0x05, 0xfa, 0xd5, 0x7b); // TV b SELECT input2 
		break;
	case "b3";
		$commandBytes = array(0x06, 0xf9, 0xd5, 0x7b); // TV b SELECT input3 
		break;
	case "b4";
		$commandBytes = array(0x07, 0xf8, 0xd5, 0x7b); // TV b SELECT input4 
		break;
		
		
	case "c1";
		$commandBytes = array(0x08, 0xf7, 0xd5, 0x7b); // TV c SELECT inputl 
		break;
	case "c2";
		$commandBytes = array(0x09, 0xf6, 0xd5, 0x7b); // TV c SELECT input2 
		break;
	case "c3";
		$commandBytes = array(0x0a, 0xf5, 0xd5, 0x7b); // TV c SELECT input3 
		break;
	case "c4";
		$commandBytes = array(0x0b, 0xf4, 0xd5, 0x7b); // TV c SELECT input4 
		break;
		
		
	case "d1";
		$commandBytes = array(0x0c, 0xf3, 0xd5, 0x7b); // TV d SELECT inputl 
		break;
	case "d2";
		$commandBytes = array(0x0d, 0xf2, 0xd5, 0x7b); // TV d SELECT input2 
		break;
	case "d3";
		$commandBytes = array(0x0e, 0xf1, 0xd5, 0x7b); // TV d SELECT input3 
		break;
	case "d4";
		$commandBytes = array(0x0f, 0xf0, 0xd5, 0x7b); // TV d SELECT input4  
		break;
		
	case "pwr";
		$commandBytes = array(0x10, 0xef, 0xd5, 0x7b); // power cycle 
		break;

	case "memory";
		$commandBytes = array(0x28, 0xd7, 0xd5, 0x7b); // Store inputs to Memory for next power cycle
		break;

	default:
		echo "Unrecognized Command! \n Try [A-D][1-4] | PWR. (ie A2 for TV A, Input 2) \n";
}

if(isset($commandBytes)){
	foreach($commandBytes as $byte){
		$sendByte($byte);
		//usleep(50000);		// 50 microseconds (ms)
		usleep(20000);		// 50 microseconds (ms)
	}
	foreach($commandBytes as $byte){
		$sendByte($byte);
		//usleep(50000);		// 50 microseconds (ms)
		usleep(20000);		// 50 microseconds (ms)
	}
}

fclose($fp);
