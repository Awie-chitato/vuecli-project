<template>
  <table class="transaction-table">
    <thead>
      <tr>
        <th>Kategori</th>
        <th>Nominal</th>
        <th>Jatuh Tempo</th>
        <th>Deskripsi</th>
        <th>Pihak Kedua</th>
        <th>Metode Pembayaran</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(item, index) in combinedDebtCredits" :key="index">
        <td>{{ item.kategori }}</td>
        <td>{{ item.nominal }}</td>
        <td>{{ item.tanggal }}</td>
        <td>{{ item.deskripsi }}</td>
        <td>{{ item.pihak_kedua }}</td>
        <td>{{ item.metode_pembayaran }}</td>
        <td>{{ item.status }}</td>
      </tr>
    </tbody>
  </table>
</template>

<script>
import axios from 'axios';

export default {
  name: 'HpUser',
  data() {
    return {
      combinedDebtCredits: [],
    };
  },
  methods: {
    fetchDebtCredits() {
      axios
        .get('http://127.0.0.1:8000/api/show-semua-hp')
        .then((response) => {
          this.combinedDebtCredits = response.data.data;
        })
        .catch((error) => {
          console.error('Error fetching debt credits:', error.response ? error.response.data : error.message);
        });
    },
  },
  mounted() {
    this.fetchDebtCredits();
  },
};
</script>

<style scoped>
.transaction-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  background: linear-gradient(#1E1E2E, #1E1E2E); /* Background ungu tua kehitaman */
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.transaction-table th, 
.transaction-table td {
  padding: 15px;
  text-align: left;
  border-bottom: 1px solid #e0e0e0;
}

.transaction-table th {
  background: linear-gradient(#00D2FF, #3A7BD5); /* Background biru cerah ke biru tua */
  color: #EAEAEA; /* Text abu terang */
  font-weight: bold;
  text-transform: uppercase;
}

.transaction-table tr:hover {
  background: linear-gradient(#f1f1f1, #f1f1f1); /* Background hover */
  transition: background 0.3s ease;
}

.transaction-table tr:nth-child(even) {
  background: linear-gradient(#f4f7fc, #f4f7fc); /* Background even row */
}

.transaction-table td {
  font-size: 14px;
  color: #333;
}

.transaction-table td:first-child {
  font-weight: bold;
}
</style>