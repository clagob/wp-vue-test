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



// Posts - Blog
routes.push({
  name: 'blog',
  path: '/',
  component: Posts
})
// Post
routes.push({
  name: 'post',
  path: '/blog/:slug',
  component: Post
})
// Taxonomy: Category
// routes.push({
//   name: 'category',
//   path: '/category/:term',
//   component: Posts
// })
// // Taxonomy: Tag
// routes.push({
//   name: 'tag',
//   path: '/tag/:term',
//   component: Posts
// })
// Author
// routes.push({
//   name: 'author',
//   path: '/author/:user',
//   component: Posts
// })

// Post type DEAL
routes.push({
  name: 'deals',
  path: '/deal',
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



// Pages
routes.push({
  name: 'page',
  path: '/page/:slug',
  component: Page
})


// Error 404: page not found
routes.push({
  name: 'error',
  path: '*',
  component: Error404
})


// Set ROUTER
const router = new Router({
  mode: 'history',
  base: wp.basePath,
  linkActiveClass: 'open active',
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
