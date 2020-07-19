import $ from 'jquery';

const cancelTaskEditingBtnClick = e => {
  const curEl = $(e.currentTarget);
  curEl.closest('form').hide();
  curEl.closest('td').find('.editTask').show();
};

export default cancelTaskEditingBtnClick;
