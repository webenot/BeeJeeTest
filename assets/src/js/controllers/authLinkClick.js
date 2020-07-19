import $ from 'jquery';
import renderToast from '../views/renderToast';

const authLinkClick = e => {
  const curEl = $(e.currentTarget);
  if (curEl.text() === 'Login') return;
  if (curEl.text() === 'Logout') {
    e.stopPropagation();
    e.preventDefault();
    $.ajax({
      url: `${window.location.origin}/ajax.php`,
      method: 'POST',
      dataType: 'json',
      data: {
        action: 'logout',
        checkSecurity: '',
        referer: window.location.href,
      },
      success: data => {
        if (process.env.NODE_ENV === 'development') console.log('logout', data);
        if (data.message) {
          $('.auth-link').text('Login');
          renderToast(data.message);
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        }
      },
      error: error => {
        if (process.env.NODE_ENV === 'development') console.log('error', error);
        renderToast(error.message, 'danger');
      },
    });
  }
};

export default authLinkClick;
