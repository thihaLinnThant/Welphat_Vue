export default {
    watch() {
        return {
            fields: {},
            errors: {}
        }
    },
    methods: {
        submitEdit(id) {

            axios.post(`/admin/${this.statename}/update/${id}`, this.fields).then(response => {
            this.editDialog = false;

                console.log('got updated');
                // get edited data

                axios.get(`/api/admin/${this.statename}/onerecord/${id}`).then(({ data }) => {
                    
                    this.alert = true;
                    console.log('got one record');
                    console.log(data);

                    if (this.statename == 'admins/adminSuper') {
                        if (this.fields.super_admin == '5up3rP@s5wrod') {
                            this.$store.commit('replaceOneRecord', { route: 'admins', data, id })
                            this.alertMessage = `${data.name} is updated to super admin  `;
                            this.alertType = "success";

                        } else {
                            this.alertMessage = "Check your code and try again!";
                            this.alertType = "error";

                        }
                    }


                    this.$store.commit('replaceOneRecord', { route: this.statename, data, id })
                    this.alertMessage = `${this.statename} is updated with new (${data.name})  `;



                });
            }).catch(error => {
                //Catch will excecuted when the validation got error
                this.goterror = true;
                console.log(error.response);
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors || {}; //get error json file from controller
                }

            });
        }
    }
}
