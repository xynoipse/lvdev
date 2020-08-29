import Cookies from 'js-cookie';

const key = 'isAuth';

export function isAuth() {
  return Cookies.get(key) === '1';
}

export function setAuth(isAuth) {
  const sessionLifetime = process.env.MIX_SESSION_LIFETIME || 120;

  return Cookies.set(key, isAuth, {
    expires: sessionLifetime / 1440
  });
}

export function removeAuth() {
  return Cookies.remove(key);
}
