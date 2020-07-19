import $ from 'jquery';

import setInvalidFormControl from './setInvalidFormControl';
import setValidFormControl from './setValidFormControl';

const textInputChange = e => {
  const curEl = $(e.currentTarget);
  const text = curEl.val();
  if (text === '') {
    setInvalidFormControl(curEl, 'This field cannot be empty');
  } else if (text.length > 255) {
    curEl.val(text.substr(0, 255));
  } else {
    setValidFormControl(curEl);
  }
};

export default textInputChange;
