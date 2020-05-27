export default {
    data() {
        return {
            csrf_token: window.csrf_token,
            fields: {},
            errors: {},
            goterror: false,
            success: false,
            loaded: true,            
        }
    },
    methods: {
        submit() {
            if (this.loaded) {
                this.loaded = false;
                this.success = false;
                this.errors = {};

                axios.post(this.act, this.fields).then(response => {
                    this.fields = {}; //Clear input fields.
                    this.loaded = true;
                    this.success = true;                    
                    this.goterror = false;
                    axios.get(`/api/lastrecord/${this.routename}`).then(({ data }) => {
                        this.$store.commit('addOneRecord', { route: this.statename, data })
                    });
                }).catch(error => {
                    this.loaded = true;
                    this.goterror = true;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    }
                });
            }
        },
    },
}