<template>
  <div>
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

                  <v-btn class="mt-1">view book</v-btn>
                  <v-btn class="mt-1 ml-2">delete</v-btn>

              </td>
            </tr>
          </tbody>
        </template>
      </v-data-table>
    </v-card>
  </div>
</template>
<script>
export default {
  data() {
    return {
      dialog: false,
      search: "",
      formTitle: "Edit",
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
      comments: this.$store.state.comments
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
