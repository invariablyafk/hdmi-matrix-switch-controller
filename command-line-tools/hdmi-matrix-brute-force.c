
/**************************************************

compile with the command: gcc hdmi-matrix-brute-force.c rs232.c -Wall -Wextra -o2 -o hdmi-matrix-brute-force

**************************************************/

#include <stdlib.h>
#include <stdio.h>
#include <unistd.h>
#include "rs232.h"

void changeInput(int cport_nr, unsigned char commands[16][13], int inputToSelect, int tvToSelect){
	int i=0, checksum=0;

	printf("Send Command Input %d > Output %d.\t", inputToSelect+1, tvToSelect+1);

	while(i < 13){
		RS232_SendByte(cport_nr, commands[(tvToSelect * 4) + inputToSelect][i]);

		printf("%02hhX ", commands[(tvToSelect * 4) + inputToSelect][i]);

		usleep(30000);		// 30 microseconds (ms)

		if(i < 12){
			checksum += commands[(tvToSelect * 4) + inputToSelect][i];
		}

		i++;
	}

	checksum = 0x100 - checksum;

 	printf("\n");
//
// 	printf("CHK: %X\n", checksum);

}

void changeAllToInput(int cport_nr, unsigned char commands[16][13], int inputToSelect){
	int i = 0;
	while(i < 4){
		changeInput(cport_nr, commands, inputToSelect, i);
		usleep(500000);  /* sleep for 1/2 Second */
		i++;
	}
}

int loop(int cport_nr, unsigned char* buf, int commandByteCount, int* checksum){

	int n, i;

    n = RS232_PollComport(cport_nr, buf, 4095);

    if(commandByteCount == 0){
    	printf("Response From HDMI Matrix: \t\t");
    }

	if(n > 0)
	{
		buf[n] = 0;   /* always put a "null" at the end of a string! */

		for(i=0; i < n; i++)
		{
			printf("%02hhX ", buf[i]);

			if(buf[i] < 32)  /* replace unreadable control-codes by dots */
			{
				buf[i] = '.';
			}

			if((commandByteCount + i) < 11){
				*checksum = *checksum + buf[i];
			}

			if((commandByteCount+i) == 12){
				//printf("\nResp. Checksum Add: %02hhX ",   *checksum);
// 				printf("CHK: %02hhX", 0x100 - *checksum);
// 				printf(", %02hhX",    0x121 - *checksum);
// 				printf(", %02hhX",    0xB8  - *checksum);
// 				printf(", %02hhX",    0xBB  - *checksum);
// 				printf(" [%02hhX]\n",  *checksum);
				printf("\n");
				*checksum = 0;
				commandByteCount = 0;
			}

		}

		//printf("\nReceived9 %i bytes: %s\n", n, (char *)buf);


	}

    return commandByteCount + n;

}

int main(int argc, char* argv[])
{
	int cport_nr=34,        /* /dev/cuaU0 (first serial on FreeBSD) */
	    bdrate=19200,        /* 19200 baud */
	    tvToSelect=-1,
	    inputToSelect=-1,
	    commandByteCount = 0,
	    checksum = 0,
	    i = 0;

	unsigned char buf[4096];

	char mode[]={'8','N','1',0};

	unsigned char commands[16][13]={

	//	{0xA5, 0x5B, 0x02, 0x01, 0x01, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0xFC}, // Port Switch Query for Output 1
	//	{0xA5, 0x5B, 0x01, 0x04, 0x01, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0xFA}, // Port Switch Query for Input 1


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
        {0xA5, 0x5B, 0x02, 0x03, 0x04, 0x00, 0x04, 0x00, 0x00, 0x00, 0x00, 0x00, 0xF3}  // Switch Input 4, to Output 4
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

	// usleep(500000);  /* sleep for 1/2 Second */

	if(tvToSelect >= 0){
		changeInput(cport_nr, commands, inputToSelect, tvToSelect);
	} else
		changeAllToInput(cport_nr, commands, inputToSelect);

	while(i < 1000){
		commandByteCount = loop(cport_nr, buf, commandByteCount, &checksum);
		usleep(300);
		i++;
	}

    usleep(500000);  /* sleep for 1/2 Second */

	printf("\n");

  return(0);
}



