/* /github/hrManagement/main.js */
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register(
      '/github/hrManagement/service-worker.js',
      { scope: '/github/hrManagement/' }
    ).then(reg =>
      console.log('SW registered:', reg.scope)
    ).catch(err =>
      console.error('SW registration failed:', err)
    );
  });
}
