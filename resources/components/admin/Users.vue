<template>
  <div>
    <v-row justify="center">
      <v-dialog v-model="addNew_Dialog" persistent max-width="600px">
        <v-card>
          <v-card-title>
            <span class="headline">Add User</span>
          </v-card-title>
          <v-card-text>
            <v-form @submit.prevent="submit">
              <v-container>
                <v-row>
                  <v-col cols="12">
                    <v-text-field label="Name*" required v-model="fields.name"></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field label="Email*" required v-model="fields.email"></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field
                      :rules="[rules.required]"
                      :append-icon="password_visible ? 'mdi-eye' : 'mdi-eye-off'"
                      :type="password_visible ? 'text' : 'password'"
                      name="input-10-2"
                      label="Password*"
                      hint="At least 8 characters"
                      value
                      v-model="fields.password"
                      class="input-group--focused"
                      @click:append="password_visible = !password_visible"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6">
                    <v-text-field label="Phone Number(optional)" v-model="fields.ph_no"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6">
                    <v-textarea
                      label="Address(optional)"
                      v-model="fields.address"
                      auto-grow
                      outlined
                      rows="3"
                      row-height="15"
                    ></v-textarea>
                  </v-col>
                  <v-btn @click="reset" outlined color="error">reset</v-btn>
                </v-row>
              </v-container>
            </v-form>
            <small>*indicates required field</small>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="close">Close</v-btn>
            <v-btn color="blue darken-1" text @click.prevent="save">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
    <v-card>
      <v-card-title>
        Users
        <v-spacer></v-spacer>
        <v-btn @click="addNew_Dialog = true" outlined>Create New +</v-btn>
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
import InputMixin from "../../js/RecordInputmixin";
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
        { text: "Profile", value: "profile_image" },
        { text: "Name", value: "name" },
        { text: "Email", value: "email" },
        { text: "Ph number", value: "ph_no" },
        { text: "Address", value: "address" },
        { text: "Actions", value: "actions" }
      ],
      act: "/admin/users/adduser",
      statename: "users",
      addNew_Dialog: false,
      password_visible: false,
      rules: {
        required: value => !!value || "Required."
      }
    };
  },
  computed: {
    users() {
      return this.$store.state.users;
    }
  },
  methods: {
    reset() {
      this.fields = {};
    },
    close() {
      this.addNew_Dialog = false;
      this.reset();
    },
    save() {
      this.addNew_Dialog = false;
      this.submit();
    }
  }
};
</script>
