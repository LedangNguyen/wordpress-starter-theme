module.exports = {
  root: true,
  env: {
    browser: true,
    node: true,
    es2021: true,
  },
  parser: 'babel-eslint',
  parserOptions: {},
  extends: ['eslint:recommended', 'plugin:prettier/recommended', 'prettier'],
  rules: {},
};
