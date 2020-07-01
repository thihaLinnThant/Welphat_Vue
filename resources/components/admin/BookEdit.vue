<template>
  <div>
    <h1>Edit</h1>
    <p>{{editBooks}}</p>
  </div>
</template>
<script>
export default {
  computed: {
    editBooks() {
      return this.$store.state.editBookview;
    }
  }
};
</script>