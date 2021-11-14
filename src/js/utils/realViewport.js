// Sets the real viewport height and width values into CSS Variables

const initViewPortHack = () => {
  const vh = window.innerHeight * 0.01;
  const vw = document.body.clientWidth * 0.01;

  document.documentElement.style.setProperty('--vh', `${vh}px`);
  document.documentElement.style.setProperty('--vw', `${vw}px`);
};

window.addEventListener('load', initViewPortHack);
window.addEventListener('resize', initViewPortHack);
