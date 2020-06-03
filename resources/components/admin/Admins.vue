<template>
  <div>
    <v-card>
      <v-card-title>
        Admins
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table :headers="headers" :items="admins" :search="search">
        <template v-slot:body="{ items }">
          <tbody v-for="(admin,index) in items" :key="index">
            <tr>
              <td>{{admin.id}}</td>
              <td v-if="admin.profile_image">
                <v-avatar>
                  <img :src="admin.profile_image" alt="John" />
                </v-avatar>
              </td>
              <td v-else>
                <v-avatar size="36">
                  <img
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSnIUIg8ZovaJTxegrtf0tlG2e68gEPDzqmoEjhRWsOzfS1d2FV&usqp=CAU"
                    alt="John"
                  />
                </v-avatar>
              </td>
              <td>{{admin.name}}</td>
              <td>{{admin.email}}</td>
              <td>
                <a :href="'mailto:'+admin.email">
                  <v-btn class="mt-1">send email</v-btn>
                </a>
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
      search: "",
      headers: [
        {
          text: "Id",
          align: "start",
          value: "id"
        },
        { text: "Profile", value: "avatar_url" },
        { text: "Name", value: "user_id" },
        { text: "Email", value: "book_id" },
        { text: "Actions", value: "actions" }
      ],
      admins: this.$store.state.admins
    };
  }
};
</script>
