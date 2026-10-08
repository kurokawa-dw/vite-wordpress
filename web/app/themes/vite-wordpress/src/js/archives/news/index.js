import '@scss/archives/news/index.scss';

const revealTargets = document.querySelectorAll('[data-news-reveal]');
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (!prefersReducedMotion && 'IntersectionObserver' in window) {
  document.documentElement.classList.add('news-reveal-enabled');

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
    { rootMargin: '0px 0px -6%', threshold: 0.08 },
  );

  revealTargets.forEach((target, index) => {
    target.style.setProperty('--news-reveal-delay', `${Math.min(index, 5) * 55}ms`);
    revealObserver.observe(target);
  });
}
