import $ from 'jquery';
import setInvalidFormControl from './setInvalidFormControl';
import setValidFormControl from './setValidFormControl';

const loginInputChange = e => {
  const curEl = $(e.currentTarget);
  const userName = curEl.val();
  if (userName.match(/\W/i) && !userName.match(/@/i)) {
    setInvalidFormControl(curEl, 'This field contains unacceptable characters');
  } else {
    setValidFormControl(curEl);
  }
};

export default loginInputChange;
