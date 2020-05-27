<template>
    <v-row align="stratch" justify="start" class="ml-10 mr-0 data-cards">
        <v-card v-for="(item, i) in items" :key=i :dark=true raised dense class="ma-3">

            <slot></slot> <!-- for card-image -->

            <v-card-title dense class="pr-0 pt-1">
                {{ item.name }}
                <v-spacer></v-spacer>
                <v-btn icon>
                  <v-icon>mdi-pencil-box-multiple</v-icon>
                </v-btn>
                <v-btn icon>
                  <v-icon>mdi-close-circle</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-subtitle class="pb-1">No. of Books: {{item.count}}</v-card-subtitle>
        </v-card>
    </v-row>
</template>

<script>
export default {
    props: ['items']
}
</script>

<style>
.data-cards {
    transition: ease-in-out 0.5s;
}
</style>