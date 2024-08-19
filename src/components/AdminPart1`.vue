<template>
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
html, body {
  height: 100%;
  width: 50px;
  margin: 50px;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #f0f0f0;
}


.AdminPart1 {
  max-width: 400px;
  width: 100%;
  padding: 20px;
  border: 1px solid hsl(221, 51%, 46%);
  border-radius: 8px;
  box-shadow: 0 0 20px rgba(63, 116, 196, 0.274);
  background-color: #fff;
  display: flex;
  flex-direction: column;
  align-items: center;
  margin: auto;
  margin-top: 160px;
}

.input-group {
  margin-bottom: 15px;
}

label {
  display: block;
  margin-bottom: 5px;
}

input {
  width: 100%; /* Full width of parent container */
  padding: 8px;
  box-sizing: border-box;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  width: 100%;
  padding: 10px;
  background-color: #00428d;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #00428d;
}
</style>