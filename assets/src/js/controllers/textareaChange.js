import $ from 'jquery';

import setInvalidFormControl from './setInvalidFormControl';
import setValidFormControl from './setValidFormControl';

const textareaChange = e => {
  const curEl = $(e.currentTarget);
  const text = curEl.val();
  if (text === '') {
    setInvalidFormControl(curEl, 'This field cannot be empty');
  } else {
    setValidFormControl(curEl);
  }
};

export default textareaChange;
