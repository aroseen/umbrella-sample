/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import PNotify from '../../../node_modules/pnotify/dist/es/PNotify.js';
import PNotifyButtons from '../../../node_modules/pnotify/dist/es/PNotifyButtons.js';

require('./bootstrap');
let axios = require('axios');

PNotify.defaults.styling = 'bootstrap4';

const OWN_LINKS_TABLE = 'own_links_table';
const SHARED_LINKS_TABLE = 'shared_links_table';
const GET_SHARED_TABLE = 'get_shared_table';

const ERROR_TYPE = 'error';
const SUCCESS_TYPE = 'success';

/**
 * Показать уведомление
 * @param type
 * @param title
 * @param text
 */
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

/**
 * Перезагрузка таблиц
 * @param tables
 */
function reloadTables (tables) {
  axios.get('/reloadTables', {
    params: {
      tables: tables
    }
  })
    .then(function (response) {
      for (let table in response.data.tables) {
        $(document).find('#' + table).html(response.data.tables[table]);
      }
    })
    .catch(function (error) {
      showNotification(ERROR_TYPE, error.response.data.title, error.response.data.message);
    });
}

$(document).ready(function () {

  $(document).find('#generate-short-url-button').click(function () {
    axios.get('/generateShortUrl', {
      params: {
        origin_url: $(document).find('#origin-url').val()
      }
    })
      .then(function (response) {
        $(document).find('#short-url').val(response.data.short);
      })
      .catch(function (errorResponse) {
        let errors = [];
        for (let error in errorResponse.response.data.errors) {
          errors.push(errorResponse.response.data.errors[error]);
        }
        showNotification(ERROR_TYPE, errorResponse.response.data.title || 'Невозможно сгенерировать короткий URL', errors);
      });
  });

  let urlId = null;

  $(document).find('.open-share-dialog-button').click(function (event) {
    urlId = $(event.target).data('urlId');
  });

  $(document).find('#share-link-to-user').click(function (event) {
    let userId = $(document).find('#share-users-list').val();
    if (urlId !== null && userId !== null) {
      axios.post('/share/' + urlId + '/' + userId)
        .then(function (response) {
          $(event.target).closest('.modal').modal('hide');
          reloadTables([SHARED_LINKS_TABLE]);
          showNotification(SUCCESS_TYPE, response.data.title, response.data.message);
        })
        .catch(function (error) {
          showNotification(ERROR_TYPE, error.response.data.title, error.response.data.message);
        });
    }
  });

  $(document).find('body').on('click', '.unshare-button', function () {
    let urlId = $(event.target).data('urlId'), userId = $(event.target).data('userId');
    if (urlId !== undefined && userId !== undefined) {
      axios.post('/unshare/' + urlId + '/' + userId)
        .then(function (response) {
          reloadTables([SHARED_LINKS_TABLE]);
          showNotification(SUCCESS_TYPE, response.data.title, response.data.message);
        })
        .catch(function (error) {
          showNotification(ERROR_TYPE, error.response.data.title, error.response.data.message);
        });
    }
  });

  $(document).find('.modal').on('show.bs.modal', function () {
    if (urlId !== null) {
      axios.get('/usersToShare/' + urlId)
        .then(function (response) {
          let options = [];
          for (let user of response.data.users) {
            options.push('<option value="' + user.id + '">' + user.name + '</option>');
          }
          $(document).find('#share-users-list').html(options);

        })
        .catch(function (error) {
          showNotification(ERROR_TYPE, error.response.data.title, error.response.data.message);
        });
    }
  });

  $(document).find('#shareCheckbox').change(function (event) {
    axios.put('/toggleCanShare', {
      canShare: $(event.target).prop('checked')
    })
      .then(function (response) {
        reloadTables([OWN_LINKS_TABLE]);
        showNotification(SUCCESS_TYPE, response.data.title, response.data.message);
      })
      .catch(function (error) {
        showNotification(ERROR_TYPE, error.response.data.title, error.response.data.message);
      });
  });

});