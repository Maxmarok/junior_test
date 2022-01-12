import VueRouter from 'vue-router';
import { routes } from './routes';

export const router = new VueRouter({
  routes,
  mode: 'history'
});

export default router
