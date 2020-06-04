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
            alert: false
        }
    },
    methods: {
        submit() {
            if (this.loaded) {
                this.loaded = false;
                this.success = false;
                this.errors = {};

                //post request to the server with request fields
                //(this.act)action and (this.fields)fields will be from component's data
                axios.post(this.act, this.fields).then(response => {
                    this.fields = {}; //Clear input fields.
                    this.loaded = true;
                    this.success = true;                    
                    this.goterror = false;
                    this.alert = true;

                    this.lastrecord(this.statename);
                    
                    // //to get registered record to state
                    // if(this.statename !== null){
                    //     //(this.statename) will be from component's data. Default is null
                    //     this.lastrecord(this.statename);
                    // }

                }).catch(error => {
                    //Catch will excecuted when the validation got error
                    this.loaded = true;
                    this.goterror = true;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {}; //get error json file from controller
                    }
                });
            }
        },
    },
}