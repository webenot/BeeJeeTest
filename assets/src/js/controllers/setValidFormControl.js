const setValidFormControl = element => {
  element.closest('.form-group').find('.invalid-feedback').remove();
  element[0].setCustomValidity('');
};

export default setValidFormControl;
