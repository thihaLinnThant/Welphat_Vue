<template>
    <v-row align="center" justify="center">
        <v-col cols="11">            
            <v-card raised shaped dense :dark=true>
                <v-card-text class="pb-0 pt-3">
                    <v-form class="d-flex" role="form" method="POST" action="/admin/categories/addcategory">
                        <input type="hidden" name="_token" :value="csrf_token">
                        <v-text-field :label=entryName color="#4054b5" name="name" dense required></v-text-field>
                        <v-btn class="mt-1 ml-5" outlined @click="submit" >ADD</v-btn>
                    </v-form>
                </v-card-text>
                
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
export default {
    props: [ 'entryName' ]
}
</script>

<style>

</style>