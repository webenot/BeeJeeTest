import $ from 'jquery';

const renderToast = (message, type = 'success') => {
  $('body').append(`
    <div
      class="toast"
      role="alert"
      aria-live="polite"
      aria-atomic="true"
      data-delay="3000"
    >
      <div role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-${type}">
          ${message}
        </div>
      </div>
    </div>
  `);
  const toast = $('.toast');
  toast.toast('show');
  setTimeout(() => {
    toast.remove();
  }, 3500);
};

export default renderToast;
