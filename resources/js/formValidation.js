import { validationMixin } from "vuelidate";
import { required, maxLength, email } from "vuelidate/lib/validators";

export default{
  mixins: [validationMixin],
  data(){
      return {
        fields: {
            edit_name : '',
            edit_authors : '',
            edit_book_description: '',
            edit_book_price: '',
            edit_book_published_date: '',
            edit_categories: '',
            edit_tags: '',
            edit_publisher: '',
            edit_suppliers: '',
          },
      }
  },
  validations: {
    fields: {
      edit_name: {
        required
      },
      edit_authors : {
          required
      }, 
      edit_book_description : {
          required
      },
      edit_book_price : {
          required
      },
      edit_book_published_date: {
          required
      }, 
      edit_categories: {
          required
      },
      edit_tags: {
          required
      },
      edit_publisher: {
          required
      },
      edit_suppliers : {
          required
      }
      
    }
   },

}