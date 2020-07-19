import $ from 'jquery';
import validateForm from './validateForm';
import renderToast from '../views/renderToast';
import setInvalidFormControl from './setInvalidFormControl';

const updateTaskContentSubmit = e => {
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
      id: curEl.find('[name="id"]').val(),
      content: curEl.find('[name="content"]').val(),
      action: 'update-task',
      checkSecurity: curEl.find('[name="checkSecurity"]').val(),
      referer: curEl.find('[name="referer"]').val(),
    },
    success: data => {
      if (process.env.NODE_ENV === 'development') console.log(data);
      if (data.message) {
        renderToast(data.message);
        if (!data.status || (data.status && data.status.toString() !== '204')) {
          curEl.hide();
          curEl.closest('tr').find('.task-content').html(data.task.content);
          curEl.closest('tr').find('.editTask').show();
          const taskStatusContainer = curEl.closest('tr').find('.task-status');
          taskStatusContainer.text(data.task.status);
          taskStatusContainer.attr('class', 'text-warning task-status');
        }
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

export default updateTaskContentSubmit;
