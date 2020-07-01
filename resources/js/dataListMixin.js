import { mapState } from "vuex";

export default {
    computed: mapState({
        categories: "categories",
        authors: "authors",
        tags: "tags",
        publishers: "publishers",
        suppliers: "suppliers",

        category_list() {
            let categoryTemp = [];
            this.categories.forEach(element => {
                categoryTemp.push({ name: element.name, id: element.id });
            });
            return categoryTemp;
        },
        author_list() {
            let authorTemp = [];
            this.authors.forEach(element => {
                authorTemp.push({ name: element.name, id: element.id });
            });
            return authorTemp;
        },
        tag_list() {
            let tagTemp = [];
            this.tags.forEach(element => {
                tagTemp.push({ name: element.name, id: element.id });
            });
            return tagTemp;
        },
        publisher_list() {
            let publisherTemp = [];
            this.publishers.forEach(element => {
                publisherTemp.push({ name: element.name, id: element.id });
            });
            return publisherTemp;
        },
        supplier_list() {
            let supplierTemp = [];
            this.suppliers.forEach(element => {
                supplierTemp.push({ name: element.name, id: element.id });
            });
            return supplierTemp;
        }
    })
}