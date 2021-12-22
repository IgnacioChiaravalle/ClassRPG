require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('teacher-table', require('./components/TeacherTable.vue').default);
Vue.component('class-market-table', require('./components/ClassMarketTable.vue').default);
Vue.component('rpg-classes-table', require('./components/RPGClassesTable.vue').default);

const parentComponent = new Vue({
	el: '#parent-component'
});