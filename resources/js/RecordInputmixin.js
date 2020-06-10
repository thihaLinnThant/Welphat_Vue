import Lastrecord from './lastRecordmixin'
import editFrom from './editFrom'
export default {
    mixins: [Lastrecord,editFrom],
    data() {
        return {
            csrf_token: window.csrf_token,
            statename: null,
            fields: {},
            errors: {},
            goterror: false,
            success: false,
            loaded: true,
            alert: false,
            alertMessage : '',
            alertAction : ''
        }
    },
    methods: {
        submit() {
            if (this.loaded) {
                this.loaded = false;
                this.success = false;
                this.errors = {};

                console.log(this.fields);
                //post request to the server with request fields
                //(this.act)action and (this.fields)fields will be from component's data
                axios.post(this.act, this.fields).then(response => {
                    this.loaded = true;
                    this.success = true;
                    this.goterror = false;

                    this.alert = true;
                    this.fields = {}; //Clear input fields.

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
                    // if (error.response.status === 422) {
                    //     this.errors = error.response.data.errors || {}; //get error json file from controller
                    //     console.log(error.response);
                    // }

                    console.log("error");
                });
            }
        },
    },
}
