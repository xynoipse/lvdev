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
    <span class="input-group-append">
      <b-button variant="primary" :disabled="disabled" @click="generate">
        <span>
          <i class="fa fa-sync-alt"></i>
          Generate
        </span>
      </b-button>
    </span>
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'Password',
  props: {
    type: { type: String, default: 'text' },
    size: { type: String, default: '32' },
    characters: { type: String, default: 'a-z,A-Z,0-9,#' },
    placeholder: { type: String, default: 'Password' },
    disabled: { type: Boolean, default: false },
    error: { type: Object },
    value: ''
  },
  data() {
    return {
      password: this.value
    };
  },
  methods: {
    generate() {
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
    handleData() {
      this.$emit('input', this.password);
    }
  }
};
</script>