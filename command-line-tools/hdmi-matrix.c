
/**************************************************

compile with the command: gcc demo_tx.c rs232.c -Wall -Wextra -o2 -o test_tx

**************************************************/

#include <stdlib.h>
#include <stdio.h>
#include <unistd.h>
#include "rs232.h"

void changeInput(int cport_nr, char commands[18][4], int inputToSelect, int tvToSelect){
	int i=0;
	while(i < 4){
		RS232_SendByte(cport_nr, commands[(tvToSelect * 4) + inputToSelect][i]);
		usleep(30000);		// 30 microseconds (ms)
		i++;
	}
    printf("Select input %d for TV %d.\n", inputToSelect+1, tvToSelect+1);	
}

void changeAllToInput(int cport_nr, char commands[18][4], int inputToSelect){
	int i = 0;
	while(i < 4){
		changeInput(cport_nr, commands, inputToSelect, i);
		usleep(500000);  /* sleep for 1/2 Second */
		i++;
	}
}

int main(int argc, char* argv[])
{
	int cport_nr=34,        /* /dev/cuaU0 (first serial on FreeBSD) */
	    bdrate=9600,        /* 9600 baud */
	    tvToSelect=-1,
	    inputToSelect=-1;
	  
	char mode[]={'8','N','1',0};
	char commands[18][4]={
	  {0x00, 0xff, 0xd5, 0x7b}, // Switch To TV A1
	  {0x01, 0xfe, 0xd5, 0x7b}, // Switch To TV A2
	  {0x02, 0xfd, 0xd5, 0x7b}, // Switch To TV A3
	  {0x03, 0xfc, 0xd5, 0x7b}, // Switch To TV A4
	  
	  {0x04, 0xfb, 0xd5, 0x7b}, // Switch To TV B1
	  {0x05, 0xfa, 0xd5, 0x7b}, // Switch To TV B2
	  {0x06, 0xf9, 0xd5, 0x7b}, // Switch To TV B3
	  {0x07, 0xf8, 0xd5, 0x7b}, // Switch To TV B4
	  
	  {0x08, 0xf7, 0xd5, 0x7b}, // Switch To TV C1
	  {0x09, 0xf6, 0xd5, 0x7b}, // Switch To TV C2
	  {0x0a, 0xf5, 0xd5, 0x7b}, // Switch To TV C3
	  {0x0b, 0xf4, 0xd5, 0x7b}, // Switch To TV C4

	  {0x0c, 0xf3, 0xd5, 0x7b}, // Switch To TV D1
	  {0x0d, 0xf2, 0xd5, 0x7b}, // Switch To TV D2
	  {0x0e, 0xf1, 0xd5, 0x7b}, // Switch To TV D3
	  {0x0f, 0xf0, 0xd5, 0x7b}, // Switch To TV D4
	  
	  {0x10, 0xef, 0xd5, 0x7b}, // Power Cycle
	  
	  {0x28, 0xd7, 0xd5, 0x7b}  // Store Inputs To Memory For Power Cycle
	  
	};

	if(argc <= 1){
		printf("Requires at least one input.\n");
		return(1);
	}
	
	if(argc == 2){
		inputToSelect = atoi(argv[1]) - 1;
	}

	if(argc >= 3){
		tvToSelect    = atoi(argv[1]) - 1;
		inputToSelect = atoi(argv[2]) - 1;
		if(tvToSelect < 0 || tvToSelect > 3){
			printf("Only TV values of 1-4 are supported.\n");
			return(1);
		}
	}

	if(inputToSelect < 0 || inputToSelect > 3){
		printf("Only input values of 1-4 are supported.\n");
		return(1);
	}

	if(RS232_OpenComport(cport_nr, bdrate, mode)){
		printf("Cannot open the serial port.\n");
		return(0);
	}

	if(tvToSelect >= 0)
		changeInput(cport_nr, commands, inputToSelect, tvToSelect);
	else
		changeAllToInput(cport_nr, commands, inputToSelect);

#ifdef _WIN32
    Sleep(1000);
#else
    usleep(500000);  /* sleep for 1/2 Second */
#endif

  return(0);
}

