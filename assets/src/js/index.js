import $ from 'jquery';
import 'bootstrap/dist/js/bootstrap.bundle';

import loginFormSubmit from './controllers/loginFormSubmit';
import addNewTaskFormSubmit from './controllers/addNewTaskFormSubmit';
import loginInputChange from './controllers/loginInputChange';
import passwordInputChange from './controllers/passwordInputChange';
import emailInputChange from './controllers/emailInputChange';
import textInputChange from './controllers/textInputChange';
import textareaChange from './controllers/textareaChange';
import authLinkClick from './controllers/authLinkClick';
import showTaskContentEditorBtnClick from './controllers/showTaskContentEditorBtnClick';
import cancelTaskEditingBtnClick from './controllers/cancelTaskEditingBtnClick';
import updateTaskContentSubmit from './controllers/updateTaskContentSubmit';
import closeTaskCheckboxChange from './controllers/closeTaskCheckboxChange';

$(document).ready(() => {
  $('[name="login"]').change(loginInputChange);
  $('[name="password"]').change(passwordInputChange);
  $('[name="email"]').change(emailInputChange);
  $('[name="name"]').change(textInputChange);
  $('[name="content"]').change(textareaChange);
  $('.loginForm').submit(loginFormSubmit);
  $('.addNewTaskForm').submit(addNewTaskFormSubmit);
  $('.auth-link').click(authLinkClick);

  $('.editTask').click(showTaskContentEditorBtnClick);
  $('.cancelTaskEditing').click(cancelTaskEditingBtnClick);

  $('.editTaskForm').submit(updateTaskContentSubmit);

  $('.closeTask').change(closeTaskCheckboxChange);
});
