<template>
  <v-container>
    <v-row align-content="center" justify="center">
      <v-form v-model="isFormValid" method="post" :action="(admin_login)? '/login/admin' : '/login'">
        <input type="hidden" name="_token" id="csrf-token" :value="csrf_token" />
        <v-card width="400px">
          <v-card-title>{{ (admin_login)? "Admin " : "" }}Login</v-card-title>
          <v-card-text>
            <v-text-field :rules="rules" id="email" name="email" placeholder="Enter user name" ></v-text-field>
            <v-text-field :rules="rules" id="password" name="password" type="password" placeholder="Enter password" ></v-text-field>
          </v-card-text>
          <v-card-actions>
            <v-btn :disabled="!isFormValid" type="submit">Login</v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      csrf_token: window.csrf_token,
      fields: {},
      errors: {},
      admin_login: window.login_url,
      rules: [
        value => !!value || 'Required'
      ],
      isFormValid: false,
    }
  },
}
</script>

<style>

</style>