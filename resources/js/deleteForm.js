export default {
    methods: {
        submitDelete(id,name) {

            axios.post(`/admin/${this.statename}/delete/${id}`).then(response => {
                console.log("user delete");
                this.target_item_id = '';//empty target item id
                this.alert = true;
                this.alertMessage = `${this.statename} (${name}) is deleted`;

                //delete from state
                this.$store.commit('deleteOneRecord', { route: this.statename, id })
            });
        }
    }
}
