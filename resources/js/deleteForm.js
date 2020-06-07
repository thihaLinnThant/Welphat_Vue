export default {
    methods: {
        submitDelete(id) {
            axios.post(`/admin/${this.statename}/delete/${id}`).then(response => {                
                this.target_item_id = '';//empty target item id                
                console.log("deleted");

                //delete from state
                this.$store.commit('deleteOneRecord', { route: this.statename, id })
            });
        }
    }
}