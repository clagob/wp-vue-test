<template>
  <transition name="fade" mode="out-in">
    <nav :id="menu" class="GGG" :class="classes">
      <ul>
        <li v-for="item in items">
          <router-link :to="{ path: item.url.replace(domain, '') }" :target="item.target" :class="item.classes">{{item.title}}</router-link>
        </li>
      </ul>
    </nav>
  </transition>
</template>

<script>
export default {
  props: {
    menu: {
      type: String,
      default: 'nav_main'
    },
    inline: {
      type: Boolean,
      default: true
   },
   classes: {
     type: String,
     default: ''
   }
  },
  data: () => ({
    items: [],
    domain: wp.domain
  }),
  // created() {
  //   //this.item = this.post
  // },
  methods: {
    getItems() {
      this.$http.get(wp.root + 'wp-api-menus/v2/menu-locations/' + this.menu)
        .then(response => {
          this.items = response.data
        })
        .catch( error => {
          console.log('AppNav Error')
          console.log(error)
        })
    }
  },
  mounted() {
    this.getItems()
  }
}
</script>
<style lang="scss">
</style>
