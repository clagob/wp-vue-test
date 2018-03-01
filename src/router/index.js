import Vue from 'vue'
import Router from 'vue-router'
import { capitalize } from '@/lib/text'

import HelloWorld from '@/components/HelloWorld'
import Cla from '@/components/Cla'

import Page from '@/components/Page'
import Posts from '@/components/Posts'
import Post from '@/components/Post'
import Deals from '@/components/Deals'
import Deal from '@/components/Deal'
import Error404 from '@/components/Error404'

Vue.use(Router)

let routes = []

// Home Page
routes.push({
  name: 'home',
  path: '/',
  redirect: { name: 'blog' }
})

// Blog
routes.push({
  name: 'blog',
  path: '/',
  component: Posts
})
routes.push({
  name: 'post',
  path: '/:slug',
  component: Post
})


// Deal list
routes.push({
  name: 'deals',
  path: '/deal/',
  component: Deals
})
routes.push({
  name: 'deal',
  path: '/deal/:slug',
  component: Deal
})

// TESTS
routes.push({
  name: 'cla',
  path: '/cla',
  component: Cla
})
routes.push({
  name: 'helloWorld',
  path: '/hello',
  component: HelloWorld
})

// Error
routes.push({
  path: '*',
  component: Error404
})

const router = new Router({
  mode: 'history',
  base: wp.base_path,
  routes: routes
})

// router.afterEach((to, from) => {
//   Zenscroll.toY(0, 0)
// })

// router.beforeEach((to, from, next) => {
//     document.title = to.meta.title
//     next()
// })

export default router
