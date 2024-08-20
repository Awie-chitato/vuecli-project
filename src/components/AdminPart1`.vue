<template>
  <div class="admin-container">
    <div class="AdminPart1">
      <h2>Admin Login</h2>
      <form @submit.prevent="handleSubmit">
        <div class="input-group">
          <label for="username">Username</label>
          <input v-model="username" type="text" id="username" required />
        </div>
        <div class="input-group">
          <label for="password">Password</label>
          <input v-model="password" type="password" id="password" required />
        </div>
        <button type="submit">Admin Login</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      username: '',
      password: ''
    };
  },
  methods: {
    handleSubmit() {
      // Implementasi proses login di sini
      if (this.username === 'admin' && this.password === 'admin123') {
        alert('Login berhasil!');
        // Redirect ke halaman dashboard atau halaman lain
        this.$router.push('/dashboard');
      } else {
        alert('Username atau password salah');
      }
    }
  }
};
</script>

<style scoped>
.admin-container {
  height: 100vh;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  background: linear-gradient(to right, #ffffff 50%, #03a9f4 50%);
}

.AdminPart1 {
  max-width: 400px;
  width: 100%;
  padding: 30px;
  border-radius: 15px;
  background: rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(10px);
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
  border: 1px solid rgba(255, 255, 255, 0.18);
}

h2 {
  color: #000000;
  text-align: center;
  margin-bottom: 20px;
}

.input-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 8px;
  color: #000000;
}

input {
  width: 100%;
  padding: 10px;
  box-sizing: border-box;
  border: none;
  border-radius: 8px;
  background: rgba(255, 255, 255, 0.3);
  backdrop-filter: blur(5px);
}

button {
  width: 100%;
  padding: 12px;
  background-color: #03a9f4;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #0288d1;
}
</style>