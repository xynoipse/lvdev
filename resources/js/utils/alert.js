import Swal from 'sweetalert2';

export function alert(options = {}) {
  hideLoading();
  return Swal.fire(options);
};

export function hideAlert() {
  const promise = Swal.close();
  setTimeout(() => this.hideLoading(), 1000);
  return promise;
}

export function showLoading() {
  return Swal.showLoading();
}

export function hideLoading() {
  return Swal.hideLoading();
}

export function alertSuccess(title, text, confirmButtonText = 'Yes', options) {
  return alert({
    title,
    text,
    icon: 'success',
    confirmButtonText,
    ...options
  });
}

export function alertError(title, text, confirmButtonText = 'Yes', options) {
  return alert({
    title,
    text,
    icon: 'error',
    confirmButtonText,
    ...options
  });
}

export function alertConfirm(title, text, confirmButtonText = 'Yes', cancelButtonText = "Cancel", options) {
  return alert({
    title,
    text,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText,
    cancelButtonText,
    ...options
  });
}

export function alertLoader(title, options) {
  alert({
    title,
    allowOutsideClick: false,
    ...options
  });
  return showLoading();
}

export function toast(position = 'top', timer = 5000) {
  hideLoading();
  return Swal.mixin({
    toast: true,
    position,
    showConfirmButton: false,
    timer,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });
}

export function toastSuccess(title, options = {}) {
  const { position, timer } = options;
  return toast(position, timer).fire({
    title,
    icon: 'success'
  });
}

export function toastError(title, options = {}) {
  const { position, timer } = options;
  return toast(position, timer).fire({
    title,
    icon: 'error'
  });
}

export function toastWarning(title, options = {}) {
  const { position, timer } = options;
  return toast(position, timer).fire({
    title,
    icon: 'warning'
  });
}

export function toastLoader(title, position) {
  toast(position).fire({ title });
  Swal.stopTimer();
  return showLoading();
}
