<template>
  <div>
    <v-dialog v-model="editDialog" max-width="650" persistent>
      <v-card>
        <v-card-title>
          <span class="headline">Edit User</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  label="Name*"
                  :error-messages="errors.name"
                  required
                  name="name"
                  v-model="fields.edit_name"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  name="email"
                  label="Email*"
                  :error-messages="errors.email"
                  required
                  v-model="fields.edit_email"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  address="ph_no"
                  label="Phone Number(optional)"
                  :error="errors.ph_no"
                  :error-messages="errors.ph_no"
                  v-model="fields.edit_ph_no"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-textarea
                  :error="errors.address"
                  :error-messages="errors.address"
                  label="Address(optional)"
                  name="address"
                  v-model="fields.edit_address"
                  auto-grow
                  outlined
                  rows="3"
                  row-height="15"
                ></v-textarea>
              </v-col>
              <v-btn @click="reset" outlined color="error">reset</v-btn>
            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="editDialog = false; target_item = '';">Close</v-btn>
          <v-btn color="blue darken-1" text @click="submitEdit(target_item.id, fields)" type="submit">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="wishList_dialog" max-width="350">
      <v-card class="mx-auto" max-width="400" tile>
        <v-list disabled>
          <v-card-title>Wish List</v-card-title>
          <v-list-item v-for="(item, i) in target_item_wish_list" :key="i" inactive>
            <v-list-item-title>{{ item.book_name }}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-card>
    </v-dialog>
    <v-dialog v-model="deleteDialog" max-width="350" persistent>
      <v-card>
        <v-card-text>Do you want to delete this user?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text @click="deleteDialog = false; target_item = '';">No</v-btn>

          <v-btn
            text
            @click="deleteDialog = false; submitDelete(target_item.id,target_item.name);"
          >Yes</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-snackbar v-model="alert" color="success">
      {{alertMessage}}
      <v-btn text @click="alert = false">Close</v-btn>
    </v-snackbar>
    <v-row justify="center">
      <v-dialog v-model="addNew_Dialog" persistent max-width="600px">
        <v-form @submit.prevent="submit">
          <v-card>
            <v-card-title>
              <span class="headline">Add User</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      label="Name*"
                      :error="errors.name"
                      :error-messages="errors.name"
                      required
                      name="name"
                      v-model="fields.name"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field
                      name="email"
                      label="Email*"
                      :error="errors.email"
                      :error-messages="errors.email"
                      required
                      v-model="fields.email"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field
                      :error="errors.password"
                      :error-messages="errors.password"
                      :rules="[rules.required]"
                      :append-icon="password_visible ? 'mdi-eye' : 'mdi-eye-off'"
                      :type="password_visible ? 'text' : 'password'"
                      label="Password*"
                      hint="At least 8 characters"
                      value
                      name="password"
                      v-model="fields.password"
                      class="input-group--focused"
                      @click:append="password_visible = !password_visible"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6">
                    <v-text-field
                      address="ph_no"
                      label="Phone Number(optional)"
                      :error="errors.ph_no"
                      :error-messages="errors.ph_no"
                      v-model="fields.ph_no"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6">
                    <v-textarea
                      :error="errors.address"
                      :error-messages="errors.address"
                      label="Address(optional)"
                      name="address"
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
              <small>*indicates required field</small>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">Close</v-btn>
              <v-btn color="blue darken-1" text @click.prevent="save" type="submit">Save</v-btn>
            </v-card-actions>
          </v-card>
        </v-form>
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
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn @click="showWishList(user.wishes)" class="mt-1" text icon v-on="on">
                        <v-icon>mdi-heart</v-icon>
                      </v-btn>
                    </template>
                    <span>show wish list</span>
                  </v-tooltip>

                  <a :href="'mailto:'+user.email" style="text-decoration: none">
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
                      <v-btn
                        class="mt-1"
                        text
                        icon
                        v-on="on"
                        @click="editDialog = true; target_item = user; fields.edit_name = user.name;
                      fields.edit_email = user.email; fields.edit_ph_no = user.ph_no; fields.edit_address = user.address"
                      >
                        <v-icon>mdi-pencil</v-icon>
                      </v-btn>
                    </template>
                    <span>edit</span>
                  </v-tooltip>

                  <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn
                        class="mt-1"
                        text
                        icon
                        v-on="on"
                        @click="deleteDialog = true; target_item = user"
                      >
                        <v-icon>mdi-delete</v-icon>
                      </v-btn>
                    </template>
                    <span>delete {{user.name}}</span>
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
import EditMixin from "../../js/editFrom";
import DeleteMixin from "../../js/deleteForm";
import lastRecordMixin from "../../js/lastRecordmixin";
export default {
  mixins: [InputMixin, lastRecordMixin, EditMixin, DeleteMixin],
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
      deleteDialog: false,
      editDialog: false,
      password_visible: false,
      wishList_dialog: false,
      target_item: "",
      target_item_value: "",
      target_item_wish_list: "",
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
      if (!this.fields.name || !this.fields.email || !this.fields.password) {
        return;
      }
      this.addNew_Dialog = false;

      this.submit();
    },
    showWishList(list) {
      this.wishList_dialog = true;
      this.target_item_wish_list = list;
    }
  }
};
</script>
