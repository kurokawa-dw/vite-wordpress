import '../scss/main.scss';

const demoButton = document.querySelector('[data-demo-button]');
const demoMessage = document.querySelector('[data-demo-message]');

if (demoButton && demoMessage) {
  demoButton.addEventListener('click', () => {
    const now = new Intl.DateTimeFormat('ja-JP', {
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
    }).format(new Date());

    demoMessage.textContent = `${now} — JavaScriptもVite経由で動いています。`;
    demoButton.classList.toggle('is-active');
  });
}

if (import.meta.hot) {
  console.info('Vite HMR is connected.');
}

console.log('wordpress startだよ');
