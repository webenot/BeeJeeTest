import $ from 'jquery';
import setInvalidFormControl from './setInvalidFormControl';
import setValidFormControl from './setValidFormControl';

const passwordInputChange = e => {
  const curEl = $(e.currentTarget);
  const password = curEl.val();
  if (password.length < 3) {
    setInvalidFormControl(curEl, 'Password is incorrect');
  } else if (password.match('<script>')) {
    setInvalidFormControl(curEl, 'This field contains unacceptable characters');
  } else {
    setValidFormControl(curEl);
  }
};

export default passwordInputChange;
