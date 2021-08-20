require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('teacher-table', require('./components/TeacherTable.vue').default);

const parentComponent = new Vue({
    el: '#parent-component'
});
