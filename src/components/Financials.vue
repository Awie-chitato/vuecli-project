<template>
  <div class="Financials">
    <h2>Laporan Keuangan</h2>
    <div class="financial-categories">
      <div class="category" @click="showCategory('realisasi')">
        <img src="@/assets/realisasi-icon.png" alt="Realisasi Anggaran" class="category-icon">
        <span>Realisasi Anggaran</span>
      </div>
      <div class="category" @click="showCategory('catatan')">
        <img src="@/assets/catatan-icon.png" alt="Catatan Transaksi" class="category-icon">
        <span>Catatan Transaksi</span>
      </div>
      <div class="category" @click="showCategory('arusKas')">
        <img src="@/assets/arus-kas-icon.png" alt="Arus Kas" class="category-icon">
        <span>Arus Kas</span>
      </div>
      <div class="category" @click="showCategory('operasional')">
        <img src="@/assets/operasional-icon.png" alt="Operasional" class="category-icon">
        <span>Operasional</span>
      </div>
      <div class="category" @click="showCategory('bukuBesar')">
        <img src="@/assets/buku-besar-icon.png" alt="Buku Besar" class="category-icon">
        <span>Buku Besar</span>
      </div>
    </div>
    
    <div v-if="selectedCategory === 'bukuBesar'">
      <div class="filter-section">
        <button @click="toggleFilter" class="filter-button">Filter By</button>
        <div v-if="showFilter" class="filter-options">
          <select v-model="selectedName">
            <option value="">Pilih Nama</option>
            <option v-for="name in names" :key="name" :value="name">{{ name }}</option>
          </select>
          <select v-model="selectedMonth">
            <option value="">Pilih Bulan</option>
            <option v-for="month in months" :key="month" :value="month">{{ month }}</option>
          </select>
          <select v-model="selectedYear">
            <option value="">Pilih Tahun</option>
            <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
          </select>
        </div>
      </div>
      <table class="financial-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Bulan</th>
            <th>Tahun</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in filteredData" :key="index">
            <td>{{ index + 1 }}</td>
            <td>{{ item.nama }}</td>
            <td>{{ item.bulan }}</td>
            <td>{{ item.tahun }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Financials',
  data() {
    return {
      showFilter: false,
      selectedName: '',
      selectedMonth: '',
      selectedYear: '',
      names: ['John Doe', 'Jane Smith', 'Bob Johnson'],
      months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
      years: [2021, 2022, 2023],
      financialData: [
        { nama: 'John Doe', bulan: 'Januari', tahun: 2023 },
        { nama: 'Jane Smith', bulan: 'Februari', tahun: 2023 },
        { nama: 'Bob Johnson', bulan: 'Maret', tahun: 2023 },
      ],
      selectedCategory: null
    };
  },
  computed: {
    filteredData() {
      return this.financialData.filter(item => {
        return (!this.selectedName || item.nama === this.selectedName) &&
               (!this.selectedMonth || item.bulan === this.selectedMonth) &&
               (!this.selectedYear || item.tahun === this.selectedYear);
      });
    }
  },
  methods: {
    toggleFilter() {
      this.showFilter = !this.showFilter;
    },
    showCategory(category) {
      this.selectedCategory = category;
    }
  }
};
</script>

<style scoped>
.Financials {
  padding: 20px;
}

.financial-categories {
  display: flex;
  justify-content: space-around;
  margin-bottom: 20px;
}

.category {
  display: flex;
  flex-direction: column;
  align-items: center;
  cursor: pointer;
  transition: transform 0.3s ease;
}

.category:hover {
  transform: scale(1.1);
}

.category-icon {
  width: 50px;
  height: 50px;
  margin-bottom: 10px;
}

.filter-section {
  text-align: right;
  margin-bottom: 20px;
}

.filter-button {
  padding: 10px 20px;
  background-color: #0066cc;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.filter-options {
  margin-top: 10px;
}

.filter-options select {
  margin-left: 10px;
  padding: 5px;
}

.financial-table {
  width: 100%;
  border-collapse: collapse;
}

.financial-table th, .financial-table td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

.financial-table th {
  background-color: #f2f2f2;
  font-weight: bold;
}
</style>