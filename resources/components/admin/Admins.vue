<template>
  <div>
    <v-dialog v-model="deleteDialog" max-width="380" persistent>
      <v-card>
          <v-card-title>Delete Admin</v-card-title>
        <v-card-text v-if="isSuper_admin != 1">Do you want to delete this admin?</v-card-text>
        <v-card-text v-else>Sorry, you can't delete Super Admin</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text @click="deleteDialog = false; target_item = '';" v-if="isSuper_admin != 1" outlined color="primary">No</v-btn>
          <v-btn text @click="deleteDialog = false; target_item = '';" v-else outlined color="primary">OK</v-btn>

          <v-btn
            text
            v-show="isSuper_admin != 1"
            @click="deleteDialog = false; submitDelete(target_item.id,target_item.name);"
          >Yes</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="updateDialog" max-width="430" persistent>
      <v-card>
        <v-card-title>
          <span class="headline">Upgrade to Super Admin</span>
        </v-card-title>
        <v-card-text>
          <v-col cols="12">
            <v-text-field label="Super Admin Code" outlined v-model="fields.super_admin"></v-text-field>
            <small>please fill the super admin code to update</small>
          </v-col>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="close">Close</v-btn>
          <v-btn
            color="blue darken-1"
            text
            type="submit"
            @click="statename = 'admins/adminSuper';submitEdit(target_item.id, fields); updateDialog = false"
          >Upgrade</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="editDialog" max-width="650" persistent>
      <v-card>
        <v-card-title>
          <span class="headline">Edit Admin</span>
        </v-card-title>
        <v-card-text>
          <v-container>

            <v-row v-if="isSuper_admin != 1">
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
              <v-col cols="12">
                <v-text-field
                  name="password"
                  label="Password"
                  :error-messages="errors.password"
                  v-model="fields.edit_password"
                  :append-icon="password_visible ? 'mdi-eye' : 'mdi-eye-off'"
                  :type="password_visible ? 'text' : 'password'"
                  class="input-group--focused"
                  @click:append="password_visible = !password_visible"
                ></v-text-field>
              </v-col>
              <small>*indicates required field</small>
              <v-btn @click="reset" outlined color="error">reset</v-btn>
            </v-row>
            <h2 v-else>Haha, no way bro!</h2>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text @click="editDialog = false; target_item = '';">Close</v-btn>
          <v-btn
            color="primary"
            v-show="isSuper_admin != 1"
            text
            @click="submitEdit(target_item.id, fields)"
            type="submit"
            outlined

          >Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-snackbar v-model="alert" :color="alertType">
      {{alertMessage}}
      <v-btn text @click="alert = false">Close</v-btn>
    </v-snackbar>
    <v-row justify="center">
      <v-dialog v-model="addNew_Dialog" persistent max-width="600px">
        <v-form @submit.prevent="submit">
          <v-card>
            <v-card-title>
              <span class="headline">Add New Admin</span>
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
        Admins
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
      <v-data-table :headers="headers" :items="admins" :search="search">
        <template v-slot:body="{ items }">
          <tbody v-for="(admin,index) in items" :key="index">
            <tr>
              <td>
                <v-icon :color="admin.super_admin == 1? 'yellow' : 'grey'">mdi-star</v-icon>
              </td>
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
                <row class="d-flex" justify="space-between">
                  <a :href="'mailto:'+admin.email" style="text-decoration: none">
                    <v-tooltip bottom>
                      <template v-slot:activator="{ on }">
                        <v-btn class="mt-1" text icon v-on="on">
                          <v-icon>mdi-email</v-icon>
                        </v-btn>
                      </template>
                      <span>send email</span>
                    </v-tooltip>
                  </a>
                  <span v-if="super_admin == 1">
                    <span>
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                          <v-btn
                            class="mt-1"
                            text
                            icon
                            v-on="on"
                            @click="editDialog = true; target_item = admin; fields.edit_name = admin.name;
                      fields.edit_email = admin.email; fields.edit_password = ''; isSuper_admin = admin.super_admin"
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
                            @click="deleteDialog = true; target_item = admin; isSuper_admin = admin.super_admin"
                          >
                            <v-icon>mdi-delete</v-icon>
                          </v-btn>
                        </template>
                        <span>Delete {{admin.name}}</span>
                      </v-tooltip>
                      <v-tooltip bottom v-if="admin.super_admin != 1">
                        <template v-slot:activator="{ on }">
                          <v-btn
                            class="mt-1"
                            text
                            icon
                            v-on="on"
                            @click="updateDialog = true; target_item= admin"
                          >
                            <v-icon>mdi-arrow-up-bold-circle</v-icon>
                          </v-btn>
                        </template>
                        <span>Upgrade {{admin.name}} to super admin</span>
                      </v-tooltip>
                    </span>
                  </span>
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
      isSuper_admin: 0,
      admin_id: window.admin_id,
      admin_name: window.admin_name,
      super_admin: window.super_admin,
      headers: [
        {
          text: "Role",
          value: "super_admin"
        },
        {
          text: "Id",
          align: "start",
          value: "id"
        },
        { text: "Profile", value: "profile_image" },
        { text: "Name", value: "name" },
        { text: "Email", value: "email" },
        { text: "Actions", value: "actions" }
      ],
      addNew_Dialog: false,
      deleteDialog: false,
      password_visible: false,
      editDialog: false,
      updateDialog: false,
      act: "/admin/admins/addadmin",
      statename: "admins",

      rules: {
        required: value => !!value || "Required."
      }
    };
  },
  computed: {
    admins() {
      return this.$store.state.admins;
    }
  },
  methods: {
    reset() {
      this.fields = {};
    },
    close() {
      this.addNew_Dialog = false;
      this.updateDialog = false;
      this.reset();
    },
    save() {
      if (!this.fields.name || !this.fields.email || !this.fields.password) {
        return;
      }
      this.addNew_Dialog = false;

      this.submit();
    }
  }
};
</script>
