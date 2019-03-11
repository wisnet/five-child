window.Popper = require('popper.js').default;
try {
	window.$ = window.jQuery = require('jquery');
} catch (e) {
}

console.log('sup');
// require('jquery-ui');
// require('jquery-ui/ui/widget');
// require('jquery-ui/ui/widgets/mouse');
// require('./helpers');
// require('./flash');
require('./main');
// require('./menu');
// require('./block-slideshow');

