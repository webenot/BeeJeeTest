import $ from 'jquery';

import validateForm from './validateForm';
import setInvalidFormControl from './setInvalidFormControl';

import renderToast from '../views/renderToast';

const loginFormSubmit = e => {
  const curEl = $(e.currentTarget);
  curEl.addClass('was-validated');
  if (!validateForm(curEl)) {
    return false;
  }
  $.ajax({
    url: `${window.location.origin}/ajax.php`,
    method: 'POST',
    dataType: 'json',
    data: {
      login: curEl.find('[name="login"]').val(),
      password: curEl.find('[name="password"]').val(),
      action: 'login',
      checkSecurity: curEl.find('[name="checkSecurity"]').val(),
      referer: curEl.find('[name="referer"]').val(),
    },
    success: data => {
      if (process.env.NODE_ENV === 'development') console.log(data);
      if (data.message) {
        renderToast(data.message);
        curEl.closest('.modal').modal('hide');
        $('.auth-link').text('Logout');
        setTimeout(() => {
          window.location.reload();
        }, 500);
      } else if (data.error) {
        if (data.target) {
          const target = curEl.find(`[name="${data.target}"]`);
          setInvalidFormControl(target, data.error);
        }
        renderToast(data.error, 'danger');
      }
    },
    error: error => {
      if (process.env.NODE_ENV === 'development') console.log('error', error);
      renderToast(error.message, 'danger');
    },

  });
  return false;
};

export default loginFormSubmit;
