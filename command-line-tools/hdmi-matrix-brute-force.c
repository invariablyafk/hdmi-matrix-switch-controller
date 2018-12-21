
/**************************************************

compile with the command: gcc hdmi-matrix-brute-force.c rs232.c -Wall -Wextra -o2 -o hdmi-matrix-brute-force

**************************************************/

#include <stdlib.h>
#include <stdio.h>
#include <unistd.h>
#include "rs232.h"

void changeInput(int cport_nr, int inputToSelect, int tvToSelect){
	int i=0, checksum=0;
	
	int commandHeader[4] = {0xA5, 0x5B, 0x02, 0x03};
	int currentByte;

	printf("Send Command Input %d > Output %d.\t", inputToSelect, tvToSelect);

	while(i < 13){
	
		currentByte = 0x00;
		
		if(i < 4){
			currentByte = commandHeader[i];
		}
		
		if(i == 4){
			currentByte = inputToSelect;
		}
		
		if(i == 6){
			currentByte = tvToSelect;
		}

		if(i < 12){
			checksum += currentByte;
		}
		
		if(i == 12){
			currentByte = (0x100 - checksum);
		}
	
		RS232_SendByte(cport_nr, currentByte);

		printf("%02hhX ", currentByte);

		i++;
	}

	printf("\n");	

}

void changeAllToInput(int cport_nr, int inputToSelect){
	int i = 1;
	while(i <= 8){
		changeInput(cport_nr, inputToSelect, i);
		usleep(300000); // Sleep 1/3 second
		i++;
	}
}

void handleResponse(unsigned char response[13]){
	printf("Response From HDMI Matrix: \t\t");
	for(int i = 0; i < 13; i++){
		printf("%02hhX ", response[i]);
	}
	printf("\n");
}

void loop(int cport_nr, unsigned char* buf){

	int i = 0,
	numOfBytesInBuffer = 0;
	unsigned char response[13];

	while(i < 1000){
	
		numOfBytesInBuffer = RS232_PollComport(cport_nr, buf, 4095);
		
		for(int j = 0; j < numOfBytesInBuffer; j++){
			i = i + j;
			if(i >= 12){
				i = 0;
				handleResponse(response);
			}
			response[i] = buf[j];
		}
		usleep(300);
		i++;
	}

}

int main(int argc, char* argv[])
{
	int cport_nr=34,          /* /dev/cuaU0 (first serial on FreeBSD) */
	    bdrate=115200,        /* 115200 baud */
	    tvToSelect=-1,
	    inputToSelect=-1;

	unsigned char buf[4096];

	char mode[]={'8','N','1',0};

	if(argc <= 1){
		printf("Requires at least one input.\n");
		return(1);
	}

	if(argc == 2){
		inputToSelect = atoi(argv[1]);
	}

	if(argc >= 3){
		tvToSelect    = atoi(argv[1]);
		inputToSelect = atoi(argv[2]);
		if(tvToSelect < 1 || tvToSelect > 8){
			printf("Only TV values of 1-8 are supported.\n");
			return(1);
		}
	}

	if(inputToSelect < 1 || inputToSelect > 8){
		printf("Only input values of 1-8 are supported.\n");
		return(1);
	}

	if(RS232_OpenComport(cport_nr, bdrate, mode)){
		printf("Cannot open the serial port.\n");
		return(0);
	}

	if(tvToSelect >= 0){
		changeInput(cport_nr, inputToSelect, tvToSelect);
	} else
		changeAllToInput(cport_nr, inputToSelect);

	loop(cport_nr, buf);

	return(0);
}



