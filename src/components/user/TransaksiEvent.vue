<template>
    <table class="transaction-table">
      <thead>
        <tr>
          <th>Nama Event</th>
          <th>Nominal</th>
          <th>Tanggal</th>
          <th>Deskripsi</th>
          <th>Metode Pembayaran</th>
          <th>Status</th>
          <th>Jenis Transaksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(transaction, index) in combinedTransactions" :key="index">
          <!-- Menggunakan method getEventName untuk mendapatkan nama event -->
          <td>{{ getEventName(transaction.event_id) }}</td>
          <td>{{ transaction.nominal }}</td>
          <td>{{ transaction.tanggal }}</td>
          <td>{{ transaction.deskripsi }}</td>
          <td>{{ transaction.metode_pembayaran }}</td>
          <td>{{ transaction.status }}</td>
          <td>{{ transaction.jenis_transaksi }}</td>
        </tr>
      </tbody>
    </table>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        showInputForm: false,
        showTransactionTypeModal: false,
        editMode: false,
        selectedTransactionType: '',
        newTransaction: {
          id: null,
          nama_event: '',
          nominal: '',
          tanggal: '',
          deskripsi: '',
          metode_pembayaran: '',
          status: '',
          jenis_transaksi: ''
        },
        combinedTransactions: [],
        events: []
      };
    },
    methods: {
      fetchTransactions() {
        axios.get('http://127.0.0.1:8000/api/show-dua-transaksi')
          .then(response => {
            if (response.data.success) {
              this.combinedTransactions = response.data.data
                .map(item => {
                  return {
                    ...item,
                  };
                })
                .sort((a, b) => new Date(b.tanggal) - new Date(a.tanggal)); // Mengurutkan berdasarkan tanggal terbaru
            } else {
              console.error('Respon gagal:', response.data.message);
            }
          })
          .catch(error => {
            console.error('Terjadi kesalahan saat mengambil data transaksi:', error);
          });
      },
      fetchEvents() {
        axios.get('http://127.0.0.1:8000/api/show-semua-event-fpti')
          .then(response => {
            if (response.data.success) {
              this.events = response.data.data;
            } else {
              console.error('Respon gagal:', response.data.message);
            }
          })
          .catch(error => {
            console.error('Terjadi kesalahan saat mengambil data event:', error);
          });
      },
      getEventName(eventId) {
        const event = this.events.find(e => e.id === eventId);
        return event ? event.nama_event : 'Nama_Event'; // Tampilkan nama event jika ditemukan
      },
      editItem(transaction) {
        this.editMode = true;
        this.showInputForm = true;
        this.newTransaction = { ...transaction };
        this.selectedTransactionType = transaction.jenis_transaksi;
      },
    },
    mounted() {
      this.fetchTransactions();
      this.fetchEvents();
    }
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
  