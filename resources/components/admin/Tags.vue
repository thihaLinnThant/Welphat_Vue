<template>
    <div>
        <entry-card entryName="Category Entry"></entry-card>
        <data-cards :items=tags></data-cards>
    </div>
</template>

<script>
import EntryCard from './EntryCard.vue';
import DataCards from './DataCards.vue';
export default {
    components: {
        EntryCard,
        DataCards
    },
    computed: {
        tags() {
            return this.$store.state.tags;
        }
    }
}
</script>

<style>

</style>