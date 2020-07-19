const validateEmail = email => {
  const pattern  = new RegExp(
    '^(([^<>()\\[\\]\\.,;:\\s@\\"]+(\\.[^<>()\\[\\]\\.,;:\\s@\\"]+)*)|(\\".+\\"))' +
    '@(([^<>()[\\]\\.,;:\\s@\\"]+\\.)+[^<>()[\\]\\.,;:\\s@\\"]{2,})$',
    'i'
  );
  return pattern.test(email);
};

export default validateEmail;
