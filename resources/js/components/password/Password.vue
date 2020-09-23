<template>
  <div class="input-group">
    <b-form-input
      :type="type"
      :placeholder="placeholder"
      v-model="password"
      :disabled="disabled"
      :class="error"
      @input="handleData"
    />
    <span
      class="fa fa-fw field-icon"
      :class="[{'fa-eye' : this.type === 'password'}, {'fa-eye-slash': this.type === 'text'}]"
      @click="changeType"
    ></span>
    <span class="input-group-append">
      <b-button variant="primary" :disabled="disabled" @click="generate">
        <i class="fa fa-sync-alt"></i>
        <span class="d-none d-sm-inline">Generate</span>
      </b-button>
    </span>
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'Password',
  props: {
    size: { type: String, default: '32' },
    characters: { type: String, default: 'a-z,A-Z,0-9,#' },
    placeholder: { type: String, default: 'Password' },
    disabled: { type: Boolean, default: false },
    error: { type: Object },
    value: '',
  },
  data() {
    return {
      password: this.value,
      type: 'password',
    };
  },
  methods: {
    generate() {
      this.type = 'text';
      let charactersArray = this.characters.split(',');
      let CharacterSet = '';
      let password = '';

      if (charactersArray.indexOf('a-z') >= 0) {
        CharacterSet += 'abcdefghijklmnopqrstuvwxyz';
      }
      if (charactersArray.indexOf('A-Z') >= 0) {
        CharacterSet += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      }
      if (charactersArray.indexOf('0-9') >= 0) {
        CharacterSet += '0123456789';
      }
      if (charactersArray.indexOf('#') >= 0) {
        CharacterSet += '![]{}()%&*$#^<>~@|';
      }

      for (let i = 0; i < this.size; i++) {
        password += CharacterSet.charAt(
          Math.floor(Math.random() * CharacterSet.length)
        );
      }
      this.password = password;
      this.handleData();
    },
    changeType() {
      if (this.type === 'password') return (this.type = 'text');
      return (this.type = 'password');
    },
    handleData() {
      this.$emit('input', this.password);
    },
  },
};
</script>

<style lang="scss" scoped>
.form-control {
  padding-right: 1.75rem;
}
.is-invalid {
  background-image: unset !important;
}
.field-icon {
  cursor: pointer;
  float: right;
  width: 2rem;
  z-index: 3;
  margin-left: -1.95rem;
  margin-top: 0.75rem;
}
</style>
