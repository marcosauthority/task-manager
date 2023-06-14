import { createRouter, createWebHistory } from 'vue-router'
import store from './store'
import Login from './components/Login.vue'
import Home from './components/Home.vue'
import Tasks from './components/Tasks.vue'
import Categories from './components/Categories.vue'

const routes = [
  {
    path: '/',
    redirect: '/login',
  },
  {
    path: '/login',
    component: Login,
  },
  {
    path: '/logout',
    name: 'Logout',
    meta: {
      requiresAuth: true,
    },
    beforeEnter: (to, from, next) => {
      store.dispatch('logout');
      next('/login');
    },
  },
  {
    path: '/home',
    component: Home,
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/tasks',
    component: Tasks,
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/categories',
    component: Categories,
    meta: {
      requiresAuth: true,
    },
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, from, next) => {
    if (to.path === '/login') {
      if (store.getters.token) {
        next('/home');
      } else {
        next();
      }
    } else {
      if (to.meta.requiresAuth && !store.getters.token) {
        next('/login');
      } else {
        next();
      }
    }
  });

export default router
