<template>
<div>
    <entry-card entryName="Category Entry"></entry-card>
    <data-chips :items=categories></data-chips>
</div>
</template>

<script>
import EntryCard from './EntryCard.vue';
import DataChips from './DataChips.vue';
export default {
    components: {
        EntryCard,
        DataChips
    },
    computed: {
        categories() {
            return this.$store.state.categories;
        }
    }
}
</script>

<style>

</style>