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
//   title: 'Error',
//   text: 'I\'m an error message.',
//   animation: 'fade',
//   animateSpeed: 'normal'
// });