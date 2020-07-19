import $ from 'jquery';

import setInvalidFormControl from './setInvalidFormControl';

const validateForm = form => {
  const invalidField = form.find('.form-control:invalid');
  if (invalidField.length) {
    for (let i = 0, length = invalidField.length; i < length; i++) {
      const item = invalidField[i];
      if (!item.value)
        setInvalidFormControl($(item), 'This field cannot be empty');
      else
        setInvalidFormControl($(item), 'Incorrect data');
    }
    return false;
  }
  return true;
};

export default validateForm;
