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

const ERROR_TYPE = 'error';
const NOTICE_TYPE = 'notice';
const SUCCESS_TYPE = 'success';

function showNotification (type, title, text) {

  if (Array.isArray(text)) {
    let html = '<ul class="no-left-paddings">';
    for (let elem of text) {
      html += '<li>' + elem + '</li>';
    }
    text = html + '</ul>';
  }

  PNotify.alert({
    width: 600,
    title: title,
    text: text,
    animation: 'fade',
    animateSpeed: 'normal',
    type: type,
    textTrusted: true
  });
}

$(document).ready(function () {
  $(document).find('#generate-short-url-button').click(function () {
    $.get('/generate_short_url', {
      origin_url: $(document).find('#origin-url').val()
    })
      .done(function (response) {
        $(document).find('#short-url').val(response.text);
      })
      .fail(function (response) {
        let errors = [];
        for (let error in response.responseJSON.errors) {
          errors.push(response.responseJSON.errors[error]);
        }
        showNotification(ERROR_TYPE, 'Невозможно сгенерировать короткий URL', errors);
      });
  });
});