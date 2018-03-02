<template>
  <transition appear name="fade">
    <div id="app">
      <app-header></app-header>
      <router-view/>
      <app-footer></app-footer>
    </div>
  </transition>
</template>

<script>
import AppHeader from '@/components/AppHeader.vue'
import AppFooter from '@/components/AppFooter.vue'

export default {
  name: 'App',
  components: {
    AppHeader,
    AppFooter
  },
  methods: {
    updateTitle(pageTitle) {
      document.title = (pageTitle ? pageTitle + ' - ' : '') + wp.site_name
    },
    removeSeoContent() {
      var seoEl = document.getElementById('seo-content')
      seoEl.setAttribute('style', 'display:none')
      //seoEl.parentNode.removeChild(seoEl)
    }
  },
  created: function () {
    this.$on('page-title', this.updateTitle)
  },
  // It's good to clean up event listeners before
  // a component is destroyed.
  beforeDestroy: function () {
    this.$off('page-title', this.updateTitle)
  },
  events: {
    'page-title': function(pageTitle) {
      this.updateTitle(pageTitle);
    }
  },
  mounted() {
    this.updateTitle('')
    this.removeSeoContent()
  }
}
</script>

<style lang="scss">
// Vue - Transaction
.fade-enter-active,
.fade-leave-active {
  transition: opacity .4s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
#seo-content{
  opacity: 0;
}
</style>
