// Functions for Form validation

const emailValid = email => {
  const emailRegex = /^([A-Za-z0-9_\-.])+@([A-Za-z0-9_\-.])+\.([A-Za-z]{2,10})$/;
  return emailRegex.test(email);
};

const phoneValid = phone => {
  const numberRegex = /[0-9]/;
  return numberRegex.test(phone);
};

export { emailValid, phoneValid };
