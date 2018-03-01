<template>
  <div class="container">
    <div class="deals">
      <Deal v-for="item in items" :key="item.id" :item="item"></Deal>
    </div>
  </div>
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
  mounted() {
    this.getItems()
  },
  components: {
    Deal
  }
}
</script>

<style lang="scss">
</style>
