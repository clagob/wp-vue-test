<template>
  <header class="navbar navbar-light">
    <div class="container container-fluid-md-down">
      <router-link :to="{ name: 'home' }" class="navbar-brand">
        <img class="d-inline-block align-top" src="../assets/img/logo.svg" height="40" alt="Logo">
      </router-link>
      <span class="navbar-text">

      </span>
      <app-nav menu="nav_main" :inline="true" classes="test-claudio"></app-nav>
    </div>
  </header>
</template>

<script>
import AppNav from '@/components/AppNav.vue'

export default {
  components: {
    AppNav
  }
}

</script>
