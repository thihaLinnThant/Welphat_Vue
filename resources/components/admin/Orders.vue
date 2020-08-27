<template>
  <div>
    <v-dialog v-model="deleteDialog" max-width="350" persistent>
      <v-card>
        <v-card-text>Do you want to delete this order?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text @click="deleteDialog = false; target_item = '';">No</v-btn>

          <v-btn text @click="deleteDialog = false; submitDelete();">Yes</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="editDialog" max-width="650" persistent>
      <v-card>
        <v-card-title>
          <span class="headline">Edit Order</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" v-for="(edit_book,index) in fields.edit_books" :key="index">
                <p>{{edit_book}}</p>
                <v-row v-if="edit_book.removed">
                  <v-col cols="7">
                    <div style="color:red">
                      <s>{{edit_book.book_name}}</s>
                    </div>
                  </v-col>
                  <v-col cols="1">
                    <v-btn text icon color="success" @click="edit_book.removed = false">
                      <v-icon>mdi-recycle</v-icon>
                    </v-btn>
                  </v-col>
                </v-row>
                <v-row v-else>
                  <v-col cols="7">
                    <div>{{edit_book.book_name}}</div>
                  </v-col>
                  <v-col cols="1">
                    <v-text-field v-model="edit_book.qty" label="Qty"></v-text-field>
                  </v-col>
                  <v-col cols="4">
                    <v-btn text icon color="success" @click="edit_book.qty++">
                      <v-icon>mdi-plus</v-icon>
                    </v-btn>
                    <v-btn
                      text
                      icon
                      color="error"
                      v-show="edit_book.qty > 0"
                      @click="edit_book.qty--"
                    >
                      <v-icon>mdi-minus</v-icon>
                    </v-btn>
                    <v-btn color="error" text icon @click="edit_book.removed = true">
                      <v-icon>mdi-delete</v-icon>
                    </v-btn>
                  </v-col>
                </v-row>
                <v-divider></v-divider>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  outlined
                  label="Name*"
                  :error-messages="errors.name"
                  required
                  name="name"
                  v-model="fields.edit_name"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  outlined
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
              <v-btn outlined color="error">reset</v-btn>
            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text @click="editDialog = false; target_item = '';">Close</v-btn>
          <v-btn color="primary" outlined text @click="submitEdit()" type="submit">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="statusDialog" max-width="20%">
      <v-card>
        <v-card-title>Change Status</v-card-title>
        <v-card-actions>
          <div
            @click="updateStatus(target_item,1)"
            class="mr-2 statusDiv"
            style="background-color : green; cursor: pointer;"
          ></div>
          <div
            @click="updateStatus(target_item,2)"
            class="mr-2 statusDiv"
            style="background-color : yellow; cursor: pointer;"
          ></div>
          <div
            @click="updateStatus(target_item,3)"
            class="mr-2 statusDiv"
            style="background-color : orange; cursor: pointer;"
          ></div>
          <div
            @click="updateStatus(target_item,4)"
            class="mr-2 statusDiv"
            style="background-color : red; cursor: pointer;"
          ></div>
          <v-btn @click="statusDialog = false">Cancel</v-btn>
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
          Orders
          <v-btn class="mx-5" outlined>Create new</v-btn>
          <v-spacer></v-spacer>
          <div>
            <v-btn @click="search = ''" outlined dense color="purple" class="mr-2">
              <div class="bullet" style="background:purple"></div>
              <small>All</small>
            </v-btn>
            <v-btn @click="search = 'delivered'" outlined dense color="green" class="mr-2">
              <div class="bullet" style="background:green"></div>
              <small>Delivered</small>
            </v-btn>
            <v-btn @click="search = 'in_progress'" outlined dense color="yellow" class="mr-2">
              <div class="bullet" style="background:yellow"></div>
              <small>In Progress</small>
            </v-btn>
            <v-btn @click="search = 'canceled'" outlined dense color="orange" class="mr-2">
              <div class="bullet" style="background:orange"></div>
              <small>Canceled</small>
            </v-btn>
            <v-btn @click="search = 'passed_due'" outlined dense color="red" class="mr-2">
              <div class="bullet" style="background:red"></div>
              <small>passed_due</small>
            </v-btn>
          </div>
          <v-spacer></v-spacer>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
        </v-card-title>
        <v-data-table
          :headers="headers"
          :items="orders"
          :sort-by="['status']"
          :sort-desc="true"
          show-expand
          :search="search"
        >
          <template #item.status="{value}">
            <div class="statusDiv" :style="colorStatus(value)"></div>
          </template>
          <template #item.user_name="{value}">{{value}}</template>
          <template #item.count="{value}">
            <p>available:({{value.available_count}})</p>
            <p v-if="value.deleted_count" style="color : red ">deleted:({{value.deleted_count}})</p>
          </template>
          <template #item.total_price="{value}">
            <p>available:({{value.available_book_price}}ks)</p>
            <p
              v-if="value.deleted_book_price"
              style="color : red "
            >deleted:({{value.deleted_book_price}}ks)</p>
          </template>
          <template #item.created_at="{value}">{{dateFormat(value)}}</template>
          <template #item.user.ph_no="{value}">{{value}}</template>
          <template #item.user.address="{value}">{{value}}</template>
          <template v-slot:item.actions="{ item }">
            <div class="d-flex flex-row">
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn
                    @click="statusDialog = true; target_item = item"
                    class="mt-1"
                    text
                    icon
                    v-on="on"
                  >
                    <v-icon>mdi-alpha-s-circle</v-icon>
                  </v-btn>
                </template>
                <span>change status</span>
              </v-tooltip>
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn @click="openEditForm(item);" class="mt-1" text icon v-on="on">
                    <v-icon>mdi-pencil</v-icon>
                  </v-btn>
                </template>
                <span>edit</span>
              </v-tooltip>
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn
                    @click="deleteDialog = true; target_item = item"
                    class="mt-1"
                    text
                    icon
                    v-on="on"
                  >
                    <v-icon>mdi-delete</v-icon>
                  </v-btn>
                </template>
                <span>delete order</span>
              </v-tooltip>
              <router-link :to="{name : 'invoicetemplate', params: {id : item.id}}" style="text-decoration: none;">
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn class="mt-1" text icon v-on="on">
                    <v-icon>mdi-printer</v-icon>
                  </v-btn>
                </template>
                <span>print invoice</span>
              </v-tooltip>
              </router-link>
            </div>
          </template>
          <template #expanded-item="{item}">
            <td :colspan="headers.length+1">
              <v-container>
                <v-row align="start">
                  <v-card dense v-for="(book,index) in item.book_orders" :key="index" class="ma-2">
                    <v-list-item>
                      <v-list-item-avatar tile size="80">
                        <img :src="book.thumb" />
                      </v-list-item-avatar>
                      <v-list-item-subtitle>
                        <span style="color: red" v-if="book.deleted">
                          <s>
                            {{book.book_name}}
                            <br />
                            qty:({{book.qty}})
                          </s>
                          <br />!Deleted
                        </span>
                        <span v-else>
                          {{book.book_name}}
                          <br />
                          qty:({{book.qty}})
                        </span>
                      </v-list-item-subtitle>
                      <v-card-actions>
                        <v-btn v-if="!book.deleted" small dense>view</v-btn>
                      </v-card-actions>
                    </v-list-item>
                  </v-card>
                </v-row>
              </v-container>
            </td>
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
      statusDialog: false,
      search: "",
      headers: [
        {
          text: "Id",
          align: "start",
          value: "id",
        },
        { text: "Status", value: "status" },
        { text: "User name", value: "user_name" },
        { text: "Book Count", value: "count" },
        { text: "Total Price", value: "total_price" },
        { text: "Date", value: "created_at" },
        { text: "Phone no.", value: "phone_no" },
        { text: "Address", value: "address" },
        { text: "Actions", value: "actions" },
      ],
      act: "/admin/orders/addorder",
      statename: "orders",
      editDialog: false,
      deleteDialog: false,
      target_item: "",
      cascade: null,
    };
  },
  computed: {
    orders() {
      return this.$store.state.orders;
    },
  },
  methods: {

    openEditForm(item) {
      this.editDialog = true;
      this.target_item = item;
      this.fields.edit_name = item.user_name;
      this.fields.edit_ph_no = item.phone_no;
      this.fields.edit_books = item.book_orders;
      this.fields.edit_address = item.address;
      this.fields.edit_books.map((book) => (book.removed = false));
    },
    colorStatus(status) {
      switch (status) {
        case "code-1(delivered)":
          return "background-color:green";
        case "code-2(canceled)":
          return "background-color:orange";
        case "code-3(in_progress)":
          return "background-color:yellow";
        case "code-4(passed_due)":
          return "background-color:red";
      }
    },
    dateFormat(date) {
      var trimed_year = date.substring(0, 4);
      var trimed_month = date.substring(5, 7);
      var trimed_day = date.substring(8, 10);
      return trimed_day + "/" + trimed_month + "/" + trimed_year;
    },
    updateStatus(item, code) {
      var status = "";
      switch (code) {
        case 1:
          status = "code-1(delivered)";
          break;
        case 3:
          status = "code-2(canceled)";
          break;
        case 2:
          status = "code-3(in_progress)";
          break;
        case 4:
          status = "code-4(passed_due)";
          break;
      }
      this.fields.code = status;
      axios
        .post(`/admin/orders/updateStatus/${item.id}`, this.fields)
        .then((response) => {
          this.alert = true;
          this.alertType = "success";
          this.alertMessage = "Status updated";
          this.statusDialog = false;
          item.status = status;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style>
.bullet {
  border-radius: 100%;
  width: 0.5rem;
  height: 0.5rem;
}
.statusDiv {
  border-radius: 10%;
  width: 2rem;
  height: 2rem;
}
</style>
