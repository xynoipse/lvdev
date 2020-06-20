import store from '@/store';
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';
import { isAuth, setAuth } from '@/utils/auth';
import handle from '@/utils/async-await';

const title = 'Lvdev';

/**
 * Global before guards
 *
 * @param {Route} to
 * @param {Route} from
 * @param {Function} next
 */
export async function beforeGuards(to, from, next) {
  NProgress.start();

  document.title = `${to.meta.title} - ${title}`;
  const auth = isAuth();

  if (auth) {
    setAuth(1);
    if (to.name === 'login') {
      next({ name: 'dashboard' });
    } else {
      const id = store.getters.id;
      if (id) {
        next();
      } else {
        const [err] = await handle(store.dispatch('auth/user'));
        if (err) {
          await handle(store.dispatch('auth/resetAuth'));
          next({ name: 'login' });
        };
        next();
      }
    }
  } else {
    if (to.name === 'login') {
      next();
    } else {
      localStorage.setItem('authRedirect', to.path);
      next({ name: 'login' });
    }
  }
};

/**
 * Global after hooks
 */
export function afterHooks() {
  NProgress.done();
};
