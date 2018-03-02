<template>
  <transition name="fade" mode="out-in">
    <div class="post">
      <h1 class="entry-title" v-if="isSingle">{{ item.title.rendered }}</h1>
      <h2 class="entry-title" v-else>
        <router-link :to="{ name: item.type, params: { slug: item.slug } }">
          {{ item.title.rendered }}
        </router-link>
      </h2>
      <div class="entry-content" v-if="isSingle" v-html="item.content.rendered"></div>
      <div class="entry-content" v-else v-html="item.excerpt.rendered"></div>
    </div>
  </transition>
</template>

<script>
export default {
  props: {
    post: {
      type: Object,
      default() {
        return {
          id: 0,
          slug: '',
          title: { rendered: '' },
          content: { rendered: '' },
          excerpt: { rendered: '' }
        }
      }
   }
  },
  data: () => ({
    isSingle: false,
    item: {}
  }),
  created() {
    this.item = this.post
  },
  methods: {
    getItem() {
      this.$http.get(wp.root + 'wp/v2/posts/?slug=' + this.$route.params.slug)
        .then(response => {
          this.item = response.data[0]
          this.$parent.$emit('page-title', this.item.title.rendered)
        })
        .catch( error => {
          console.log(error)
        })
    },
  },
  mounted() {
    // If post hasn't been passed by prop
    if (!this.post.id) {
      this.getItem()
      this.isSingle = true
    }
  }
}
</script>
<style lang="scss">
</style>
