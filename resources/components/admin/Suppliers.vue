<template>
<div>
    <v-dialog
    v-model="editDialog"
    max-width="500"
    persistent
  >
    <v-card>
      <v-card-title primary-title>
        Edit Supplier
      </v-card-title>
      <v-card-text>
        <v-col cols="12">
          <v-text-field
            :error-messages=errors.edit_name
            name="edit_name"
            v-model="fields.edit_name"
            label="supplier name"
          ></v-text-field>
        </v-col>
        <v-col cols="12">
          <v-text-field
            outlined
            address="ph_no"
            label="Phone Number"
            :error="errors.edit_ph_no"
            :error-messages="errors.edit_ph_no"
            v-model="fields.edit_ph_no"
          ></v-text-field>
        </v-col>
        <v-col cols="12">
          <v-textarea
            :error="errors.edit_address"
            :error-messages="errors.edit_address"
            label="Address"
            name="address"
            v-model="fields.edit_address"
            auto-grow
            outlined
            rows="3"
            row-height="15"
          ></v-textarea>
        </v-col>
        <v-col cols="12">
          <v-textarea
            :error="errors.edit_email"
            :error-messages="errors.edit_email"
            label="Email"
            name="email"
            v-model="fields.edit_email"
            auto-grow
            outlined
            rows="3"
            row-height="15"
          ></v-textarea>
        </v-col>
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
          @click="submitEdit(target_item.id)"
          color="primary" outlined
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>

  <v-dialog 
    v-model="registerDialog"
    max-width="500"
    persistent
  >
    <v-card>
      <v-card-title primary-title>
        Register Supplier
      </v-card-title>
      <v-card-text>
        <v-col cols="12">
          <v-text-field
            :error="errors.name"
            :error-messages=errors.name
            name="name"
            v-model="fields.name"
            label="supplier name"
          ></v-text-field>
        </v-col>
        <v-col cols="12">
          <v-text-field
            outlined
            address="ph_no"
            label="Phone Number"
            :error="errors.ph_no"
            :error-messages="errors.ph_no"
            v-model="fields.ph_no"
          ></v-text-field>
        </v-col>
        <v-col cols="12">
          <v-textarea
            :error="errors.address"
            :error-messages="errors.address"
            label="Address"
            name="address"
            v-model="fields.address"
            auto-grow
            outlined
            rows="3"
            row-height="15"
          ></v-textarea>
        </v-col>
        <v-col cols="12">
          <v-textarea
            :error="errors.email"
            :error-messages="errors.email"
            label="Email"
            name="email"
            v-model="fields.email"
            auto-grow
            outlined
            rows="3"
            row-height="15"
          ></v-textarea>
        </v-col>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          text
          @click="registerDialog = false; target_item = '';"
        >
          Cancel
        </v-btn>
        <v-btn
          text
          @click="submit()" 
          color="primary" outlined
        >
          Register
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>

  <v-dialog
    v-model="deleteDialog"
    max-width="350"
    persistent
  >
    <v-card>
      <v-card-text>
        Do you want to delete this supplier?
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
          @click="deleteDialog = false; submitDelete(target_item.id,target_item.name);"
        >
          Yes
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>

      <v-snackbar v-model="alert" color="success">
      {{alertMessage}}
      <v-btn text @click="alert = false">Close</v-btn>
    </v-snackbar>
    <div>
      <v-card>
        <v-card-title>
          Suppliers
          <v-btn outlined class="ml-3" @click="registerDialog = true">create new +</v-btn>
          <v-spacer></v-spacer>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
        </v-card-title>
        <v-data-table :headers="headers" :items="suppliers" :search="search">
          <template #item.name="{value}">{{value}}</template>
          <template #item.count="{value}">{{value}}</template>
          <template #item.phno="{value}">{{value}}</template>
          <template #item.address="{value}">{{value}}</template>
          <template #item.email="{value}">{{value}}</template>
          <template #item.actions='{item}'>
            <div class="d-flex flex-row">
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn
                        @click="openEditForm(item)"
                        class="mt-1" text icon v-on="on">
                        <v-icon>mdi-pencil</v-icon>
                      </v-btn>
                    </template>
                    <span>edit</span>
                  </v-tooltip>
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
                      <v-btn @click="deleteDialog = true; target_item = item" class="mt-1" text icon v-on="on">
                        <v-icon>mdi-delete</v-icon>
                      </v-btn>
                    </template>
                    <span>delete supplier</span>
                  </v-tooltip>
                </div>
          </template>
        </v-data-table>
      </v-card>
    </div>
  </div>
</template>

<script>
import InputMixin from '../../js/RecordInputmixin';
import EditMixin from '../../js/editFrom';
import DeleteMixin from '../../js/deleteForm';
import LastRecordMixin from '../../js/lastRecordmixin';

export default {
  mixins: [InputMixin,EditMixin, DeleteMixin,LastRecordMixin],
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
        { text: "Phone no.", value: "phno" },
        { text: "Address", value: "address" },
        { text: "Email", value: "email"},
        { text: "Actions", value: "actions" }
      ],
      act: "/admin/suppliers/addsupplier",
      statename: "suppliers",
      editDialog: false,
      deleteDialog: false,
      target_item: '',
      target_item_value: '',
      cascade: null,
      registerDialog: false
    }
  },
  computed: {
    suppliers() {
      return this.$store.state.suppliers;
    }
  },
  methods: {
    openEditForm(supplier){
      this.editDialog = true;
      this.target_item = supplier;
      this.fields.edit_name = supplier.name;
      this.fields.edit_ph_no = supplier.phno;
      this.fields.edit_address = supplier.address;
      this.fields.edit_email = supplier.email;
    }
  }
};
</script>

<style>
</style>
