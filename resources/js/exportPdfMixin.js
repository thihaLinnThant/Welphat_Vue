import jsPDF from "jspdf";

export default {
  methods: {
    exportPDF() {
      var doc = new jsPDF("a4");

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

    }
  }
}