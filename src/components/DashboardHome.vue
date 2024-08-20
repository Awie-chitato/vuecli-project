<template>
  <div class="dashboard-home">
    <h2 class="dashboard-title">Dashboard</h2>
    <div class="saldo-summary">
      <div class="saldo-card">
        <div class="icon-container">
          <i class="fas fa-arrow-circle-up"></i>
        </div>
        <h3>Saldo Masuk</h3>
        <p class="saldo-masuk"><i class="fas fa-arrow-right"></i> Lihat detail saldo masuk</p>
      </div>
      <div class="saldo-card">
        <div class="icon-container">
          <i class="fas fa-arrow-circle-down"></i>
        </div>
        <h3>Saldo Keluar</h3>
        <p class="saldo-keluar"><i class="fas fa-arrow-right"></i> Lihat detail saldo keluar</p>
      </div>
    </div>
    <div class="laporan-keuangan">
      <h3>Laporan Keuangan</h3>
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Event</th>
            <th>Bulan</th>
            <th>Tahun</th>
            <th>Pemasukan</th>
            <th>Pengeluaran</th>
            <th>Saldo</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>event panjat tebing A</td>
            <td>Mei</td>
            <td>2023</td>
            <td>Rp 1.500.000</td>
            <td>-</td>
            <td>Rp 1.500.000</td>
          </tr>
          <tr>
            <td>2</td>
            <td>event panjat pohon pinang</td>
            <td>Mei</td>
            <td>2023</td>
            <td>-</td>
            <td>Rp 500.000</td>
            <td>Rp 1.000.000</td>
          </tr>
          <tr>
            <td>3</td>
            <td>event panjat pohon durian</td>
            <td>Mei</td>
            <td>2023</td>
            <td>Rp 2.000.000</td>
            <td>-</td>
            <td>Rp 3.000.000</td>
          </tr>
          <tr>
            <td>4</td>
            <td>event panjat pohon siwalan</td>
            <td>Mei</td>
            <td>2023</td>
            <td>-</td>
            <td>Rp 1.000.000</td>
            <td>Rp 2.000.000</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4">Total</td>
            <td>Rp 3.500.000</td>
            <td>Rp 1.500.000</td>
            <td>Rp 2.000.000</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DashboardHome',
  data() {
    return {
      // Data untuk saldo dan laporan keuangan bisa ditambahkan di sini
    }
  }
};
</script>

<style scoped>
.dashboard-home {
  padding: 20px;
  background: linear-gradient(135deg, #e6f2ff, #ffffff);
  border-radius: 20px;
  border: 1px solid rgba(0, 102, 204, 0.18);
  box-shadow: 0 8px 32px 0 rgba(0, 102, 204, 0.37);
}

.dashboard-title {
  color: #0066cc;
  text-align: center;
  margin-bottom: 30px;
  font-size: 2.5em;
  text-shadow: 2px 2px 4px rgba(0, 102, 204, 0.1);
}

.saldo-summary {
  display: flex;
  justify-content: space-between;
  margin-bottom: 30px;
}

.saldo-card {
  width: 48%;
  background: #ffffff;
  border-radius: 15px;
  padding: 20px;
  box-shadow: 0 4px 6px rgba(0, 102, 204, 0.1);
  text-align: center;
  transition: transform 0.3s ease;
}

.saldo-card:hover {
  transform: translateY(-5px);
}

.icon-container {
  font-size: 3em;
  color: #0066cc;
  margin-bottom: 15px;
}

.saldo-masuk {
  color: green;
}

.saldo-keluar {
  color: red;
}

table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  border: none;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 102, 204, 0.1);
  background: #ffffff;
}

th, td {
  border: none;
  padding: 12px;
  text-align: left;
}

th {
  background-color: #e6f2ff;
  font-weight: bold;
  color: #0066cc;
}

tbody tr:nth-child(even) {
  background-color: #f0f8ff;
}

tfoot {
  font-weight: bold;
  background-color: #e6f2ff;
}

h3 {
  margin-bottom: 15px;
  color: #0066cc;
  font-size: 1.5em;
}

.laporan-keuangan {
  margin-top: 30px;
  background: #ffffff;
  border-radius: 15px;
  padding: 20px;
  box-shadow: 0 4px 6px rgba(0, 102, 204, 0.1);
}

tbody tr:hover {
  background-color: #cce6ff;
  transition: background-color 0.3s ease;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.saldo-card {
  animation: fadeIn 0.5s ease-out;
}

.laporan-keuangan {
  animation: fadeIn 0.5s ease-out 0.3s;
  animation-fill-mode: both;
}
</style>