<template>
  <div id="login-page">
    <b-container>
      <b-row class="justify-content-center">
        <b-col xl="10" lg="12" md="9">
          <b-card no-body class="login-card shadow-lg my-2">
            <b-card-body class="login-card-body p-0">
              <b-row class="login-card-row">
                <b-col lg="7" class="d-none d-lg-block bg-login-image"></b-col>
                <b-col lg="5" class="login-form p-5">
                  <div class="login-logo">
                    <strong>Lvdev</strong>
                  </div>

                  <b-form @submit.prevent="authLogin">
                    <b-input-group class="mb-3">
                      <b-form-input
                        id="email"
                        type="email"
                        autocomplete="email"
                        placeholder="Email"
                        autofocus
                        v-model="login.email"
                        :class="{ 'is-invalid': errors.email }"
                      ></b-form-input>
                      <b-input-group-append>
                        <b-input-group-text>
                          <span class="fas fa-envelope"></span>
                        </b-input-group-text>
                      </b-input-group-append>
                      <span v-if="errors.email" class="invalid-feedback" role="alert">
                        <strong v-text="errors.email[0]"></strong>
                      </span>
                    </b-input-group>

                    <b-input-group class="mb-3">
                      <b-form-input
                        id="password"
                        type="password"
                        autocomplete="password"
                        placeholder="Password"
                        v-model="login.password"
                        :class="{ 'is-invalid': errors.password }"
                      ></b-form-input>
                      <b-input-group-append>
                        <b-input-group-text>
                          <span class="fas fa-lock"></span>
                        </b-input-group-text>
                      </b-input-group-append>
                      <span v-if="errors.password" class="invalid-feedback" role="alert">
                        <strong v-text="errors.password[0]"></strong>
                      </span>
                    </b-input-group>

                    <b-row>
                      <b-col>
                        <b-overlay
                          :show="loading"
                          opacity="0.6"
                          spinner-small
                          spinner-variant="primary"
                        >
                          <b-button block type="submit" variant="primary">Login</b-button>
                        </b-overlay>
                      </b-col>
                    </b-row>
                  </b-form>
                </b-col>
              </b-row>
            </b-card-body>
          </b-card>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import { csrf } from '@/api/auth';
import to from '@/utils/async-await';

export default {
  name: 'Login',
  data() {
    return {
      login: {
        email: '',
        password: null
      },
      loading: false,
      errors: {}
    };
  },
  methods: {
    async authLogin() {
      this.errors = {};
      this.loading = true;
      await to(csrf());
      let [err] = await to(this.$store.dispatch('auth/login', this.login));
      if (err) {
        this.errors = err.response.data.errors;
        return (this.loading = false);
      }

      const authRedirect = localStorage.getItem('authRedirect');
      localStorage.removeItem('authRedirect');
      authRedirect
        ? this.$router.push({ path: authRedirect })
        : this.$router.push({ name: 'dashboard' });
    }
  }
};
</script>

<style lang="scss" scoped>
#login-page {
  background: #343a40;
  display: flex;
  align-items: center;
  @media (min-height: 565px) {
    height: 100vh !important;
  }
  .login-card {
    border-radius: 0.35rem;
    .login-card-body {
      height: 550px;
      border-radius: 0.35rem;
      overflow: hidden;
      .login-card-row {
        height: 100%;
        .bg-login-image {
          background: url('../../assets/img/login.jpg');
          background-position: center;
          background-size: cover;
        }
        .login-form {
          display: flex;
          flex-direction: column;
          justify-content: center;
        }
      }
    }
  }
}
</style>
