<template>
<div>
    <v-dialog
    v-model="editDialog"
    max-width="350"
    persistent
  >
  <v-card>
    <v-card-title primary-title>
      Edit Tag title
    </v-card-title>
    <v-card-text>
      <v-text-field
        :error-messages=errors.edit_name
        name="edit_name"
        v-model="fields.edit_name"
        label="tag name"
      ></v-text-field>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn
        text
        @click="editDialog = false; target_item = '';"
      >
        Cancel
      </v-btn>
      <v-btn
        text
        @click="submitEdit()"
        color="primary" outlined
      >
        Save
      </v-btn>
    </v-card-actions>
  </v-card>
  <v-snackbar v-model="alert" :color="alertType">
      {{alertMessage}}
      <v-btn text @click="alert = false">Close</v-btn>
  </v-snackbar>
  </v-dialog>

  <v-dialog
    v-model="deleteDialog"
    max-width="350"
    persistent
  >
    <v-card>
      <v-card-text>
        Do you want to delete this tag?
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          text
          @click="deleteDialog = false; target_item = '';"
          color="primary" outlined
        >
          No
        </v-btn>

        <v-btn
          text
          @click="deleteDialog = false; submitDelete();"
        >
          Yes
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
    <div>
      <v-card>
        <v-card-title>
          Tags
          <v-spacer></v-spacer>
          <v-form class="d-flex" @submit.prevent="submitCreate">
            <v-text-field
              append-icon="mdi-plus"
              label="Add new"
              single-line
              hide-details
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
                      <v-btn
                        @click="editDialog = true;
                        target_item = tag;
                        fields.edit_name = tag.name"
                        class="mt-1" text icon v-on="on">
                        <v-icon>mdi-pencil</v-icon>
                      </v-btn>
                    </template>
                    <span>edit</span>
                  </v-tooltip>
                  <router-link :to="{ name: 'tagview', params: { id: tag.id }}" style="text-decoration:none">
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn class="mt-1" text icon v-on="on">
                        <v-icon>mdi-eye</v-icon>
                      </v-btn>
                    </template>
                    <span>view</span>
                  </v-tooltip>
                  </router-link>
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn @click="deleteDialog = true; target_item = tag" class="mt-1" text icon v-on="on">
                        <v-icon>mdi-delete</v-icon>
                      </v-btn>
                    </template>
                    <span>Delete tag</span>
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
import CrudHandler from "../../js/CRUDHandler";
export default {
  mixins: [CrudHandler],
  data() {
    return {
      csrf_token: window.csrf_token,
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
      editDialog: false,
      deleteDialog: false,
      target_item: '',
      cascade: null,
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
