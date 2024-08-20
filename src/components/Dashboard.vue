
<template>
  <div class="dashboard">
    <aside class="sidebar">
      <div class="logo">
        <!-- Ganti dengan logo Anda -->
        <img src="@/assets/logo.png" alt="Logo" />
      </div>
      <div class="search-bar">
        <input type="text" placeholder="Cari..." />
        <button class="search-button">🔍</button>
      </div>
      <ul class="menu">
        <li @click="navigateTo('dashboardhome')">📊 Dashboard</li>
        <li @click="navigateTo('transactions')">💳 Transaksi</li>
        <li @click="navigateTo('financials')">📈 Laporan Keuangan</li>
        <li @click="navigateTo('debt-credit')">💰 Hutang Piutang</li>
      </ul>
      <div class="user-info">
        <img src="https://via.placeholder.com/150" alt="Avatar Pengguna" class="user-avatar" />
        <span class="user-name"> Awie Chitato </span>
      </div>
      <div class="settings">
        <button @click="navigateTo('settings')">⚙️ Pengaturan</button>
        <button @click="handleLogout">🚪 Keluar</button>
      </div>
    </aside>
    <main class="content">
      <header class="content-header">
        <h1>{{ pageTitle }}</h1>
        <div class="quick-actions">
          <button @click="showNotifications">🔔</button>
          <button @click="showHelp">❓</button>
        </div>
      </header>
      <router-view />
    </main>
  </div>
</template>

<script>
export default {
  data() {
    return {
      pageTitle: 'Dashboard'
    }
  },
  methods: {
    navigateTo(route) {
      this.$router.push(`/dashboard/${route}`);
      this.updatePageTitle(route);
    },
    handleLogout() {
      localStorage.removeItem('authToken');
      this.$router.push('/');
      alert('Anda telah keluar!');
    },
    updatePageTitle(route) {
      const titles = {
        'dashboardhome': 'Dashboard',
        'transactions': 'Transaksi',
        'financials': 'Laporan Keuangan',
        'debt-credit': 'Hutang Piutang',
        'inventory': 'Inventaris',
        'reports': 'Laporan',
        'settings': 'Pengaturan'
      };
      this.pageTitle = titles[route] || 'Dashboard';
    },
    showNotifications() {
      alert('Fitur notifikasi akan segera hadir!');
    },
    showHelp() {
      alert('Fitur bantuan akan segera hadir!');
    }
  }
};
</script>

<style scoped>
.dashboard {
  display: flex;
  height: 100vh;
  color: hsl(0, 0%, 4%);
}

.sidebar {
  width: 250px;
  background-color: #0274d1;
  padding: 20px;
  box-shadow: 2px 0 5px rgba(10, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  position: relative;
}

.logo img {
  width: 100px;
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
  border: 1px solid hsl(194, 100%, 42%);
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
  color: white;
}

.menu li:hover {
  background-color: rgba(255, 255, 255, 0.1);
}

.menu li svg {
  margin-right: 10px;
}

.user-info {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
  padding: 10px;
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 4px;
}

.user-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  margin-right: 10px;
}

.user-name {
  color: white;
  font-weight: bold;
}

.settings {
  margin-top: auto;
}

.settings button {
  width: 100%;
  padding: 10px;
  border: none;
  background-color: rgba(255, 255, 255, 0.1);
  color: white;
  cursor: pointer;
  transition: background-color 0.3s;
  margin-bottom: 10px;
  border-radius: 4px;
}

.settings button:hover {
  background-color: rgba(255, 255, 255, 0.2);
}

.content {
  flex: 1;
  padding: 20px;
  background-color: #f4f4f4;
  overflow-y: auto;
}

.content-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  padding-bottom: 10px;
  border-bottom: 1px solid #ddd;
}

.quick-actions button {
  background-color: transparent;
  border: none;
  font-size: 24px;
  cursor: pointer;
  margin-left: 10px;
}

@media (max-width: 768px) {
  .dashboard {
    flex-direction: column;
  }

  .sidebar {
    width: 100%;
    box-shadow: none;
    padding: 10px;
  }

  .content {
    padding: 10px;
  }

  .content-header {
    flex-direction: column;
    align-items: flex-start;
  }

  .quick-actions {
    margin-top: 10px;
  }
}
</style>
