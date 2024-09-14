<template>
  <div class="eventlist">
    <div style="width: 10px;"> 
      <button @click="showInputForm = true; resetForm();" class="add-button" style="float: left; background: linear-gradient(#00D2FF, #3A7BD5); color: #EAEAEA; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; transition: background 0.3s ease; min-width: 100px;">Tambah</button>
    </div>
    <!-- <h2 class="dashboard-title">Event List</h2> -->
    <div class="transaction-container">
      <div v-if="showInputForm" class="input-form">
        <h3 style="color: #EAEAEA;">{{ editMode ? 'Edit Event' : 'Form Input Event' }}</h3>
        <form @submit.prevent="submitForm">
          <div class="form-group">
            <label for="namaEvent" style="color: #EAEAEA;">Nama Event:</label>
            <input type="text" id="namaEvent" v-model="newEventList.nama_event" required>
          </div>
          <div class="form-group">
            <label for="tempatEvent" style="color: #EAEAEA;">Nama Tempat:</label>
            <input type="text" id="tempatEvent" v-model="newEventList.tempat_event" required>
          </div>
          <div class="form-group">
            <label for="tanggalEvent" style="color: #EAEAEA;">Tanggal:</label>
            <input type="date" id="tanggalEvent" v-model="newEventList.tanggal_event" required>
          </div>
          <button type="submit" class="submit-button" style="background: linear-gradient(#00D2FF, #3A7BD5); color: #EAEAEA; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; transition: background 0.3s ease; min-width: 100px;">{{ editMode ? 'Update' : 'Simpan' }}</button>
          <button type="button" @click="cancelForm" class="cancel-button" style="background: linear-gradient(#cc0000, #cc0000); color: #EAEAEA; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; transition: background 0.3s ease; min-width: 100px;">Batal</button>
        </form>
      </div>

      <div v-if="!showInputForm" class="history-section">
        <table class="eventlist-table">
          <thead>
            <tr>
              <th style="display: none;">ID</th>
              <th>Nama Event</th>
              <th>Nama Tempat</th>
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(event, index) in eventlist" :key="index">
              <td style="display: none;">{{ event.id }}</td>
              <td>{{ event.nama_event }}</td>
              <td>{{ event.tempat_event }}</td>
              <td>{{ event.tanggal_event }}</td>
              <td class="action-column">
                <button @click="showTransactionTypeModal = true; event_id_transaction = event.id" class="add-transaction" style="background: linear-gradient(#28a745, #28a745); color: #EAEAEA; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; transition: background 0.3s ease; margin-right: 15px; min-width: 100px;">Transaksi</button>
                <button @click="editItem(event)" class="action-button edit" style="background: linear-gradient(#ffc107, #ffc107); color: #EAEAEA; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; transition: background 0.3s ease; margin-right: 15px; min-width: 100px;">Edit</button>
                <button @click="deleteItem(event)" class="action-button delete" style="background: linear-gradient(#dc3545, #dc3545); color: #EAEAEA; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; transition: background 0.3s ease; margin-right: 15px; min-width: 100px;">Hapus</button>
                
              </td>
            </tr>
          </tbody>
        </table>
        
      </div>
      <div v-if="showTransactionTypeModal" class="modal">
        <div class="modal-content">
          <h3 style="color: #EAEAEA;">Pilih Jenis Transaksi</h3>
          <button @click="selectTransactionType('pemasukan')" style="background: linear-gradient(#00D2FF, #3A7BD5); color: #EAEAEA; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; transition: background 0.3s ease; min-width: 100px;">Transaksi Pemasukan</button>
          <button @click="selectTransactionType('pengeluaran')" style="background: linear-gradient(#00D2FF, #3A7BD5); color: #EAEAEA; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; transition: background 0.3s ease; min-width: 100px;">Transaksi Pengeluaran</button>
          <button @click="showTransactionTypeModal = false" style="background: linear-gradient(#cc0000, #cc0000); color: #EAEAEA; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; transition: background 0.3s ease; min-width: 100px;">Batal</button>
        </div>
      </div>

      <div v-if="showInputTransactionForm" class="input-form">
        <h3 style="color: #EAEAEA;">{{ editMode ? 'Edit Transaksi' : 'Form Input Transaksi' }} {{ selectedTransactionType === 'pemasukan' ? 'Pemasukan' : 'Pengeluaran' }}</h3>
        <form @submit.prevent="submitTransactionForm">
          <input type="hidden" v-model="event_id_transaction">
          <div class="form-group">
            <label for="nominal" style="color: #EAEAEA;">Nominal:</label>
            <input type="number" id="nominal" v-model="newTransaction.nominal" required>
          </div>
          <div class="form-group">
            <label for="deskripsi" style="color: #EAEAEA;">Deskripsi:</label>
            <input type="text" id="deskripsi" v-model="newTransaction.deskripsi" required>
          </div>
          <div class="form-group">
            <label for="metodePembayaran" style="color: #EAEAEA;">Metode Pembayaran:</label>
            <select id="metodePembayaran" v-model="newTransaction.metode_pembayaran" required>
              <option value="">Pilih Metode Pembayaran</option>
              <option value="tunai">Tunai</option>
              <option value="transfer">Transfer</option>
            </select>
          </div>
          <div class="form-group">
            <label for="status" style="color: #EAEAEA;">Status:</label>
            <select id="status" v-model="newTransaction.status" required>
              <option value="">Pilih Status</option>
              <option value="selesai">Selesai</option>
              <option value="pending">Pending</option>
            </select>
          </div>
          <button type="submit" class="submit-button" style="background: linear-gradient(#00D2FF, #3A7BD5); color: #EAEAEA; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; transition: background 0.3s ease; min-width: 100px;">Simpan</button>
          <button type="button" @click="cancelTransactionForm" class="cancel-button" style="background: linear-gradient(#cc0000, #cc0000); color: #EAEAEA; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; transition: background 0.3s ease; min-width: 100px;">Batal</button>
        </form>
      </div>
    </div>
  </div>

