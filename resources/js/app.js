import './bootstrap';
import { createApp } from 'vue';
import router from './router'
import store from './store'
import 'bootstrap/dist/css/bootstrap.css'
import '../css/custom.css'
import 'bootstrap/dist/js/bootstrap.js'
import App from './App.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';

library.add(fas);

createApp(App).component('font-awesome-icon', FontAwesomeIcon).use(router).use(store).mount('#app')
