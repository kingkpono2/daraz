(() => {
  'use strict';
  const toggle = document.querySelector('.nav-toggle');
  const nav = document.querySelector('#site-navigation');
  if (!toggle || !nav) return;
  const setOpen = open => {
    toggle.setAttribute('aria-expanded', String(open));
    toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
    nav.classList.toggle('is-open', open);
  };
  toggle.addEventListener('click', () => setOpen(toggle.getAttribute('aria-expanded') !== 'true'));
  nav.addEventListener('click', event => {
    if (event.target.closest('a') && window.matchMedia('(max-width: 980px)').matches) setOpen(false);
  });
  document.addEventListener('keydown', event => {
    if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
      setOpen(false); toggle.focus();
    }
  });
  document.addEventListener('click', event => {
    if (toggle.getAttribute('aria-expanded') === 'true' && !event.target.closest('#site-navigation, .nav-toggle')) setOpen(false);
  });
  window.addEventListener('resize', () => {
    if (!window.matchMedia('(max-width: 980px)').matches) setOpen(false);
  });
})();
