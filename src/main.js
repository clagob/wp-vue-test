// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'

//Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
})


// import Vue from 'vue'
// import VueRouter from 'vue-router'
// import App from 'component/App.vue'
// 
// import { store } from 'store/store'
// import { routes } from 'router/routes'
//
// Vue.use(VueRouter)
//
// const router = new VueRouter({
//     routes,
//     mode: 'history'
// })
//
// router.beforeEach((to, from, next) => {
//     document.title = to.meta.title
//     next()
// })
//
// new Vue({
//     el: '#app',
//     store,
//     router,
//     render: h => h(App)
// })
