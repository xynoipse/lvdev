import Cookies from 'js-cookie';

const key = 'isAuth';

export function isAuth() {
  return Cookies.get(key) === '1';
}

export function setAuth(isAuth) {
  return Cookies.set(key, isAuth, { expires: 1 / 12 });
}

export function removeAuth() {
  return Cookies.remove(key);
}
