<template>
    <v-row align="center" justify="center">
        <v-col cols="11">            
            <v-card raised shaped dense :dark=true>
                <v-card-text class="pb-0 pt-3">
                    <v-form class="d-flex" @submit.prevent="submit" >
                        <input type="hidden" name="_token" :value="csrf_token"/>
                        <v-text-field :error=goterror :error-messages=errors.name :label=entryName color="#4054b5" v-model="fields.name" name="name" dense required></v-text-field>
                        <v-btn class="mt-1 ml-5" outlined type="submit" >ADD</v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
import InputMixin from '../../js/RecordInputmixin';

export default {
    props: [ 'entryName', 'act', 'statename', 'routename' ],
    mixins: [InputMixin]
}
</script>

<style>

</style>