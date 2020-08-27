<template>
  <v-container class="white darken-2">
    <div class="text-center">
      <span class="headline black--text">WelPhat.com Online Book Store</span>
      <br />
      <div class="subtitle grey--text">
        No,199, dummy road, blah blah township, Yangon, Myanmar
        <br />Tel: 09256831429, 09254272220
        <br />Email : customercare@welphat.com
      </div>
    </div>
    <v-row class="black--text text-center">
      <v-col cols="col-6">
        <p>Customer Name - {{order.user_name}}</p>
        <p>Pay Type - Cash On Deli</p>
        <p>Address - {{order.address}}</p>
      </v-col>
      <v-col cols="col-6">
        <p>Order ID - wp-{{order.id}}</p>
        <p>Date - {{order.created_at}}</p>
      </v-col>
    </v-row>

    <v-simple-table class="white">
      <template v-slot:default>
        <thead class="light-blue">
          <tr>
            <th class="text-left black--text">No</th>
            <th class="text-left black--text">Book Name</th>
            <th class="text-left black--text">Quantity</th>
            <th class="text-left black--text">Unit Count</th>
            <th class="text-left black--text">Amount</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item,index) in order.book_orders" :key="index">
            <td class="black--text">{{ index+1 }}</td>
            <td class="black--text">{{ item.book_name }}</td>
            <td class="black--text">{{item.qty}}</td>
            <td class="black--text">{{item.book_price}}</td>
            <td class="black--text">{{item.qty*item.book_price}}</td>
          </tr>
          <tr>
            <td class="black--text text-center title" colspan="4">SubTotal -</td>
            <td class="black--text title">{{subTotal}}</td>
          </tr>
          <tr>
            <td class="black--text text-center title" colspan="4">Delivery Fee (guess)-</td>
            <td class="black--text title">1000</td>
          </tr>
          <tr>
            <td class="black--text text-center title" colspan="4">Discount</td>
            <td class="black--text title">0</td>
          </tr>
          <tr>
            <td class="black--text text-center title" colspan="4">Net Amount</td>
            <td class="black--text title">{{subTotal+1000}}</td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
  </v-container>
</template>

<script>
export default {
  props: {
    order: {
      required: true,
    },
    subTotal: {
      required: true,
      type: Number,
    },
  },
};
</script>