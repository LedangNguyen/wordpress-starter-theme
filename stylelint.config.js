module.exports = {
  plugins: ['stylelint-scss'],
  extends: ['stylelint-config-standard', 'stylelint-config-prettier'],
  rules: {
    'color-hex-case': 'lower',
    'at-rule-no-unknown': null,
    'scss/at-rule-no-unknown': true,
    'font-family-no-missing-generic-family-keyword': null,
  },
};
