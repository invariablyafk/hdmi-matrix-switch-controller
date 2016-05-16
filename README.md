
A web interface, and command line tools for controlling a Monoprice 4x4 HDMI Switch (Version 3.0) via the RS232 Serial port on a Linux/Unix/Mac system. 

Using Command Line Tools:

    Edit the $serialPort lines at the top of each file, to point to your serial port. (ie /dev/tty.usbserial-ftDIDIW0)

        command-line-tools/hdmi4x4serial.php
        command-line-tools/hdmi4x4status.php

    To see the status of the switch, run:
        
        php hdmi4x4status.php

    To send a command:
        
        php hdmi4x4serial.php [command]
    
    The command is the Tv, and Input (ie A1, for Tv A Change to Input 1) or PWR which powers the switch on/off.


Web Interface Installation On A Raspberry Pi With Raspbian:

    PHP 5.3 and Apache with Mod-Rewrite Required. 

    Place entire git repo in the web-root in a sub-directory named "hdmi" so that index.php file is located at http://<domain>/hdmi/index.php

Cable Connections:

    A special type of null-modem RS232 cable is required, with the following connections:

	Female to Female RS232 cable, below mentioned "plug_a" and "plug_b" refering to the two connectors of the cable.

	--The 2nd pin and 3rd pin of the cable is crossed as below chart.
	--RS232 cable length should be less than 15Meter.


	plug_a		1----------------------------1          plug_b         
			2------------\/--------------2
			3____________/\______________3
			4----------------------------4
			5----------------------------5


Development:

    Make Sure you have the NodeJs Package Manager (NPM) installed, as well as LESS, Grunt, and the Grunt-CLI:

        sudo npm install -g less
        sudo npm install -g grunt
        sudo npm install -g grunt-cli
    
    Then, change directory to this git repo and run:

        sudo npm install

    For Compiling the LESS:
    
        grunt watch
