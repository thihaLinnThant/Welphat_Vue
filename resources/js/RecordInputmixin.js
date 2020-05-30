import Lastrecord from './lastRecordmixin'
export default {
    mixins: [Lastrecord],
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

                    //there will be a condition later
                    this.lastrecord(this.routename, this.statename);
                    //

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