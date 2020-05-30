<template>
  <div>
    <entry-card entryName="Category Entry"></entry-card>
    <data-cards :items="categories"></data-cards>
    <p>{{categories}}</p>
  </div>
</template>

<script>
import EntryCard from "./EntryCard.vue";
import DataCards from "./DataCards.vue";
export default {
  components: {
    EntryCard,
    DataCards
  },
  computed: {
    categories() {
      return this.$store.state.categories;
    }
  }
};
</script>

<style>
</style>
