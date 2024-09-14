<template>
  <div class="login-container">
    <div class="login-box">
    <h1>Login</h1>
    <form @submit.prevent="login">
        <div class="input-box">
          <input type="text" v-model="username" required />
          <label>Username</label>
        </div>
        <div class="input-box">
          <input type="password" v-model="password" required />
          <label>Password</label>
        </div>
        <button type="submit" class="login-button">Login</button>
      </form>

    <p v-if="errorMessage" style="color: red;">{{ errorMessage }}</p>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      username: '',
      password: '',
      errorMessage: '',
    };
  },
  methods: {
    login() {
      // Simulasi login dengan data yang disimpan di localStorage
      const storedUser = JSON.parse(localStorage.getItem('users')) || [];
      
      // Cek jika username dan password cocok dengan data yang disimpan
      const user = storedUser.find(u => u.username === this.username && u.password === this.password);

      if (user) {
        if (user.role === 'admin') {
          this.$router.push({ name: 'admin-home' }); // Redirect ke halaman admin jika login sebagai admin
        } else if (user.role === 'user') {
          this.$router.push({ name: 'user-home' }); // Redirect ke halaman user jika login sebagai user
        }
      } else {
        this.errorMessage = 'Invalid username or password';
      }
    }
  },
  mounted() {
    // Simulasi pendaftaran pengguna untuk demo
    if (!localStorage.getItem('users')) {
      const users = [
        { username: 'admin', password: 'admin123', role: 'admin' },
        { username: 'user', password: 'user123', role: 'user' }
      ];
      localStorage.setItem('users', JSON.stringify(users));
    }
  }
};
</script>

<style scoped>
/* Background untuk seluruh halaman */
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: linear-gradient(to right, #00c6ff, #0072ff);
  background-size: cover;
  position: relative;
}

/* Kotak login dengan efek Glassmorphism */
.login-box {
  background: rgba(255, 255, 255, 0.1); /* Transparansi */
  backdrop-filter: blur(10px); /* Efek blur */
  border-radius: 20px;
  padding: 40px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2); /* Bayangan halus */
  text-align: center;
  width: 300px;
}

/* Judul login */
.login-box h2 {
  color: white;
  margin-bottom: 20px;
  font-size: 24px;
  letter-spacing: 1px;
}

/* Input dan label pada form login */
.input-box {
  position: relative;
  margin-bottom: 30px;
}

.input-box input {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  background: none;
  border: none;
  border-bottom: 2px solid white;
  color: white;
  outline: none;
}

.input-box label {
  position: absolute;
  top: -30px;
  left: 0;
  padding: 10px 0;
  font-size: 16px;
  color: rgb(7, 7, 7);
  pointer-events: none;
  transition: 0.5s;
}

/* Animasi label ketika input fokus */
.input-box input:focus ~ label,
.input-box input:valid ~ label {
  top: -20px;
  left: 0;
  color: #00c6ff;
  font-size: 12px;
}

/* Tombol login dengan efek hover */
.login-button {
  background: rgba(0, 198, 255, 0.5);
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 20px;
  cursor: pointer;
  transition: background 0.3s ease;
  width: 100%;
  font-size: 16px;
}

.login-button:hover {
  background: rgba(0, 198, 255, 0.8);
}
</style>
