<template>
  <div>
    <table id="mytable" style="display:none">
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
          <td colspan="4">Delivery Fee( guess ) </td>
          <td>1000</td>
        </tr>
        <tr>
          <td colspan="4">Discount</td>
          <td>0</td>
        </tr>
        <hr>
        <tr>
          <td colspan="4">Net Amount</td>
          <td>{{subTotal+1000}}</td>
        </tr>
      </tbody>
      <canvas id="myCanvas" width="450" height="200" style="border:1px solid #d3d3d3;"></canvas>
    </table>
    <p>hello {{order}}</p>
    <img :src="imageURL" alt v-if="imageURL" />
    <v-btn @click="generateBookName">print</v-btn>
  </div>
</template>


<script>
import CrudHandler from "../../js/CRUDHandler";
import axios from "axios";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";

export default {
  mixins: [CrudHandler],
  data() {
    return {
      csrf_token: window.csrf_token,
      todos: [],
      imageURL: null,
      subTotal: 0,
    };
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
    exportPDF() {
      var doc = new jsPDF('a4');

      // title
      doc.setFontSize(25);
      doc.text("Welphat.com Online Book Store", 100, 20, "center");

      // book shop address info
      doc.setTextColor(150);
      doc.setFontSize(13);
      doc.text(
        "No 199, dummy road, lorem Township, Yangon, Myanmar",
        100,
        30,
        "center"
      );

      // book shop phnumber info
      doc.setTextColor(150);
      doc.setFontSize(13);
      doc.text("tel : 09-256831429, 09-254272220", 100, 35, "center");

      // book shop phnumber info
      doc.setTextColor(150);
      doc.setFontSize(13);
      doc.text("email : customercare@welphat.com", 100, 40, "center");

      doc.setTextColor(150);
      doc.setFontSize(10);
      doc.text(15, 60, `Customer : ${this.order.user_name}`);

      doc.setTextColor(150);
      doc.setFontSize(10);
      doc.text(150, 60, `OrderID : ${this.order.id}`);

      doc.setTextColor(150);
      doc.setFontSize(10);
      doc.text(15, 70, `Pay Type : Cash On Deli`);

      doc.setTextColor(150);
      doc.setFontSize(10);
      doc.text(150, 70, `Date : ${this.order.created_at}`);

      //address
      doc.setTextColor(150);
      doc.setFontSize(10);
      doc.text(15, 80, `Address : ${this.order.address}`);
      doc.line(15, 50, 280, 50);

      doc.autoTable({
        html: "#mytable",
        margin: { top: 100 },
        bodyStyles: { minCellHeight: 15 },
        didDrawCell: function (data) {
          console.log(data.column.index);
          if (data.column.index === 1 && data.cell.section === "body") {
            var td = data.cell.raw;
            var img = td.getElementsByTagName("img")[0];
            var dim = data.cell.height - data.cell.padding("vertical");

            var textPos = data.cell;

            console.log(textPos);

            doc.addImage(img.src, textPos.x, textPos.y, dim, dim);
          }
        },
      });
      doc.save(`${this.order.user_name} - ${this.order.id}.pdf`);
    },
  },
};
</script>