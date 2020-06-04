<template>
<div>
  <v-alert
    v-model="alert"
    border="left"
    close-text="Close Alert"
    color="deep-purple accent-4"
    dark
    transition="scroll-y-transition"
    dismissible
  >Category registered</v-alert>
    <div>
      <v-card>
        <v-card-title>
          Categories
          <v-spacer></v-spacer>
          <v-form class="d-flex" @submit.prevent="submit" >
            <input type="hidden" name="_token" :value="csrf_token"/>
            <v-text-field
              append-icon="mdi-plus"
              label="Add new"
              single-line              
              :error=goterror
              :error-messages=errors.name              
              color="#4054b5"
              v-model="fields.name"
              name="name"
              required
            ></v-text-field>
          </v-form>
          <v-spacer></v-spacer>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
          
        </v-card-title>
        <v-data-table :headers="headers" :items="categories" :search="search">
          <template v-slot:body="{ items }">
            <tbody v-for="(category,index) in items" :key="index">
              <tr>
                <td>{{category.id}}</td>
                <td>{{category.name}}</td>
                <td>{{category.count}}</td>                
                <td class="d-flex flex-row">
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn class="mt-1" text icon v-on="on">
                        <v-icon>mdi-eye</v-icon>
                      </v-btn>
                    </template>
                    <span>view books</span>
                  </v-tooltip>
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn class="mt-1" text icon v-on="on">
                        <v-icon>mdi-delete</v-icon>
                      </v-btn>
                    </template>
                    <span>delete category</span>
                  </v-tooltip>
                </td>
              </tr>
            </tbody>
          </template>
        </v-data-table>
      </v-card>
    </div>
  </div>
</template>

<script>
import InputMixin from '../../js/RecordInputmixin';
export default {
  mixins: [InputMixin],
  data() {
    return {
      search: "",
      headers: [
        {
          text: "Id",
          align: "start",
          value: "id"
        },
        { text: "Name", value: "name" },
        { text: "Book Count", value: "count" },
        { text: "Actions", value: "actions" }
      ],
      act: "/admin/categories/addcategory",
      statename: "categories",
      routename: "category"
    }
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
