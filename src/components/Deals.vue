<template>
  <transition name="fade" mode="out-in">
    <div class="container">
      <div class="deals">
        <Deal v-for="item in items" :key="item.id" :deal="item"></Deal>
      </div>
    </div>
  </transition>
</template>

<script>
import Deal from '@/components/Deal'

export default {
  data: () => ({
    items: []
  }),
  methods: {
    getItems() {
      this.$http.get(wp.root + 'wp/v2/deals')
        .then( response => {
          this.items = response.data
          this.$parent.$emit('page-title', 'Deals')
        })
        .catch( error => {
          console.log(error)
        })
    }
  },
  created() {
    this.getItems()
  },
  components: {
    Deal
  }
}
</script>

<style lang="scss">
</style>
