<template>
    <div>
        <entry-card entryName="Publisher Entry" act="/admin/publishers/addpublisher" statename="publishers" routename="publisher"></entry-card>
        <data-cards :items=publishers></data-cards>
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
        publishers() {
            return this.$store.state.publishers;
        }
    }
}
</script>

<style>

</style>