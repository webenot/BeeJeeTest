import $ from 'jquery';
import renderToast from '../views/renderToast';

const closeTaskCheckboxChange = e => {
  const curEl = $(e.currentTarget);
  if (curEl.is(':checked')) {
    $.ajax({
      url: `${window.location.origin}/ajax.php`,
      method: 'POST',
      dataType: 'json',
      data: {
        id: curEl.val(),
        status: 'closed',
        action: 'update-task',
        checkSecurity: '',
        referer: window.location.href,
      },
      success: data => {
        if (process.env.NODE_ENV === 'development') console.log(data);
        if (data.message) {
          renderToast(data.message);
          if (!data.status || (data.status && data.status.toString() !== '204')) {
            const taskStatusContainer = curEl.closest('tr').find('.task-status');
            taskStatusContainer.text(data.task.status);
            taskStatusContainer.attr('class', 'text-success task-status');
            curEl.attr('disabled', true);
            curEl.closest('tr').find('.editTask').attr('disabled', true);
          }
        } else if (data.error) {
          renderToast(data.error, 'danger');
        }
      },
      error: error => {
        if (process.env.NODE_ENV === 'development') console.log('error', error);
        renderToast(error.message, 'danger');
      },

    });
  }
};

export default closeTaskCheckboxChange;
