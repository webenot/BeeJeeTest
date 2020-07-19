const setInvalidFormControl = (element, errorMessage) => {
  element.closest('.form-group').find('.invalid-feedback').remove();
  element[0].setCustomValidity(errorMessage);
  element.closest('form').addClass('was-validated');
  element.closest('.form-group').append(`
    <div class="invalid-feedback">${errorMessage}</div>
  `);
};

export default setInvalidFormControl;
