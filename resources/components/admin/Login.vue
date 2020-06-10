<template>
  <v-row align="center" justify="center">
      <v-card>
          <v-card-title>Admin Login</v-card-title>

          <v-form>
            <v-text-field
                label="Name"
                required
            ></v-text-field>
            <v-text-field
                label="Email"
                required
            ></v-text-field>
            <v-text-field
                label="Password"
                required
            ></v-text-field>
            <v-text-field
                label="Confirm Password"
                required
            ></v-text-field>
          </v-form>
      </v-card>
  </v-row>
</template>

<script>
export default {

}
</script>

<style>

</style>
