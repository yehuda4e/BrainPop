<template>
  <div class="login_container">
    <LoginScreen 
      @submit="submit($event)"
      :error="errorMessage"
    ></LoginScreen>
  </div>
</template>

<script>
// SCREEN
import LoginScreen from '@/components/screens/login/LoginScreen.vue'
//STORE
import { useUserStore } from '@/stores/user'
export default {
  name: 'Login',
  components: {
    LoginScreen
  },
  data() {
    return {
      errorMessage: ''
    }
  },
  methods: {
    async submit(credentials) {
      console.log('credentials', credentials)
      const store = useUserStore()
      try {
        this.errorMessage = '' // Clear any previous error
        const response = await fetch('http://localhost:3000/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            email: credentials.userName,
            password: credentials.password
          })
        });
        const data = await response.json();
        if (data.access_token) {
          store.login(() => {
            this.$router.push({ name: 'home' })
          })
        } else {
          this.errorMessage = 'Invalid credentials'
        }
      } catch (error) {
        this.errorMessage = 'An error occurred during login'
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.login_container {
  display: flex;
  justify-content: center;
  align-items: center;
  background: #f5f5f5;
  height: 100vh;
}
.login_content {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  width: 100%;
  max-width: 782px;
  background: #fff;
  box-shadow: 0px 4px 4px 3px rgba(185, 185, 185, 0.2509803922);
  flex-direction: column;
  padding: 35px 0;
  height: -webkit-fill-available;
}
</style>
