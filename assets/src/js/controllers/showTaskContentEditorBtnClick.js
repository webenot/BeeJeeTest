import $ from 'jquery';

const showTaskContentEditorBtnClick = e => {
  const curEl = $(e.currentTarget);
  curEl.closest('td').find('form').show();
  curEl.hide();
  return false;
};

export default showTaskContentEditorBtnClick;
