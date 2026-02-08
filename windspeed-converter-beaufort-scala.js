// JavaScript Document

function get_beaufort(type,input) {
		if(type == 'kmh') {
			if(input < 1) { return 0 };
			if((input >= 1) && (input <= 5)) { return 1 }
			if((input >= 6) && (input <= 11)) { return 2 }
			if((input >= 12) && (input <= 19)) { return 3 }
			if((input >= 20) && (input <= 28)) { return 4 }
			if((input >= 29) && (input <= 38)) { return 5 }
			if((input >= 39) && (input <= 49)) { return 6 }
			if((input >= 50) && (input <= 61)) { return 7 }
			if((input >= 62) && (input <= 74)) { return 8 }
			if((input >= 75) && (input <= 88)) { return 9 }
			if((input >= 89) && (input <= 102)) { return 10 }
			if((input >= 103) && (input <= 117)) { return 11 }
			if(input >= 118) { return 12 }
		}
		if(type == 'mph') {
			if(input < 1) { return 0 };
			if((input >= 1) && (input <= 3)) { return 1 }
			if((input >= 4) && (input <= 7)) { return 2 }
			if((input >= 8) && (input <= 12)) { return 3 }
			if((input >= 13) && (input <= 18)) { return 4 }
			if((input >= 19) && (input <= 24)) { return 5 }
			if((input >= 25) && (input <= 31)) { return 6 }
			if((input >= 32) && (input <= 38)) { return 7 }
			if((input >= 39) && (input <= 46)) { return 8 }
			if((input >= 47) && (input <= 54)) { return 9 }
			if((input >= 55) && (input <= 63)) { return 10 }
			if((input >= 64) && (input <= 72)) { return 11 }
			if(input >= 73) { return 12 }
		}
		if(type == 'ms') {
			if(input < 0.2) { return 0 };
			if((input >= 0.3) && (input <= 1.5)) { return 1 }
			if((input >= 1.6) && (input <= 3.3)) { return 2 }
			if((input >= 3.4) && (input <= 5.4)) { return 3 }
			if((input >= 5.5) && (input <= 7.9)) { return 4 }
			if((input >= 8.0) && (input <= 10.7)) { return 5 }
			if((input >= 10.8) && (input <= 13.8)) { return 6 }
			if((input >= 13.9) && (input <= 17.1)) { return 7 }
			if((input >= 17.2) && (input <= 20.7)) { return 8 }
			if((input >= 20.8) && (input <= 24.4)) { return 9 }
			if((input >= 24.5) && (input <= 28.4)) { return 10 }
			if((input >= 28.5) && (input <= 32.6)) { return 11 }
			if(input >= 32.7) { return 12 }
		}
		if(type == 'knots') {
			if(input == 1) { return 0 };
			if((input > 1) && (input <= 3)) { return 1 }
			if((input >= 4) && (input <= 6)) { return 2 }
			if((input >= 7) && (input <= 10)) { return 3 }
			if((input >= 11) && (input <= 15)) { return 4 }
			if((input >= 16) && (input <= 21)) { return 5 }
			if((input >= 22) && (input <= 27)) { return 6 }
			if((input >= 28) && (input <= 33)) { return 7 }
			if((input >= 34) && (input <= 40)) { return 8 }
			if((input >= 41) && (input <= 47)) { return 9 }
			if((input >= 48) && (input <= 55)) { return 10 }
			if((input >= 56) && (input <= 63)) { return 11 }
			if(input >= 64) { return 12 }
		}
}

function convert_beaufort(input) {
		if(input == 0) {
			kmh = '< 1';
			mph = '< 1';
			ms  = '< 0.2';
			knots = '1';
		}
		if(input == 1) {
			kmh = '1 - 5';
			mph = '1 - 3';
			ms  = '0.3 - 1.5';
			knots = '1 - 3';
		}
		if(input == 2) {
			kmh = '6 - 11';
			mph = '4 - 7';
			ms  = '1.6 - 3.3';
			knots = '4 - 6';
		}
		if(input == 3) {
			kmh = '12 - 19';
			mph = '8 - 12';
			ms  = '3.4 - 5.4';
			knots = '7 - 10';
		}
		if(input == 4) {
			kmh = '20 - 28';
			mph = '13 - 18';
			ms  = '5.5 - 7.9';
			knots = '11 - 15';
		}
		if(input == 5) {
			kmh = '29 - 38';
			mph = '19 - 24';
			ms  = '8.0 - 10.7';
			knots = '16 - 21';
		}
		if(input == 6) {
			kmh = '39 - 49';
			mph = '25 - 31';
			ms  = '10.8 - 13.8';
			knots = '22 - 27';
		}
		if(input == 7) {
			kmh = '50 - 61';
			mph = '32 - 38';
			ms  = '13.9 - 17.1';
			knots = '28 - 33';
		}
		if(input == 8) {
			kmh = '62 - 74';
			mph = '39 - 46';
			ms  = '17.2 - 20.7';
			knots = '34 - 40';
		}
		if(input == 9) {
			kmh = '75 - 88';
			mph = '47 - 54';
			ms  = '20.8 - 24.4';
			knots = '41 - 47';
		}
		if(input == 10) {
			kmh = '89 - 102';
			mph = '55 - 63';
			ms  = '24.5 - 28.4';
			knots = '48 - 55';
		}
		if(input == 11) {
			kmh = '103 - 117';
			mph = '64 - 72';
			ms  = '28.5 - 32.6';
			knots = '56 - 63';
		}
		if(input == 12) {
			kmh = '> 118';
			mph = '> 72';
			ms  = '> 32.7';
			knots = '> 63';
		}
		
		return kmh;
		return mph;
		return ms;
		return knots;
}