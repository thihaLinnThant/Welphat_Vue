import Lastrecord from './lastRecordmixin'
import editFrom from './editFrom'
export default {
    mixins: [Lastrecord, editFrom],
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
            alertMessage: '',
            alertType: '',
            registerDialog: false
        }
    },
    methods: {
        async submit() {
            if (this.loaded) {
                this.loaded = false;
                this.success = false;
                this.errors = {};
                    //post request to the server with request fields
                    //(this.act)action and (this.fields)fields will be from component's data
                    await axios.post(this.act, this.fields).then(response => {
                        this.loaded = true;
                        this.success = true;
                        this.goterror = false;

                        this.alert = true;
                        this.alertType = "success";

                        this.fields = {}; //Clear input fields.

                        this.lastrecord(this.statename);
                        this.registerDialog = false;



                    })
                    .catch(error => {
                        //Catch will excecuted when the validation got error
                        this.loaded = true;
                        this.goterror = true;
                        console.log(error.response);
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors || {}; //get error json file from controller
                        }
                    });

            }
        },
    },
}