</template>

<script>
import axios from 'axios';

export default {
  name: 'EventList',
  data() {
  return {
    showInputForm: false,
    showInputTransactionForm: false,
    showTransactionTypeModal: false,
    editMode: false,
    newEventList: {
      id: null,
      nama_event: '',
      tempat_event: '',
      tanggal_event: ''
    },
    eventlist: [],
    newTransaction: {
      id: null,
      nominal: '',
      deskripsi: '',
      metode_pembayaran: '',
      status: '',
    },
    event_id_transaction: 0,
    event_name: '',  // Tambahkan ini
    selectedTransactionType: '',
  };
},

  methods: {
    resetForm() {
      this.newEventList = {
        id: null,
        nama_event: '',
        tempat_event: '',
        tanggal_event: ''
      };
      this.editMode = false;
    },
    selectTransactionType(type) {
      this.selectedTransactionType = type;
      this.showTransactionTypeModal = false;
      this.showInputTransactionForm = true;
      this.resetTransactionForm();
    },
    submitForm() {
      if (this.editMode) {
        // Update data jika dalam mode edit
        axios.put(`http://127.0.0.1:8000/api/update-event-fpti/${this.newEventList.id}`, this.newEventList)
          .then(response => {
            const index = this.eventlist.findIndex(item => item.id === this.newEventList.id);
            if (index !== -1) {
              this.eventlist.splice(index, 1, response.data.data); // Update state dengan data terbaru dari server
            }
            this.cancelForm();
          })
          .catch(error => {
            console.error('Error updating data:', error);
          });
      } else {
        // Tambah data baru jika tidak dalam mode edit
        axios.post('http://127.0.0.1:8000/api/create-event-fpti', this.newEventList)
          .then(response => {
            this.eventlist.push(response.data.data); // Tambah data baru ke state
            this.cancelForm();
          })
          .catch(error => {
            console.error('Error creating data:', error);
          });
      }
    },
    submitTransactionForm() {
      this.newTransaction.event_id = this.event_id_transaction;
      
      let apiEndpoint = '';
      
      if (this.selectedTransactionType === 'pemasukan') {
        apiEndpoint = 'http://127.0.0.1:8000/api/create-transaksi-fpti';
      } else if (this.selectedTransactionType === 'pengeluaran') {
        apiEndpoint = 'http://127.0.0.1:8000/api/create-pengeluaran-fpti';
      }

      axios.post(apiEndpoint, this.newTransaction)
        .then(response => {
          console.log('Transaksi berhasil dibuat:', response.data);
          this.cancelTransactionForm();
        })
        .catch(error => {
          console.error('Error membuat transaksi:', error);
        });
    },
    editItem(event) {
      this.editMode = true;
      this.newEventList = { ...event };
      this.showInputForm = true;
    },
    deleteItem(event) {
      console.log('Deleting event with ID:', event.id); // Log ID yang akan dihapus

      if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        axios.delete(`http://127.0.0.1:8000/api/delete-event-fpti/${event.id}`)
          .then(response => {
            console.log('Delete response:', response);
            // Hapus data dari state
            this.eventlist = this.eventlist.filter(item => item.id !== event.id); // Hapus data dari state
            this.fetchEventList(); // Refresh data dari server
          })
          .catch(error => {
            console.error('Error deleting data:', error);
          });
      }
    },
    cancelForm() {
      this.showInputForm = false;
      this.resetForm();
    },
    cancelTransactionForm() {
      this.showInputTransactionForm = false;
      this.resetTransactionForm();
    },
    resetTransactionForm() {
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
    fetchEventList() {
      axios.get('http://127.0.0.1:8000/api/show-semua-event-fpti')
        .then(response => {
          this.eventlist = response.data.data;
        })
        .catch(error => {
          console.error('There was an error!', error);
        });
    }
  },
  mounted() {
    this.fetchEventList();
  }
};
</script>

