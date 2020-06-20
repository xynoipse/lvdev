import Vue from 'vue';
import Router from 'vue-router';
import routes from './routes';
import { beforeGuards, afterHooks } from './guards';

Vue.use(Router);

const router = createRouter();

function createRouter() {
  const router = new Router({
    linkActiveClass: 'active',
    mode: 'history',
    routes
  });

  router.beforeEach(beforeGuards);
  router.afterEach(afterHooks);

  return router;
}

export default router;
