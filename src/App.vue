<template>
  <div id="app-body">
    <app-header></app-header>
    <router-view/>
    <app-footer></app-footer>
  </div>
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
  ready() {
    this.updateTitle(wp.site_name);
  },
  methods: {
    updateTitle(pageTitle) {
      document.title = (pageTitle ? pageTitle + ' - ' : '') + wp.site_name;
    }
  },
  events: {
    'page-title': function(pageTitle) {
      this.updateTitle(pageTitle);
    }
  }
}
</script>

<style lang="scss">

</style>
