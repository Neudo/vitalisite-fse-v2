/**
 * Vitalisite Contact Form — AJAX submission.
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('.vitalisite-contact-form');
    forms.forEach(initForm);
  });

  function initForm(form) {
    const submitBtn = form.querySelector('button[type="submit"]');
    const feedback = form.querySelector('.vitalisite-contact-form__feedback');
    const btnText = submitBtn ? submitBtn.textContent : '';

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      // Clear previous errors.
      clearErrors(form);

      // Disable button.
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Envoi en cours…';
      }

      const formData = new FormData(form);
      formData.append('action', 'vitalisite_contact');

      fetch(vitalisiteContact.ajaxUrl, {
        method: 'POST',
        body: formData,
        credentials: 'same-origin',
      })
        .then(function (response) {
          return response.json();
        })
        .then(function (result) {
          if (result.success) {
            showFeedback(feedback, result.data.message, 'success');
            form.reset();
          } else {
            showFeedback(feedback, result.data.message, 'error');
            if (result.data.fields) {
              showFieldErrors(form, result.data.fields);
            }
          }
        })
        .catch(function () {
          showFeedback(
            feedback,
            'Une erreur est survenue. Veuillez réessayer.',
            'error'
          );
        })
        .finally(function () {
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = btnText;
          }
        });
    });
  }

  function showFeedback(el, message, type) {
    if (!el) return;
    el.textContent = message;
    el.className = 'vitalisite-contact-form__feedback vitalisite-contact-form__feedback--' + type;
    el.removeAttribute('hidden');
    el.setAttribute('role', 'alert');
  }

  function clearErrors(form) {
    // Clear field errors.
    form.querySelectorAll('.vitalisite-contact-form__error').forEach(function (el) {
      el.textContent = '';
      el.setAttribute('hidden', '');
    });
    // Clear global feedback.
    var feedback = form.querySelector('.vitalisite-contact-form__feedback');
    if (feedback) {
      feedback.textContent = '';
      feedback.setAttribute('hidden', '');
      feedback.removeAttribute('role');
    }
    // Remove error state from fields.
    form.querySelectorAll('.vitalisite-contact-form__field--error').forEach(function (el) {
      el.classList.remove('vitalisite-contact-form__field--error');
    });
  }

  function showFieldErrors(form, fields) {
    Object.keys(fields).forEach(function (name) {
      var input = form.querySelector('[name="' + name + '"]');
      if (!input) return;
      var wrapper = input.closest('.vitalisite-contact-form__field');
      if (wrapper) {
        wrapper.classList.add('vitalisite-contact-form__field--error');
      }
      var errorEl = wrapper
        ? wrapper.querySelector('.vitalisite-contact-form__error')
        : null;
      if (errorEl) {
        errorEl.textContent = fields[name];
        errorEl.removeAttribute('hidden');
      }
    });
  }
})();
