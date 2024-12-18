import Vue from 'vue';
import Router from 'vue-router';

import FacultyHome from '../components/Faculty/Home.vue'
import StudentHome from '../components/Student/Home.vue'
Vue.use(Router);

const routes = [
    {
        path: '/faculty',
        component: FacultyHome,
    },
    {
        path: '/students',
        component: StudentHome,
    },
];

export default new Router({
  mode: 'history',
  routes
});