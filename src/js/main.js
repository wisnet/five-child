import flash from 'flash';
import axios from 'axios';

flash.message = {
	status: 'success',
	content: 'Hello',
	showTime: 2000,
	dismisable: true
};

// flash.displayMessage();

console.log('scripts running');

axios.get(wajax.url, {
	params: {
		action: 'test'
	}
}).then(function (e, d) {
	console.log(e, d);
}).catch(function (e) {
	console.log(e);
});
