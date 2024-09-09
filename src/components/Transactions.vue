<template>
  <div class="transactions">
    <h2 class="dashboard-title">Daftar Transaksi</h2>
    <div class="transaction-container">
      <div v-if="!showInputForm" class="history-section">
        <div class="table-header">
          
          <button @click="showTransactionTypeModal = true" class="add-button" style="background-color: #0066cc; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-right: 10px;">Tambah</button>
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
                <button @click="editItem(transaction)" class="action-button edit" style="background-color: #ffc107; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-right: 5px;">Edit</button>
                <button @click="deleteItem(transaction)" class="action-button delete" style="background-color: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Modal untuk memilih jenis transaksi -->
      <div v-if="showTransactionTypeModal" class="modal">
        <div class="modal-content">
          <h3>Pilih Jenis Transaksi</h3>
          <button @click="selectTransactionType('pemasukan')">Transaksi Pemasukan</button>
          <button @click="selectTransactionType('pengeluaran')">Transaksi Pengeluaran</button>
          <button @click="showTransactionTypeModal = false">Batal</button>
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
  background-color: #f9f9f9;
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
  background-color: #0066cc;
  color: white;
  font-weight: bold;
  text-transform: uppercase;
}

.transaction-table tr:hover {
  background-color: #f1f1f1;
  transition: background-color 0.3s ease;
}

.transaction-table tr:nth-child(even) {
  background-color: #f4f7fc;
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
  background-color: #ffc107;
}

.action-button.delete {
  background-color: #dc3545;
}

.table-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.add-button {
  background-color: #0066cc;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.add-button:hover {
  background-color: #0052a3;
}

.input-form {
  background-color: #f2f2f2;
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
  border: 1px solid #ddd;
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
  background-color: #0066cc;
  color: white;
}

.cancel-button {
  background-color: #cc0000;
  color: white;
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
  background-color: #fefefe;
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
  background-color: #0066cc;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.modal-content button:hover {
  background-color: #0052a3;
}

.transaction-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  background-color: #f9f9f9;
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
  background-color: #0066cc;
  color: white;
}

.cancel-button {
  background-color: #cc0000;
  color: white;
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
  background-color: #fefefe;
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
  background-color: #0066cc;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.modal-content button:hover {
  background-color: #0052a3;
}
</style>
