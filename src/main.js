import Vue from 'vue'
import App from './App.vue'
import router from './router'
import VuePaginate from "vue-paginate";

Vue.config.productionTip = false

Vue.use(VuePaginate);

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
