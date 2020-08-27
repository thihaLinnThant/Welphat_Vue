<template>
  <div>
    <invoicePreview :order="order" :subTotal="subTotal" />
    <table id="mytable" style="display:none;">
      <thead>
        <tr>
          <th>No</th>
          <th>Book Name</th>
          <th>Quantity</th>
          <th>Unit Count</th>
          <th>Amount</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(singleOrder,index) in order.book_orders" :key="index">
          <td>{{index+1}}</td>
          <td>
            <img :id="'myImage'+index" src />
          </td>
          <td>{{singleOrder.qty}}</td>
          <td>{{singleOrder.book_price}}</td>
          <td>{{singleOrder.qty*singleOrder.book_price}}</td>
        </tr>
        <tr>
          <td colspan="4">SubTotal</td>
          <td>{{subTotal}}</td>
        </tr>
        <tr>
          <td colspan="4">Delivery Fee( guess )</td>
          <td>1000</td>
        </tr>
        <tr>
          <td colspan="4">Discount</td>
          <td>0</td>
        </tr>
        <hr />
        <tr>
          <td colspan="4">Net Amount</td>
          <td>{{subTotal+1000}}</td>
        </tr>
      </tbody>
      <canvas id="myCanvas" width="450" height="200" style="border:1px solid #d3d3d3;"></canvas>
    </table>
    <v-btn @click="generateBookName" block class="mt-3">print</v-btn>
  </div>
</template>


<script>
import CrudHandler from "../../js/CRUDHandler";
import axios from "axios";
import autoTable from "jspdf-autotable";
import invoicePreview from "./invoicePreview";
import exportPdfMixin from "../../js/exportPdfMixin";

export default {
  mixins: [CrudHandler, exportPdfMixin],
  data() {
    return {
      csrf_token: window.csrf_token,
      todos: [],
      imageURL: null,
      subTotal: 0,
    };
  },
  components: {
    invoicePreview,
  },
  computed: {
    order() {
      return this.$store.state.invoicetemplate;
    },
  },
  created() {
    this.order.book_orders.forEach((element, index) => {
      this.subTotal += element.book_price * element.qty;
    });
  },
  methods: {
    generateBookName() {
      try {
        var canvas = document.getElementById("myCanvas");
        var ctx = canvas.getContext("2d");
        ctx.font = "90px Arial";

        this.order.book_orders.forEach((element, index) => {
          ctx.fillText(element.book_name, 10, 110);

          document.getElementById(`myImage${index}`).src = canvas.toDataURL(
            "image/png"
          );

          ctx.clearRect(0, 0, 450, 200);
          console.log(document);
        });
      } catch (error) {
        console.log(error);
      } finally {
        this.exportPDF();
      }
    },
  },
};
</script>

