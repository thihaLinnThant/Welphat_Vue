<template>
<div>
      <v-snackbar v-model="alert" color="success">
      Tag <b> {{lastRecord}} </b> registered!
      <v-btn color="error" text @click="alert = false">Close</v-btn>
    </v-snackbar>
    <div>
      <v-card>
        <v-card-title>
          Tags
          <v-spacer></v-spacer>
          <v-form class="d-flex" @submit.prevent="submit" >
            <v-text-field
              append-icon="mdi-plus"
              label="Add new"
              single-line
              hide-details
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
        <v-data-table :headers="headers" :items="tags" :search="search">
          <template v-slot:body="{ items }">
            <tbody v-for="(tag,index) in items" :key="index">
              <tr>
                <td>{{tag.id}}</td>
                <td>{{tag.name}}</td>
                <td>{{tag.count}}</td>
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
                    <span>delete tag</span>
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
import LastRecordMixin from '../../js/lastRecordmixin';
export default {
  mixins: [InputMixin,LastRecordMixin],
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
      act: "/admin/tags/addtag",
      statename: "tags",
    }
  },
  computed: {
    tags() {
      return this.$store.state.tags;
    }
  }
};
</script>

<style>
</style>
