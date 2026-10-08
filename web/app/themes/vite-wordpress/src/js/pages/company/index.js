import '@scss/pages/company/index.scss';

const revealTargets = document.querySelectorAll('[data-company-reveal]');

if ('IntersectionObserver' in window) {
  document.documentElement.classList.add('company-reveal-enabled');

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
    { rootMargin: '0px 0px -10%', threshold: 0.1 },
  );

  revealTargets.forEach((target) => revealObserver.observe(target));
}

const counters = document.querySelectorAll('[data-company-count]');
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

function animateCounter(element) {
  const target = Number(element.dataset.companyCount);

  if (!Number.isFinite(target)) {
    return;
  }

  const isYear = target >= 1900 && target <= 2100;
  const start = isYear ? target - 12 : 0;
  const duration = 1200;
  const startedAt = performance.now();

  function update(now) {
    const progress = Math.min((now - startedAt) / duration, 1);
    const easedProgress = 1 - (1 - progress) ** 3;
    const current = Math.round(start + (target - start) * easedProgress);

    element.textContent = isYear ? String(current) : current.toLocaleString('ja-JP');

    if (progress < 1) {
      requestAnimationFrame(update);
    }
  }

  requestAnimationFrame(update);
}

if (!prefersReducedMotion && 'IntersectionObserver' in window) {
  const counterObserver = new IntersectionObserver(
    (entries, observer) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) {
          return;
        }

        animateCounter(entry.target);
        observer.unobserve(entry.target);
      });
    },
    { threshold: 0.5 },
  );

  counters.forEach((counter) => counterObserver.observe(counter));
}
