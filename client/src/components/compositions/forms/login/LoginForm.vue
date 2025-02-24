<template>
  <form class="login_form" @submit.prevent="submit">
    <BaseInput v-model="userName" label="Username" />
    <BaseInput v-model="password" label="Password" type="password" />
    <BaseButton type="submit" fullWidth>Log in</BaseButton>
    <div v-if="error" class="error-message">{{ error }}</div>
  </form>
</template>

<script>
// COMPONENTS
import BaseInput from '@/components/base/input/BaseInput.vue'
import BaseButton from '@/components/base/button/BaseButton.vue'

export default {
  name: 'LoginForm',
  emits: ['submit'],
  components: {
    BaseInput,
    BaseButton
  },
  props: {
    error: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      userName: '',
      password: ''
    }
  },
  methods: {
    submit() {
      console.log('submit', {
        userName: this.userName,
        password: this.password
      })
      this.$emit('submit', {
        userName: this.userName,
        password: this.password
      })
    }
  }
}
</script>

<style lang="scss" scoped>
@import '@/utilities/css/vars/vars.scss';
.login_form {
  width: 60%;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
  color: $ESSENTIALS_BLUE2;
  margin-block-start: 50px;
}

.error-message {
  box-sizing: border-box;
  color: crimson;
  margin-top: 12px;
  font-size: 0.875rem;
  text-align: center;
  padding: 8px 16px;
  background-color: rgba(255, 59, 59, 0.1);
  border-radius: 4px;
  width: 100%;
  font-weight: 500;
}
</style>
