export default {
    methods: {
        submitDelete(id) {
            axios.post(`/admin/${this.statename}/delete/${id}`).then(response => {
                alert("!Category deleted");
                this.target_item_id = '';//empty delet item value
                console.log("deleted");

                //delete from state
                this.$store.commit('deleteOneRecord', { route: statename, id })
            });
        }
    }
}