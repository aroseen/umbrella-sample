/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import PNotify from '../../../node_modules/pnotify/dist/es/PNotify.js';
import PNotifyButtons from '../../../node_modules/pnotify/dist/es/PNotifyButtons.js';

require('./bootstrap');
require('select2');

PNotify.defaults.styling = 'bootstrap4';

// PNotify.error({
//   title: 'Error1',
//   text: 'I\'m an error message.1',
//   animation: 'fade',
//   animateSpeed: 'normal'
// });

$(document).ready(function () {
  // new PNotify({
  //   title: 'Bootstrap Error',
  //   text: 'Look at my beautiful styling! ^_^',
  //   type: 'error',
  //   styling: 'bootstrap4'
  // });

});