import '@scss/archives/products/index.scss';

const revealTargets = document.querySelectorAll('[data-products-reveal]');
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (!prefersReducedMotion && 'IntersectionObserver' in window) {
  document.documentElement.classList.add('products-reveal-enabled');

  const revealObserver = new IntersectionObserver(
    (entries, observer) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) {
          return;
        }

        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      });
    },
    { rootMargin: '0px 0px -8%', threshold: 0.08 },
  );

  revealTargets.forEach((target, index) => {
    target.style.setProperty('--products-reveal-delay', `${Math.min(index % 3, 2) * 90}ms`);
    revealObserver.observe(target);
  });
}
