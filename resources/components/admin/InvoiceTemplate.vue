<template>
  <div>
    <p>hello {{order}}</p>
    <v-btn @click="exportPDF">print</v-btn>

    <table id="mytable"></table>
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
    };
  },
  computed: {
    order() {
      return this.$store.state.invoicetemplate;
    },
  },
  methods: {
    exportPDF() {
      var subTotal = 0;
      this.order.book_orders.forEach((element, index) => {
        subTotal += element.book_price*element.qty;
        this.todos.push({
          number: index + 1,
          bookname: element.book_name,
          quantity: element.qty,
          unitcost: element.book_price,
          amount: element.book_price*element.qty,
        });
      });
      var vm = this;
      var columns = [
        { title: "No", dataKey: "number" },
        { title: "Book Name", dataKey: "bookname" },
        { title: "Quantity", dataKey: "quantity" },
        { title: "UnitCost", dataKey: "unitcost" },
        { title: "Amount", dataKey: "amount" },
        
      ];

      var doc = new jsPDF("letter");

      console.log(doc);

      // user name
      doc.setFontSize(22);
      doc.text(20, 20, this.order.user_name);

      // order id
      doc.setTextColor(150);
      doc.setFontSize(10);
      doc.text(20, 30, `OrderID : ${this.order.id}`);

      //address
      doc.setTextColor(150);
      doc.setFontSize(10);
      doc.text(20, 40, `Address : ${this.order.address}`);

      // date
      doc.setTextColor(150);
      doc.setFontSize(10);
      doc.text(250, 40, `Address : ${this.order.address}`, "right");

      doc.autoTable(columns, vm.todos, {
        margin: { top: 60 },
      });

      doc.setLineWidth(1.5);
      doc.line(200, 95, 283, 95);

      doc.setFontSize(15);
      doc.setTextColor(150);
      doc.text(230,105, `SubTotal                  ${subTotal} mmk`,'right');

      doc.save("todos.pdf");
    },
  },
};
</script>