<style scoped>
/* CSS Styles remain the same */
</style>

<style scoped>
.eventlist-table { /* Ubah di sini */
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  background: linear-gradient(#1E1E2E, #1E1E2E); /* Background ungu tua kehitaman */
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.eventlist-table th,  /* Ubah di sini */
.eventlist-table td {  /* Ubah di sini */
  padding: 15px;
  border-bottom: 1px solid #e0e0e0;
}

.eventlist-table th {  /* Ubah di sini */
  background: linear-gradient(#00D2FF, #3A7BD5); /* Background biru cerah ke biru tua */
  color: #EAEAEA; /* Text abu terang */
  font-weight: bold;
  text-transform: uppercase;
}

.eventlist-table tr:hover {  /* Ubah di sini */
  background: linear-gradient(#f1f1f1, #f1f1f1); /* Background hover */
  transition: background 0.3s ease;
}

.eventlist-table tr:nth-child(even) {  /* Ubah di sini */
  background: linear-gradient(#f4f7fc, #f4f7fc); /* Background baris genap */
}

.eventlist-table td {  /* Ubah di sini */
  font-size: 14px;
  color: #333;
}

.eventlist-table td:first-child {  /* Ubah di sini */
  font-weight: bold;
}

.eventlist-table th:first-child,  /* Ubah di sini */
.eventlist-table td:first-child {  /* Ubah di sini */
  border-top-left-radius: 10px;
}

.eventlist-table th:last-child,  /* Ubah di sini */
.eventlist-table td:last-child {  /* Ubah di sini */
  border-top-right-radius: 10px;
}

.eventlist-table th:first-child,  /* Ubah di sini */
.eventlist-table td:first-child {  /* Ubah di sini */
  border-bottom-left-radius: 10px;
}

.eventlist-table th:last-child,  /* Ubah di sini */
.eventlist-table td:last-child {  /* Ubah di sini */
  border-bottom-right-radius: 10px;
}

.add-button {
  background: linear-gradient(#00D2FF, #3A7BD5); /* Background biru cerah ke biru tua */
  color: #EAEAEA; /* Text abu terang */
  border: none;
  padding: 5px 10px;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s ease;
  margin-bottom: 10px;
  min-width: 100px;
}

.add-transaction{
  margin-top: 10px;
  background: linear-gradient(#00D2FF, #3A7BD5); /* Background biru cerah ke biru tua */
  color: #EAEAEA; /* Text abu terang */
  border: none;
  padding: 5px 10px;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s ease;
  min-width: 100px;
}
.add-button:hover {
  background: linear-gradient(#3A7BD5, #3A7BD5); /* Background hover */
}

.action-button {
  padding: 5px 10px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  color: #EAEAEA; /* Text abu terang */
  margin: 0 2px;
}

.action-column {
  text-align: center;
}
.action-button.edit {
  background: linear-gradient(#ffc107, #ffc107); /* Background kuning cerah ke kuning tua */
}

.action-button.delete {
  background: linear-gradient(#dc3545, #dc3545); /* Background merah cerah ke merah tua */
}

.input-form {
  background: linear-gradient(#f2f2f2, #f2f2f2); /* Background form input */
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
  padding: 5px 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-right: 10px;
}

.submit-button {
  background: linear-gradient(#00D2FF, #3A7BD5); /* Background biru cerah ke biru tua */
  color: #EAEAEA; /* Text abu terang */
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
