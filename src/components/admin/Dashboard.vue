<template>
  <div class="dashboard flex h-screen bg-gradient-to-br from-purple-400 to-purple-700">
    <aside class="sidebar w-64 bg-purple bg-opacity-10 backdrop-filter backdrop-blur-lg p-5 flex flex-col">
      <div class="logo">
        <!-- Logo FPTI yang diubah menjadi bulat dan di-zoom -->
        <img src="@/assets/fpti_indonesia.png" alt="Logo FPTI" class="logo-image rounded-full w-10 h-10 mx-auto mb-2 shadow-lg" />
      </div>
      <ul class="menu space-y-4">
        <li @click="navigateTo('dashboardhome')" class="text-white py-2 px-4 rounded-lg bg-opacity-20 hover:bg-blue-200 hover:bg-opacity-30 cursor-pointer transition">
          Dashboard
        </li>
        <li @click="navigateTo('eventlist')" class="text-white py-2 px-4 rounded-lg bg-opacity-20 hover:bg-blue-200 hover:bg-opacity-30 cursor-pointer transition">
          Event
        </li>
        <li @click="navigateTo('transactions')" class="text-white py-2 px-4 rounded-lg bg-opacity-20 hover:bg-blue-200 hover:bg-opacity-30 cursor-pointer transition">
          Transaksi
        </li>
        <li @click="navigateTo('debt-credit')" class="text-white py-2 px-4 rounded-lg bg-opacity-20 hover:bg-blue-200 hover:bg-opacity-30 cursor-pointer transition">
          Hutang Piutang
        </li>
        <li @click="navigateTo('financials')" class="text-white py-2 px-4 rounded-lg bg-opacity-20 hover:bg-blue-200 hover:bg-opacity-30 cursor-pointer transition">
          Laporan Keuangan
        </li>
      </ul>
      <div class="settings mt-auto">
        <!-- <button @click="navigateTo('settings')" class="w-full py-2 px-4 rounded-lg bg-blue-500 hover:bg-blue-600 text-white mb-2">
          ⚙️ Pengaturan
        </button> -->
        <button @click="handleLogout" class="w-full py-2 px-4 rounded-lg bg-red-500 hover:bg-red-600 text-white">
          🚪 logout
        </button>
      </div>
    </aside>
    <main class="content flex-1 p-6 bg-color-purple bg-opacity-10 backdrop-filter backdrop-blur-lg overflow-y-auto" style="background-color: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
      <header class="content-header flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">{{ pageTitle }}</h1>
        <div class="quick-actions flex items-center">
          <img src="https://via.placeholder.com/150" alt="Avatar Pengguna" class="user-avatar rounded-full w-12 h-12 shadow-lg" />
          <span class="user-name text-white ml-4"> ADMIN </span>
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
      pageTitle: 'Dashboard',
      events: [
        { id: 1, name: 'Konser Musik', date: '2023-07-15' },
        { id: 2, name: 'Pameran Seni', date: '2023-07-20' }
      ],
      venues: [
        { id: 1, name: 'Gedung Serbaguna', location: 'Jakarta' },
        { id: 2, name: 'Lapangan Merdeka', location: 'Surabaya' }
      ],
      transactions: [
        { id: 1, description: 'Pembayaran Tiket', amount: 500000 },
        { id: 2, description: 'Sewa Tempat', amount: 2000000 }
      ],
      balance: 10000000,
      cashIn: 5000000,
      cashOut: 3000000,
      totalDebt: 1500000,
      totalCredit: 2500000
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
        'eventlist': 'Event',
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
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(135deg, #1E1E2E, #1E1E2E);
}

.sidebar {
  width: 250px;
  background-color: #1E1E2E;
  padding: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
  display: flex;
  flex-direction: column;
  position: relative;
  height: 100vh; /* Full height for sidebar */
  overflow-y: auto; /* Allows sidebar to scroll if content overflows */
  transition: transform 0.3s ease;
}

.sidebar:hover {
  transform: translateX(0);
}

.logo {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 20px;
}

.logo-image {
  width: 120px;
  height: 120px;
  padding: 10px;
  margin-top: 10px;
  border-radius: 30%;
  object-fit: cover;
  object-position: center;
  border: 4px solid #fff;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
  transition: transform 0.3s ease;
}

.logo-image:hover {
  transform: scale(1.1);
}

.settings {
  margin-bottom: 20px; /* Space between settings and menu */
}

.settings button {
  width: 100%;
  padding: 10px;
  border: none;
  background-color: #fff;
  color: #1E1E2E;
  cursor: pointer;
  transition: background-color 0.3s, transform 0.3s;
  margin-top: -100px;
  margin-bottom: 10px;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.settings button:hover {
  background-color: rgba(255, 255, 255, 0.8);
  transform: scale(1.05);
}

.menu {
  list-style: none;
  padding: 0;
  margin-bottom: auto; /* Ensures menu is pushed to the bottom if settings are not enough */
}

.menu li {
  margin-bottom: 10px;
  cursor: pointer;
  padding: 10px;
  border-radius: 4px;
  display: flex;
  align-items: center;
  transition: background-color 0.3s, transform 0.3s;
  color: #fff;
  font-weight: bold;
}

.menu li:hover {
  background-color: rgba(255, 255, 255, 0.1);
  transform: translateX(5px);
}

.content {
  flex: 1;
  padding: 20px;
  background-color: rgba(255, 255, 255, 0.1); /* Warna keren untuk glassmorphism */
  box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
  overflow-y: auto; /* Allows content to scroll if it overflows */
  transition: background-color 0.3s;
}

.content-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  padding-bottom: 10px;
  border-bottom: 2px solid #ddd;
}
.content-header {
  font-size: 10px;
}

.quick-actions {
  display: flex;
  align-items: center;
}

.user-avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  margin-right: 10px;
  transition: transform 0.3s;
}

.user-avatar:hover {
  transform: scale(1.1);
}

.user-name {
  color: #EAEAEA;
  font-weight: bold;
}

.dashboard-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
}

.card {
  background-color: #1E1E2E;
  border-radius: 8px;
  padding: 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  transition: box-shadow 0.3s, transform 0.3s;
}

.card:hover {
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
  transform: translateY(-5px);
}

.card h2 {
  margin-bottom: 15px;
  color: #EAEAEA;
}

.card ul {
  list-style-type: none;
  padding: 0;
}

.card li {
  margin-bottom: 10px;
}

.balance {
  font-size: 24px;
  font-weight: bold;
  color: #EAEAEA;
}

@media (max-width: 768px) {
  .dashboard {
    flex-direction: column;
  }

  .sidebar {
    width: 100%;
    box-shadow: none;
    padding: 10px;
    height: auto; /* Auto height on small screens */
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

  .dashboard-content {
    grid-template-columns: 1fr;
  }
}

</style>
