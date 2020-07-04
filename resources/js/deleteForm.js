export default {
    methods: {
        submitDelete(id,name) {
          console.log(id);

            axios.post(`/admin/${this.statename}/delete/${id}`).then(response => {

                this.target_item_id = '';//empty target item id
                this.alert = true;
                this.alertMessage = `${this.statename} (${name}) is deleted`;

                //delete from state
                this.$store.commit('deleteOneRecord', { route: this.statename, id })
            }).catch(error=>{
                console.log(error);
            })
        }
    }
}
