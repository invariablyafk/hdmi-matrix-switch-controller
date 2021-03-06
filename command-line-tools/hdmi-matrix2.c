
/**************************************************

compile with the command: gcc hdmi-matrix2.c rs232.c -Wall -Wextra -o2 -o hdmi_matrix2

**************************************************/

#include <stdlib.h>
#include <stdio.h>
#include <unistd.h>
#include "rs232.h"

void changeInput(int cport_nr, char commands[32][13], int inputToSelect, int tvToSelect){
	int i=0;
	while(i < 13){
		RS232_SendByte(cport_nr, commands[(tvToSelect * 4) + inputToSelect][i]);
		usleep(30000);		// 30 microseconds (ms)
		i++;
	}
    printf("Select input %d for TV %d.\n", inputToSelect+1, tvToSelect+1);
}

void changeAllToInput(int cport_nr, char commands[32][13], int inputToSelect){
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
	    bdrate=115200,        /* 115200 baud */
	    tvToSelect=-1,
	    inputToSelect=-1;

	char mode[]={'8','N','1',0};
	char commands[32][13]={
        {0xA5, 0x5B, 0x02, 0x03, 0x01, 0x00, 0x01, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF9}, // Switch Input 1, to Output 1
        {0xA5, 0x5B, 0x02, 0x03, 0x02, 0x00, 0x01, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF8}, // Switch Input 2, to Output 1
        {0xA5, 0x5B, 0x02, 0x03, 0x03, 0x00, 0x01, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF7}, // Switch Input 3, to Output 1
        {0xA5, 0x5B, 0x02, 0x03, 0x04, 0x00, 0x01, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF6}, // Switch Input 4, to Output 1

        {0xA5, 0x5B, 0x02, 0x03, 0x01, 0x00, 0x02, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF8}, // Switch Input 1, to Output 2
        {0xA5, 0x5B, 0x02, 0x03, 0x02, 0x00, 0x02, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF7}, // Switch Input 2, to Output 2
        {0xA5, 0x5B, 0x02, 0x03, 0x03, 0x00, 0x02, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF6}, // Switch Input 3, to Output 2
        {0xA5, 0x5B, 0x02, 0x03, 0x04, 0x00, 0x02, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF5}, // Switch Input 4, to Output 2

        {0xA5, 0x5B, 0x02, 0x03, 0x01, 0x00, 0x03, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF7}, // Switch Input 1, to Output 3
        {0xA5, 0x5B, 0x02, 0x03, 0x02, 0x00, 0x03, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF6}, // Switch Input 2, to Output 3
        {0xA5, 0x5B, 0x02, 0x03, 0x03, 0x00, 0x03, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF5}, // Switch Input 3, to Output 3
        {0xA5, 0x5B, 0x02, 0x03, 0x04, 0x00, 0x03, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF4}, // Switch Input 4, to Output 3

        {0xA5, 0x5B, 0x02, 0x03, 0x01, 0x00, 0x04, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF6}, // Switch Input 1, to Output 4
        {0xA5, 0x5B, 0x02, 0x03, 0x02, 0x00, 0x04, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF5}, // Switch Input 2, to Output 4
        {0xA5, 0x5B, 0x02, 0x03, 0x03, 0x00, 0x04, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF4}, // Switch Input 3, to Output 4
        {0xA5, 0x5B, 0x02, 0x03, 0x04, 0x00, 0x04, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF3}, // Switch Input 4, to Output 4

        {0xA5, 0x5B, 0x02, 0x03, 0x01, 0x00, 0x05, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF9}, // Switch Input 1, to Output 5
        {0xA5, 0x5B, 0x02, 0x03, 0x02, 0x00, 0x05, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF8}, // Switch Input 2, to Output 5
        {0xA5, 0x5B, 0x02, 0x03, 0x03, 0x00, 0x05, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF7}, // Switch Input 3, to Output 5
        {0xA5, 0x5B, 0x02, 0x03, 0x04, 0x00, 0x05, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF6}, // Switch Input 4, to Output 5

        {0xA5, 0x5B, 0x02, 0x03, 0x01, 0x00, 0x06, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF8}, // Switch Input 1, to Output 6
        {0xA5, 0x5B, 0x02, 0x03, 0x02, 0x00, 0x06, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF7}, // Switch Input 2, to Output 6
        {0xA5, 0x5B, 0x02, 0x03, 0x03, 0x00, 0x06, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF6}, // Switch Input 3, to Output 6
        {0xA5, 0x5B, 0x02, 0x03, 0x04, 0x00, 0x06, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF5}, // Switch Input 4, to Output 6

        {0xA5, 0x5B, 0x02, 0x03, 0x01, 0x00, 0x07, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF7}, // Switch Input 1, to Output 7
        {0xA5, 0x5B, 0x02, 0x03, 0x02, 0x00, 0x07, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF6}, // Switch Input 2, to Output 7
        {0xA5, 0x5B, 0x02, 0x03, 0x03, 0x00, 0x07, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF5}, // Switch Input 3, to Output 7
        {0xA5, 0x5B, 0x02, 0x03, 0x04, 0x00, 0x07, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF4}, // Switch Input 4, to Output 7

        {0xA5, 0x5B, 0x02, 0x03, 0x01, 0x00, 0x08, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF6}, // Switch Input 1, to Output 8
        {0xA5, 0x5B, 0x02, 0x03, 0x02, 0x00, 0x08, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF5}, // Switch Input 2, to Output 8
        {0xA5, 0x5B, 0x02, 0x03, 0x03, 0x00, 0x08, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF4}, // Switch Input 3, to Output 8
        {0xA5, 0x5B, 0x02, 0x03, 0x04, 0x00, 0x08, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF3}  // Switch Input 4, to Output 8

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

