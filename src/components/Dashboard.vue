<template>
    <div class="dashboard">
      <aside class="sidebar">
        <div class="logo">
          <!-- Ganti dengan logo Anda -->
          <img src="@/assets/logo.png" alt="Logo" />
        </div>
        <div class="search-bar">
          <input type="text" placeholder="Search..." />
          <button class="search-button">🔍</button>
        </div>
        <ul class="menu">
          <li @click="navigateTo('dashboardhome')">📊 Dashboard</li>
          <li @click="navigateTo('transactions')">💳 Transaksi</li>
          <li @click="navigateTo('financials')">📈 Laporan Keuangan</li>
          <li @click="navigateTo('debt-credit')">💰 Hutang Piutang</li>
        </ul>
        <div class="settings">
          <button @click="navigateTo('settings')">⚙️ Settings</button>
          <button @click="handleLogout">🚪 Logout</button>
        </div>
      </aside>
      <main class="content">
        <router-view />
      </main>
    </div>
  </template>
  
  <script>
  export default {
    methods: {
      navigateTo(route) {
        this.$router.push(`/dashboard/${route}`);
      },
      handleLogout() {
        // Logika logout, seperti menghapus token atau mereset status autentikasi
        // Misalnya, menghapus token dari localStorage
        localStorage.removeItem('authToken'); // Ganti dengan mekanisme penyimpanan token yang sesuai

        // Redirect ke halaman login
        this.$router.push('/');
        alert('Logged out!');

      }
    }
  };
  </script>
  
  <style scoped>
  .dashboard {
    display: flex;
    height: 100vh;
  }
  
  .sidebar {
    width: 250px;
    background-color: #f4f4f4;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    position: relative;
  }
  
  .logo img {
    width: 100px; /* Sesuaikan ukuran logo */
    margin-bottom: 20px;
  }
  
  .search-bar {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
  }
  
  .search-bar input {
    flex: 1;
    padding: 5px;
    border-radius: 4px;
    border: 1px solid #ccc;
  }
  
  .search-button {
    background-color: transparent;
    border: none;
    cursor: pointer;
    font-size: 18px;
  }
  
  .menu {
    list-style: none;
    padding: 0;
    margin-bottom: auto;
  }
  
  .menu li {
    margin-bottom: 10px;
    cursor: pointer;
    padding: 10px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    transition: background-color 0.3s;
  }
  
  .menu li:hover {
    background-color: #ddd;
  }
  
  .menu li svg {
    margin-right: 10px;
  }
  
  .settings {
    margin-top: auto;
  }
  
  .settings button {
    width: 100%;
    padding: 10px;
    border: none;
    background-color: #f4f4f4;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  
  .settings button:hover {
    background-color: #ddd;
  }
  
  .content {
    flex: 1;
    padding: 20px;
  }
  </style>
  
  