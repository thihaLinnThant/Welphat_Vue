export default {
    data() {
        return {
            fields: {},
            errors: {}
        }
    },
    methods: {
        submitEdit(id) {
            axios.post(`/admin/${this.statename}/update/${id}`, this.fields).then(response => {
                this.editDialog = false;

                // get edited data
                axios.get(`/api/admin/${statename}/onerecord/${id}`).then(({ data }) => {
                    this.$store.commit('replaceOneRecord', { route: statename, data, id })
                });
                
            }).catch(error => {
                //Catch will excecuted when the validation got error
                this.goterror = true;
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors || {}; //get error json file from controller
                }
            });
        }
    }
}