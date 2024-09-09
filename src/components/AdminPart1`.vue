<template>
  <div class="mac-book-pro-16-13">
    <div class="selamat-datang">Selamat Datang..!</div>
    <img
      class="png-transparent-man-climbing-on-cliff-illustration"
      src="@/assets/panjat_tebing.png"
      alt="Ilustrasi Panjat Tebing"
    />
    <div class="rectangle-4"></div>
    <div class="masuk-sebagai-admin">Masuk Sebagai Admin</div>
    <div class="email-username">Email / Username</div>
    <input v-model="username" class="rectangle-1" type="text" placeholder="Masukkan email atau username">
    <input v-model="password" class="rectangle-2" type="password" placeholder="Masukkan password">
    <div class="password">Password</div>
    <div class="fpti">FPTI</div>
    <button @click="handleSubmit" class="rectangle-4145">
      <span class="masuk">Masuk</span>
    </button>
  </div>
</template>

<script>
export default {
  name: "MacBookPro1613",
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
.mac-book-pro-16-13,
.mac-book-pro-16-13 * {
  box-sizing: border-box;
}
.mac-book-pro-16-13 {
  background: rgba(255, 255, 255, 0.42);
  height: 100vh;
  width: 100vw;
  position: relative;
  overflow: hidden;
}
.group-1 {
  position: absolute;
  inset: 0;
}
.selamat-datang {
  color: #000000;
  text-align: center;
  font-family: "Inter-Bold", sans-serif;
  font-size: 3vw;
  line-height: 1.2;
  letter-spacing: 0.1px;
  font-weight: 700;
  position: absolute;
  left: 15%;
  top: 37%;
  width: 25%;
  display: flex;
  align-items: center;
  justify-content: center;
  -webkit-text-stroke: 1px #000000;
}
.png-transparent-man-climbing-on-cliff-illustration {
  width: 40%;
  height: auto;
  position: absolute;
  right: 0;
  top: 0;
  object-fit: contain;
  max-height: 100vh;
}
.rectangle-4 {
  background: var(--atas, #b3c8cf);
  border-radius: 43px;
  width: 40%;
  height: 70%;
  position: absolute;
  left: 10%;
  top: 15%;
  box-shadow: 4px 9px 15.9px 3px rgba(0, 0, 0, 0.25);
}
.masuk-sebagai-admin {
  color: #5e5a5a;
  text-align: center;
  font-family: "Inter-Regular", sans-serif;
  font-size: 1.2vw;
  line-height: 1.2;
  letter-spacing: 3px;
  font-weight: 400;
  position: absolute;
  left: 22%;
  top: 26%;
  width: 15%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.email-username {
  color: #000000;
  text-align: center;
  font-family: "Roboto-SemiBold", sans-serif;
  font-size: 1vw;
  line-height: 1.2;
  letter-spacing: 0.5px;
  font-weight: 600;
  position: absolute;
  left: 17%;
  top: 38%;
  width: 8%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.rectangle-1, .rectangle-2 {
  background: #d9d9d9;
  border-radius: 15px;
  border: 1px solid #000000;
  width: 26%;
  height: 5%;
  position: absolute;
  left: 16%;
  box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
  padding: 0 10px;
  font-size: 1vw;
}
.rectangle-1 {
  top: 40%;
}
.rectangle-2 {
  top: 50%;
}
.password {
  color: #000000;
  text-align: center;
  font-family: "Roboto-SemiBold", sans-serif;
  font-size: 1vw;
  line-height: 1.2;
  letter-spacing: 0.5px;
  font-weight: 600;
  position: absolute;
  left: 17%;
  top: 48%;
  width: 5%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.fpti {
  color: #000000;
  text-align: center;
  font-family: "Podkova-Bold", sans-serif;
  font-size: 3.5vw;
  line-height: 1.2;
  letter-spacing: 0.1px;
  font-weight: 700;
  position: absolute;
  left: 24%;
  top: 18%;
  width: 12%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.rectangle-4145 {
  background: #00cbf3;
  border-radius: 20px;
  width: 15%;
  height: 6%;
  position: absolute;
  left: 22%;
  top: 57%;
  border: none;
  cursor: pointer;
}
.masuk {
  color: #000000;
  text-align: center;
  font-family: "Roboto-SemiBold", sans-serif;
  font-size: 1vw;
  line-height: 1.2;
  letter-spacing: 0.5px;
  font-weight: 600;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>