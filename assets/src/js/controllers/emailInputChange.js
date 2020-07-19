import $ from 'jquery';

import validateEmail from '../helpers/validateEmail';

import setInvalidFormControl from './setInvalidFormControl';
import setValidFormControl from './setValidFormControl';

const emailInputChange = e => {
  const curEl = $(e.currentTarget);
  const email = curEl.val();
  if (email === '') {
    setInvalidFormControl(curEl, 'This field cannot be empty');
  } else if (!validateEmail(email)) {
    setInvalidFormControl(curEl, 'Incorrect email');
  } else {
    setValidFormControl(curEl);
  }
};

export default emailInputChange;
