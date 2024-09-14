<template>
  <div class="transactions">
    <h2 class="dashboard-title" style="color: #FFFFFF; text-align: center;">Daftar Transaksi</h2>
    <div class="transaction-container">
      <div v-if="!showInputForm" class="history-section">
        <div class="table-header">
          

        </div>
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
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(transaction, index) in combinedTransactions" :key="index">
              <td>{{ transaction?.nama_event }}</td>
              <td>{{ transaction?.nominal }}</td>
              <td>{{ transaction?.tanggal }}</td>
              <td>{{ transaction?.deskripsi }}</td>
              <td>{{ transaction?.metode_pembayaran }}</td>
              <td>{{ transaction?.status }}</td>
              <td>{{ transaction?.jenis_transaksi }}</td>
              <td class="action-column">
                <button @click="editItem(transaction)" class="action-button edit" style="background: linear-gradient(#ffc107, #ffc107); color: #EAEAEA; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-right: 5px;">Edit</button>
                <button @click="deleteItem(transaction)" class="action-button delete" style="background: linear-gradient(#dc3545, #dc3545); color: #EAEAEA; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Modal untuk memilih jenis transaksi -->
      <div v-if="showTransactionTypeModal" class="modal">
        <div class="modal-content">
          <h3>Pilih Jenis Transaksi</h3>
          <button @click="selectTransactionType('pemasukan')" style="background: linear-gradient(#00D2FF, #3A7BD5); color: #EAEAEA; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Transaksi Pemasukan</button>
          <button @click="selectTransactionType('pengeluaran')" style="background: linear-gradient(#00D2FF, #3A7BD5); color: #EAEAEA; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Transaksi Pengeluaran</button>
          <button @click="showTransactionTypeModal = false" style="background: linear-gradient(#00D2FF, #3A7BD5); color: #EAEAEA; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Batal</button>
        </div>
      </div>

      <!-- Form untuk input atau edit transaksi -->
      <div v-if="showInputForm" class="input-form">
        <h3>{{ editMode ? 'Edit Transaksi' : 'Form Input Transaksi' }} {{ selectedTransactionType === 'pemasukan' ? 'Pemasukan' : 'Pengeluaran' }}</h3>
        <form @submit.prevent="submitForm">
          <div class="form-group"></div>
          <div class="form-group">
            <label for="nominal">Nominal:</label>
            <input type="number" id="nominal" v-model="newTransaction.nominal" required>
          </div>
          <div class="form-group">
            <label for="deskripsi">Deskripsi:</label>
            <textarea id="deskripsi" v-model="newTransaction.deskripsi"></textarea>
          </div>
          <div class="form-group">
            <label for="metodePembayaran">Metode Pembayaran:</label>
            <select id="metodePembayaran" v-model="newTransaction.metode_pembayaran" required>
              <option value="">Pilih Metode Pembayaran</option>
              <option value="tunai">Tunai</option>
              <option value="transfer">Transfer</option>
            </select>
          </div>
          <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" v-model="newTransaction.status" required>
              <option value="">Pilih Status</option>
              <option value="selesai">Selesai</option>
              <option value="pending">Pending</option>
            </select>
          </div>
          <button type="submit" class="submit-button">{{ editMode ? 'Update' : 'Simpan' }}</button>
          <button type="button" @click="cancelForm" class="cancel-button">Batal</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Transactions',
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
            this.combinedTransactions = response.data.data.map(item => {
              return {
                ...item,
              };
            }).sort((a, b) => new Date(b.tanggal) - new Date(a.tanggal));
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
      return event ? event.event_id : 'Nama_Event';
    },
    editItem(transaction) {
      this.editMode = true;
      this.showInputForm = true;
      this.newTransaction = { ...transaction };
      this.selectedTransactionType = transaction.jenis_transaksi;
    },
    deleteItem(transaction) {
      if (confirm('Apakah Anda yakin ingin menghapus transaksi ini?')) {
        const endpoint = transaction.jenis_transaksi === 'pemasukan'
          ? 'http://127.0.0.1:8000/api/delete-event-transaksi'
          : 'http://127.0.0.1:8000/api/delete-event-pengeluaran';
        
        axios.delete(`${endpoint}/${transaction.id}`)
          .then(response => {
            if (response.data.success) {
              this.fetchTransactions(); // Refresh daftar transaksi
              alert('Transaksi berhasil dihapus');
            } else {
              console.error('Gagal menghapus transaksi:', response.data.message);
              alert('Gagal menghapus transaksi');
            }
          })
          .catch(error => {
            console.error('Terjadi kesalahan saat menghapus transaksi:', error);
            alert('Terjadi kesalahan saat menghapus transaksi');
          });
      }
    },
    submitForm() {
      const endpoint = this.editMode
        ? (this.newTransaction.jenis_transaksi === 'pemasukan'
           ? `http://127.0.0.1:8000/api/update-event-transaksi/${this.newTransaction.id}`
           : `http://127.0.0.1:8000/api/update-event-pengeluaran/${this.newTransaction.id}`)
        : (this.selectedTransactionType === 'pemasukan'
           ? 'http://127.0.0.1:8000/api/create-transaksi-fpti'
           : 'http://127.0.0.1:8000/api/create-pengeluaran-fpti');

      const method = this.editMode ? 'put' : 'post';
      
      axios[method](endpoint, this.newTransaction)
        .then(response => {
          if (response.data.success) {
            this.fetchTransactions();
            this.showInputForm = false;
            this.editMode = false;
            this.resetForm();
            alert(this.editMode ? 'Transaksi berhasil diperbarui' : 'Transaksi berhasil ditambahkan');
          } else {
            console.error('Gagal menyimpan transaksi:', response.data.message);
            alert('Gagal menyimpan transaksi');
          }
        })
        .catch(error => {
          console.error('Terjadi kesalahan saat menyimpan transaksi:', error);
          alert('Terjadi kesalahan saat menyimpan transaksi');
        });
    },
    resetForm() {
      this.newTransaction = {
        id: null,
        nama_event: '',
        nominal: '',
        tanggal: '',
        deskripsi: '',
        metode_pembayaran: '',
        status: '',
        jenis_transaksi: ''
      };
    },
    cancelForm() {
      this.showInputForm = false;
      this.editMode = false;
      this.resetForm();
    }
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
  background: linear-gradient(#e0e0e0, #e0e0e0); /* Background ungu tua kehitaman */
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

.action-column {
  text-align: center;
  white-space: nowrap;
}

.action-button {
  padding: 5px
}

.action-column {
  text-align: center;
}
.action-button.edit {
  background: linear-gradient(#ffc107, #ffc107); /* Background kuning cerah ke kuning tua */
  color: #EAEAEA; /* Text abu terang */
}

.action-button.delete {
  background: linear-gradient(#dc3545, #dc3545); /* Background merah cerah ke merah tua */
  color: #EAEAEA; /* Text abu terang */
}

.table-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.add-button {
  background: linear-gradient(#00D2FF, #3A7BD5); /* Background biru cerah ke biru tua */
  color: #000000; /* Text abu terang */
  border: none;
  padding: 10px 20px;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s ease;
}

.add-button:hover {
  background: linear-gradient(#0052a3, #0052a3); /* Background hover */
}

.input-form {
  background: linear-gradient(#e8e8ff, #cbcbff); /* Background ungu tua kehitaman */
  padding: 20px;
  border-radius: 5px;
  margin-top: 20px;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
}

.form-group input, .form-group select, .form-group textarea {
  width: 100%;
  padding: 5px;
  border: 1px solid #030303;
  border-radius: 3px;
}

.submit-button, .cancel-button {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-right: 10px;
}

.submit-button {
  background: linear-gradient(#00D2FF, #3A7BD5); /* Background biru cerah ke biru tua */
  color: #EAEAEA; /* Text abu terang */
}

.cancel-button {
  background: linear-gradient(#cc0000, #cc0000); /* Background merah cerah ke merah tua */
  color: #EAEAEA; /* Text abu terang */
}

.modal {
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(189, 170, 170, 0.4);
}

.modal-content {
  background: linear-gradient(#e8e8ff, #cbcbff); /* Background ungu tua kehitaman */
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 500px;
  border-radius: 5px;
}

.modal-content button {
  display: block;
  width: 100%;
  padding: 10px;
  margin-top: 10px;
  background: linear-gradient(#00D2FF, #3A7BD5); /* Background biru cerah ke biru tua */
  color: #050505; /* Text abu terang */
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.modal-content button:hover {
  background: linear-gradient(#0052a3, #0052a3); /* Background hover */
}

.transaction-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  background: linear-gradient(#1E1E2E, #1E1E2E); /* Background ungu tua kehitaman */
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}


.submit-button, .cancel-button {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-right: 10px;
}

.submit-button {
  background: linear-gradient(#00D2FF, #3A7BD5); /* Background biru cerah ke biru tua */
  color: #EAEAEA; /* Text abu terang */
}

.cancel-button {
  background: linear-gradient(#cc0000, #cc0000); /* Background merah cerah ke merah tua */
  color: #EAEAEA; /* Text abu terang */
}

.modal {
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.4);
}

.modal-content {
  background: linear-gradient(#9d9dec, #d4d4dd); /* Background ungu tua kehitaman */
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 500px;
  border-radius: 5px;
}

.modal-content button {
  display: block;
  width: 100%;
  padding: 10px;
  margin-top: 10px;
  background: linear-gradient(#00D2FF, #3A7BD5); /* Background biru cerah ke biru tua */
  color: #070707; /* Text abu terang */
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.modal-content button:hover {
  background: linear-gradient(#0052a3, #0052a3); /* Background hover */
}
</style>
