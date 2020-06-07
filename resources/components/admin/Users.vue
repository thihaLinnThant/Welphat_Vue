<template>
  <div>
    <v-dialog
      v-model="wishList_dialog"
      max-width="350"
    >
      <v-card
        class="mx-auto"
        max-width="400"
        tile
      >
        <v-list
          disabled          
        >
          <v-card-title>Wish List</v-card-title>
            <v-list-item
              v-for="(item, i) in target_item_wish_list"
              :key="i"
              inactive
            >
              <v-list-item-title>
                {{ item.book_name }}
              </v-list-item-title>
            </v-list-item>
        </v-list>
      </v-card>
    </v-dialog>
    <v-card>
      <v-card-title>
        Users
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table :headers="headers" :items="users" :search="search">
        <template v-slot:body="{ items }">
          <tbody v-for="(user,index) in items" :key="index">
            <tr>
              <td>{{user.id}}</td>
              <td v-if="user.profile_image">
                <v-avatar>
                  <img :src="user.profile_image" alt="John" />
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
              <td>{{user.name}}</td>
              <td>{{user.email}}</td>
              <td v-if="user.ph_no">{{user.ph_no}}</td>
              <td v-else>not available</td>
              <td v-if="user.address">{{user.address}}</td>
              <td v-else>not available</td>
              <td>
                <row class="d-flex" justify="space-between">
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn @click="showWishList(user.wishes)" class="mt-1" text icon v-on="on">
                        <v-icon>mdi-heart</v-icon>
                      </v-btn>
                    </template>
                    <span>show wish list</span>
                  </v-tooltip>

                  <a :href="'mailto:'+user.email">
                    <v-tooltip bottom>
                      <template v-slot:activator="{ on }">
                        <v-btn class="mt-1" text icon v-on="on">
                          <v-icon>mdi-email</v-icon>
                        </v-btn>
                      </template>
                      <span>send email</span>
                    </v-tooltip>
                  </a>

                  <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn class="mt-1" text icon v-on="on">
                        <v-icon>mdi-pencil</v-icon>
                      </v-btn>
                    </template>
                    <span>edit</span>
                  </v-tooltip>

                  <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn class="mt-1" text icon v-on="on">
                        <v-icon>mdi-delete</v-icon>
                      </v-btn>
                    </template>
                    <span>delete user</span>
                  </v-tooltip>
                </row>
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
        { text: "Profile", value: "profile_image" },
        { text: "Name", value: "name" },
        { text: "Email", value: "email" },
        { text: "Ph number", value: "ph_no" },
        { text: "Address", value: "address" },
        { text: "Actions", value: "actions" }
      ],
      users: this.$store.state.users,
      wishList_dialog: false,
      target_item_id: '',
      target_item_wish_list: ''
    };
  },
  methods: {
    showWishList(list){
      this.wishList_dialog = true;
      this.target_item_wish_list = list;
    }
  }
};
</script>
