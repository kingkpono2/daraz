(() => {
  'use strict';

  // Navigation remains lightweight and independent of the homepage gallery.
  const toggle = document.querySelector('.nav-toggle');
  const nav = document.querySelector('#site-navigation');
  if (toggle && nav) {
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
        setOpen(false);
        toggle.focus();
      }
    });
    document.addEventListener('click', event => {
      if (toggle.getAttribute('aria-expanded') === 'true' && !event.target.closest('#site-navigation, .nav-toggle')) setOpen(false);
    });
    window.addEventListener('resize', () => {
      if (!window.matchMedia('(max-width: 980px)').matches) setOpen(false);
    });
  }

  // Photo-only carousel: the existing 46/54 split layout and all shop
  // sections stay intact. It never modifies cart or checkout state.
  const slider = document.querySelector('[data-daraz-slider]');
  if (!slider) return;

  const slides = Array.from(slider.querySelectorAll('.hero-gallery-slide'));
  const dots = Array.from(slider.querySelectorAll('[data-slide-to]'));
  const previous = slider.querySelector('[data-slide-prev]');
  const next = slider.querySelector('[data-slide-next]');
  const counter = slider.querySelector('[data-slide-current]');
  const caption = slider.querySelector('.hero-gallery-caption');
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
  const delay = Math.max(4000, Number(slider.dataset.interval) || 6800);
  if (!slides.length) return;

  let activeIndex = 0;
  let timer = null;
  let hovering = false;
  let focused = false;
  let inViewport = true;
  let touchStartX = 0;
  let touchStartY = 0;

  function prime(index) {
    const slide = slides[(index + slides.length) % slides.length];
    if (!slide) return;
    const img = slide.querySelector('img');
    if (img) img.loading = 'eager';
  }

  function goTo(index, manual = false) {
    const nextIndex = ((index % slides.length) + slides.length) % slides.length;
    slides.forEach((slide, position) => {
      const current = position === nextIndex;
      slide.classList.toggle('is-active', current);
      slide.setAttribute('aria-hidden', String(!current));
    });
    dots.forEach((button, position) => {
      const current = position === nextIndex;
      button.classList.toggle('is-active', current);
      button.setAttribute('aria-pressed', String(current));
    });
    activeIndex = nextIndex;
    if (counter) counter.textContent = String(nextIndex + 1).padStart(2, '0');
    if (caption) caption.textContent = slides[nextIndex].dataset.slideCaption || '';
    prime(nextIndex + 1);
    if (manual) schedule();
  }

  function stop() {
    if (timer !== null) {
      window.clearTimeout(timer);
      timer = null;
    }
  }

  function shouldRun() {
    return slides.length > 1 && !prefersReducedMotion.matches &&
      !hovering && !focused && inViewport && !document.hidden;
  }

  function schedule() {
    stop();
    slider.classList.toggle('is-paused', !shouldRun());
    if (!shouldRun()) return;
    timer = window.setTimeout(() => {
      goTo(activeIndex + 1);
      schedule();
    }, delay);
  }

  previous?.addEventListener('click', () => goTo(activeIndex - 1, true));
  next?.addEventListener('click', () => goTo(activeIndex + 1, true));
  dots.forEach(button => button.addEventListener('click', () => {
    goTo(Number(button.dataset.slideTo), true);
  }));

  slider.addEventListener('mouseenter', () => { hovering = true; schedule(); });
  slider.addEventListener('mouseleave', () => { hovering = false; schedule(); });
  slider.addEventListener('focusin', () => { focused = true; schedule(); });
  slider.addEventListener('focusout', () => {
    window.setTimeout(() => {
      focused = slider.contains(document.activeElement);
      schedule();
    }, 0);
  });
  slider.addEventListener('keydown', event => {
    if (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') return;
    if (!event.target.closest('.hero-gallery-controls')) return;
    event.preventDefault();
    goTo(activeIndex + (event.key === 'ArrowRight' ? 1 : -1), true);
  });
  slider.addEventListener('touchstart', event => {
    if (event.touches.length !== 1) return;
    touchStartX = event.touches[0].clientX;
    touchStartY = event.touches[0].clientY;
  }, { passive: true });
  slider.addEventListener('touchend', event => {
    if (!event.changedTouches.length || !touchStartX) return;
    const dx = event.changedTouches[0].clientX - touchStartX;
    const dy = event.changedTouches[0].clientY - touchStartY;
    touchStartX = 0;
    touchStartY = 0;
    if (Math.abs(dx) >= 55 && Math.abs(dx) > Math.abs(dy) * 1.35) {
      goTo(activeIndex + (dx < 0 ? 1 : -1), true);
    }
  }, { passive: true });

  document.addEventListener('visibilitychange', schedule);
  if (prefersReducedMotion.addEventListener) {
    prefersReducedMotion.addEventListener('change', schedule);
  }
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(entries => {
      inViewport = entries[0] ? entries[0].isIntersecting : true;
      schedule();
    }, { threshold: 0.15 });
    observer.observe(slider);
  }

  // Prefetch only the next photograph; the first photo remains LCP-priority.
  prime(1);
  schedule();
})();
