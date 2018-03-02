<template>
  <transition name="fade" mode="out-in">
    <div class="container">
      <div class="posts">
        <Post v-for="item in items" :key="item.id" :post="item"></Post>
      </div>
    </div>
  </transition>
</template>

<script>
import Post from '@/components/Post'

export default {
  data: () => ({
    items: []
  }),
  methods: {
    getItems() {
      this.$http.get(wp.root + 'wp/v2/posts')
        .then( response => {
          this.items = response.data
          this.$parent.$emit('page-title', 'Posts')
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
    Post
  }
}
</script>

<style lang="scss">
</style>
