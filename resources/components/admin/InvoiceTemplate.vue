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
          <td>index+1</td>
          <td>
            <img
               :id="'myImage'+index" src
            />
          </td>
          <td>1000</td>
          <td>1</td>
          <td>90-000</td>

        </tr>
        <tr>
          <td colspan="4">SubTotal</td>
          <td>90000</td>
        </tr>
       
      </tbody>
    <canvas id="myCanvas" width="300" height="200" style="border:1px solid #d3d3d3;"></canvas>
      
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
    };
  },
  computed: {
    order() {
      return this.$store.state.invoicetemplate;
    },
  },

  methods: {
    generateBookName() {
      try {
         var canvas = document.getElementById("myCanvas");
      var ctx = canvas.getContext("2d");
      ctx.font = "90px Arial";
     

      this.order.book_orders.forEach((element,index) => {
         ctx.fillText(element.book_name, 10, 110);


        document.getElementById(`myImage${index}`).src =  canvas.toDataURL("image/png")

        ctx.clearRect(0, 0, 300, 200);  
        console.log(document);
      })
      } catch (error) {
        console.log(error);
      }
      finally{
        this.exportPDF();
      }

     
    },
    exportPDF() {
var doc = new jsPDF("letter");
  
      doc.autoTable({
        html: "#mytable",
        bodyStyles: { minCellHeight: 15 },
        didDrawCell: function (data) {
          console.log(data.column.index)
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

      // var subTotal = 0;
      // this.order.book_orders.forEach((element, index) => {
      //   this.generateBookName(element.bookname);
      //   subTotal += element.book_price * element.qty;
      //   this.todos.push({
      //     number: index + 1,
      //     bookname: doc.addImage(this.imageURL, 'JPEG', 10, 10, 50, 50, 'invoice_book'),
      //     quantity: element.qty,
      //     unitcost: element.book_price,
      //     amount: element.book_price * element.qty,
      //   });
      // });
      // var vm = this;
      // var columns = [
      //   { title: "No", dataKey: "number" },
      //   { title: "Book Name", dataKey: "bookname" },
      //   { title: "Quantity", dataKey: "quantity" },
      //   { title: "UnitCost", dataKey: "unitcost" },
      //   { title: "Amount", dataKey: "amount" },
      // ];

      // doc.addImage(this.imageURL, 'JPEG', 10, 10, 50, 50, 'invoice_book');

      // // user name
      // doc.setFontSize(22);
      // doc.text(20, 20, this.order.user_name);

      // // order id
      // doc.setTextColor(150);
      // doc.setFontSize(10);
      // doc.text(20, 30, `OrderID : ${this.order.id}`);

      // //address
      // doc.setTextColor(150);
      // doc.setFontSize(10);
      // doc.text(20, 40, `Address : ${this.order.address}`);

      // // date
      // doc.setTextColor(150);
      // doc.setFontSize(10);
      // doc.text(250, 40, `Address : ${this.order.address}`, "right");

      // doc.autoTable(columns, vm.todos, {
      //   margin: { top: 60 },
      // });

      // doc.setLineWidth(1.5);
      // doc.line(200, 95, 283, 95);

      // doc.setFontSize(15);
      // doc.setTextColor(150);
      // doc.text(230, 105, `SubTotal                  ${subTotal} mmk`, "right");

      doc.save(`${this.order.user_name} - ${this.order.id}.pdf`);
    },
  },
};
</script>