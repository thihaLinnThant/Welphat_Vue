<template>
  <div>
    <v-dialog
      v-model="deleteDialog"
      max-width="350"
      persistent
    >
      <v-card>
        <v-card-text>
          Do you want to delete this category?
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            text
            @click="deleteDialog = false; target_item_id = '';"
            color="primary" outlined
          >
            No
          </v-btn>

          <v-btn
            text
            @click="deleteDialog = false; submitDelete(target_item_id);"
          >
            Yes
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-card>
      <v-card-title>
        Comments
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table :headers="headers" :items="comments" :search="search">
        <template v-slot:body="{ items }">
          <tbody v-for="(comment,index) in items" :key="index">
            <tr>
              <td>{{comment.id}}</td>
              <td>{{comment.user.name}}</td>
              <td>{{comment.book.name}}</td>
              <td>{{comment.comment_text}}</td>
              <td class="d-flex flex-row">
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-btn class="mt-1" text icon v-on="on">
                      <v-icon>mdi-eye</v-icon>
                    </v-btn>
                  </template>
                  <span>view book</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-btn @click="deleteDialog = true; target_item_id = comment.id" class="mt-1" text icon v-on="on">
                      <v-icon>mdi-delete</v-icon>
                    </v-btn>
                  </template>
                  <span>delete comment</span>
                </v-tooltip>
              </td>
            </tr>
          </tbody>
        </template>
      </v-data-table>
    </v-card>
  </div>
</template>
<script>
import DeleteMixin from '../../js/deleteForm';
export default {
  mixins: [ DeleteMixin ],
  data() {
    return {
      search: "",
      headers: [
        {
          text: "Id",
          align: "start",
          value: "id"
        },
        { text: "User Name", value: "user_id" },
        { text: "Book Name", value: "book_id" },
        { text: "Comment", value: "comment_text" },
        { text: "Actions", value: "actions" }
      ],
      comments: this.$store.state.comments,
      deleteDialog: false,
      statename: "comments",
      target_item_id: '',
    };
  }
};
</script>

<style>
td,
.v-data-table__mobile-row {
  color: white;
}
</style>
