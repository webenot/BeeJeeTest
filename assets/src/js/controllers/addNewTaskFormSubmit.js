import $ from 'jquery';

import validateForm from './validateForm';
import renderToast from '../views/renderToast';
import setInvalidFormControl from './setInvalidFormControl';

const addNewTaskFormSubmit = e => {
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
      email: curEl.find('[name="email"]').val(),
      name: curEl.find('[name="name"]').val(),
      content: curEl.find('[name="content"]').val(),
      action: 'create-task',
      checkSecurity: curEl.find('[name="checkSecurity"]').val(),
      referer: curEl.find('[name="referer"]').val(),
    },
    success: data => {
      if (process.env.NODE_ENV === 'development') console.log(data);
      if (data.message) {
        renderToast(data.message);
        curEl.closest('.modal').modal('hide');
        setTimeout(() => {
          window.location.reload();
        }, 1000);
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

export default addNewTaskFormSubmit;
