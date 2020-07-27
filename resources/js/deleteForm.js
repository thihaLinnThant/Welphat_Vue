export default {
    methods: {
        submitDelete(id,name) {
          console.log(id);

            axios.post(`/admin/${this.statename}/delete/${id}`).then(response => {

                create_admin_noti('delete',this.target_item);
                this.target_item = '';//empty target item
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
