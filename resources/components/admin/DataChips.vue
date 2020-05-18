<template>
    <v-row align="stratch" justify="start" class="ml-10 mr-0">
        <v-card v-for="(item, i) in items" :key=i color="#2a2a2a" raised dense class="ma-3">
            
            <v-card-title dense class="pr-0">
                {{ item.name }}
                <v-spacer></v-spacer>
                <v-btn icon>
                  <v-icon>mdi-pencil-box-multiple</v-icon>
                </v-btn>
                <v-btn icon>
                  <v-icon>mdi-close-circle</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-subtitle>No. of Books: (no.)</v-card-subtitle>
            <v-card-actions dense>
                
            </v-card-actions>
        </v-card>
    </v-row>
</template>

<script>
export default {
    props: ['items']
}
</script>

<style>

</style>