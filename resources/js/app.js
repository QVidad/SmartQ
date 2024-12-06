import 'bootstrap-icons/font/bootstrap-icons.css';

require('./bootstrap');

import Vue from 'vue'

Vue.component('loginmodal', require('./components/LoginModal.vue').default);
Vue.component('registermodal', require('./components/RegisterModal.vue').default);
Vue.component('navbar', require('./components/NavBar.vue').default);
Vue.component('secondnavbar', require('./components/SecondNavBar.vue').default);
Vue.component('contentcard', require('./components/ContentCard.vue').default);
Vue.component('examscard', require('./components/ExamsCard.vue').default);
Vue.component('allexams', require('./components/AllExams.vue').default);
Vue.component('takeexam', require('./components/TakeExam.vue').default);
Vue.component('progressbar', require('./components/ProgressBar.vue').default);
Vue.component('timer', require('./components/Timer.vue').default);
Vue.component('timesup', require('./components/TimesUp.vue').default);
Vue.component('navigationbutton', require('./components/NavigationButton.vue').default);
Vue.component('navigationmodal', require('./components/NavigationModal.vue').default);
Vue.component('examcontent', require('./components/ExamContent.vue').default);
Vue.component('areyousuremodal', require('./components/AreYouSureModal.vue').default);
Vue.component('showscore', require('./components/ShowScore.vue').default);


Vue.component('facultynavbar', require('./components/Faculty/FacultyNavbar.vue').default);
Vue.component('facultycontentcard', require('./components/Faculty/ContentCard.vue').default);
Vue.component('faculty-examination', require('./components/Faculty/Examination.vue').default);
Vue.component('create-examination', require('./components/Faculty/CreateExam.vue').default);
Vue.component('configure-examination', require('./components/Faculty/ConfigureExam.vue').default);
Vue.component('exam-report', require('./components/Faculty/ExamReport.vue').default);
Vue.component('dashboard', require('./components/Faculty/Dashboard.vue').default);
Vue.component('faculty-students', require('./components/Faculty/Students.vue').default);
// Vue.component('submitbutton', require('./components/SubmitButton.vue').default);

const app = new Vue({
    el: '#app'
});

