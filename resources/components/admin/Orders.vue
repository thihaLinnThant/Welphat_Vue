<template>
<div>  
  <v-dialog
    v-model="deleteDialog"
    max-width="350"
    persistent
  >
    <v-card>
      <v-card-text>
        Do you want to delete this order?
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          text
          @click="deleteDialog = false; target_item = '';"
        >
          No
        </v-btn>

        <v-btn
          text
          @click="deleteDialog = false; submitDelete(target_item);"
        >
          Yes
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>

  <v-alert
    v-model="alert"
    border="left"
    close-text="Close Alert"
    color="deep-purple accent-4"
    dark
    transition="scroll-y-transition"
    dismissible
  >
    order registered
  </v-alert>

    <div>
      <v-card>
        <v-card-title>
          orders
          <v-spacer></v-spacer>          
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
          
        </v-card-title>
        <v-data-table :headers="headers" :items="orders" :search="search">          
          <template v-slot:body="{ items }">
            <tbody v-for="(order,index) in items" :key="index">
              <tr>
                <td>{{order.id}}</td>
                <td>{{ order.user.name }}</td>
                <td>
                  <span v-for="(books,index) in order.book_orders" :key="index">
                    <br>{{ books.book_name }}&#8195;({{ books.book_price }}ks)<br>
                  </span>
                </td>
                <td>{{ order.total_price }}ks</td>
                <td>{{ order.phone_no }}</td>
                <td>{{ order.address }}</td>
                <td class="d-flex flex-row">
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn @click="openEditForm" class="mt-1" text icon v-on="on">
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
                      <v-btn @click="deleteDialog = true; target_item = order" class="mt-1" text icon v-on="on">
                        <v-icon>mdi-delete</v-icon>
                      </v-btn>
                    </template>
                    <span>delete order</span>
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
import EditMixin from '../../js/editFrom';
import DeleteMixin from '../../js/deleteForm';
export default {
  mixins: [InputMixin,EditMixin, DeleteMixin],
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
        { text: "User name", value: "user.name" },
        { text: "Books", value: "books.book_name" },
        { text: "Total Price", value: "total_price" },
        { text: "phone no.", value: "phone_no" },
        { text: "address.", value: "address" },
        { text: "Actions", value: "actions" }
      ],
      act: "/admin/orders/addorder",
      statename: "orders",
      editDialog: false,
      deleteDialog: false,
      target_item: '',      
      cascade: null,      
    }
  },
  computed: {
    orders() {      
      return this.$store.state.orders;
    }
  },
  methods: {
      openEditForm(){
          this.editDialog = true;          
      },
  }
};
</script>

<style>
</style>
