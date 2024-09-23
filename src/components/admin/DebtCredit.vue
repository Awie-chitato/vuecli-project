<template>
  <div class="debt-credit">
    <!-- <h2 class="dashboard-title">Riwayat Hutang Piutang</h2> -->

    <div v-if="!showInputForm" class="history-section">
      <h3 style="color: #FFFFFF; text-align: center;">Daftar Hutang Piutang</h3>
      <div class="table-header" style="width: 10px; margin-bottom: 20px;">
        <button @click="showDebtCreditTypeModal = true" class="add-button" style="float: left; background: linear-gradient(#00D2FF, #3A7BD5); color: #EAEAEA; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; transition: background 0.3s ease; min-width: 100px; margin-right: 20px;">Tambah</button>
      </div>

      <table class="table">
        <thead>
          <tr>
            <th>Kategori</th>
            <th>Nominal</th>
            <th>Jatuh Tempo</th>
            <th>Deskripsi</th>
            <th>Pihak Kedua</th>
            <th>Metode Pembayaran</th>
            <th>Status</th>
            <th>Aksi</th>
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
            <td>
              <button @click="editDebtCredit(item)" class="action-button edit">Edit</button>
              <button @click="deleteDebtCredit(item)" class="action-button delete">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal untuk form input -->
    <div v-if="showDebtCreditTypeModal" class="modal">
      <div class="modal-content">
        <h2>Pilih Opsi Hutang Piutang</h2>
        <button @click="startNewDebtCredit('hutang')"  style="background-color: blue; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-right: 15px;">Catatan Hutang</button>
        <button @click="startNewDebtCredit('piutang')"  style="background-color: blue; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-right: 15px;">Catatan Piutang</button>
        <button @click="cancelDebtCreditTypeSelection">Batal</button>
      </div>
    </div>

    <!-- Form Input Hutang / Piutang -->
    <div v-if="showInputForm" class="input-form">
      <h3>{{ isEditMode ? 'Edit Hutang Piutang' : 'Form Input Hutang Piutang' }}</h3>
      <form @submit.prevent="submitDebtCredit">
        <div class="form-group">
          <label for="kategori">Kategori:</label>
          <input type="text" id="kategori" v-model="currentDebtCredit.kategori" required />
        </div>
        <div class="form-group">
          <label for="nominal">Nominal:</label>
          <input type="number" id="nominal" v-model="currentDebtCredit.nominal" required />
        </div>
        <div class="form-group">
          <label for="tanggal">Jatuh Tempo:</label>
          <input type="date" id="tanggal" v-model="currentDebtCredit.tanggal" required />
        </div>
        <div class="form-group">
          <label for="deskripsi">Deskripsi:</label>
          <textarea id="deskripsi" v-model="currentDebtCredit.deskripsi" required></textarea>
        </div>
        <div class="form-group">
          <label for="pihak_kedua">Pihak Kedua:</label>
          <input type="text" id="pihak_kedua" v-model="currentDebtCredit.pihak_kedua" required />
        </div>
        <div class="form-group">
          <label for="metode_pembayaran">Metode Pembayaran:</label>
          <select id="metode_pembayaran" v-model="currentDebtCredit.metode_pembayaran" required>
            <option value="tunai">Tunai</option>
            <option value="transfer">Transfer</option>
          </select>
        </div>
        <div class="form-group">
          <label for="status">Status:</label>
          <select id="status" v-model="currentDebtCredit.status" required>
            <option value="lunas">Lunas</option>
            <option value="belum lunas">Belum Lunas</option>
          </select>
        </div>
        <div class="form-group">
          <label for="hp_pemasukan_id">Code:</label>
          <input type="number" id="hp_pemasukan_id" v-model="currentDebtCredit.hp_pemasukan_id" required />
        </div>
        <button type="submit" class="submit-button">Simpan</button>
        <button type="button" @click="cancelDebtCreditForm" class="cancel-button">Batal</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      showInputForm: false,
      showDebtCreditTypeModal: false,
      isEditMode: false,
      combinedDebtCredits: [],
      currentDebtCredit: {
        kategori: '',
        nominal: '',
        tanggal: '',
        deskripsi: '',
        pihak_kedua: '',
        metode_pembayaran: '',
        status: '',
        hp_pemasukan_id: '',
      },
    };
  },
  methods: {
    startNewDebtCredit(type) {
      this.resetForm();
      this.showDebtCreditTypeModal = false;
      this.currentDebtCredit.kategori = type === 'hutang' ? 'Hutang' : 'Piutang';
      this.showInputForm = true;
    },
    resetForm() {
      this.currentDebtCredit = {
        kategori: '',
        nominal: '',
        tanggal: '',
        deskripsi: '',
        pihak_kedua: '',
        metode_pembayaran: '',
        status: '',
        hp_pemasukan_id: '',
      };
      this.isEditMode = false;
    },
    submitDebtCredit() {
      const apiUrl = this.isEditMode
        ? `http://127.0.0.1:8000/api/update-hp-pemasukan/${this.currentDebtCredit.id}`
        : 'http://127.0.0.1:8000/api/create-hp-pemasukan-fpti';
      const method = this.isEditMode ? 'put' : 'post';

      axios[method](apiUrl, this.currentDebtCredit)
        .then((response) => {
          if (this.isEditMode) {
            const index = this.combinedDebtCredits.findIndex((item) => item.id === this.currentDebtCredit.id);
            if (index !== -1) this.combinedDebtCredits.splice(index, 1, response.data.data);
          } else {
            this.combinedDebtCredits.push(response.data.data);
          }
          this.showInputForm = false;
        })
        .catch((error) => {
          console.error('Error submitting debt credit:', error.response ? error.response.data : error.message);
        });
    },
    editDebtCredit(debtCredit) {
      this.isEditMode = true;
      this.currentDebtCredit = { ...debtCredit };
      this.showInputForm = true;
    },
    deleteDebtCredit(debtCredit) {
      if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        axios
          .delete(`http://127.0.0.1:8000/api/delete-hp-pemasukan/${debtCredit.id}`)
          .then(() => {
            this.combinedDebtCredits = this.combinedDebtCredits.filter((item) => item.id !== debtCredit.id);
          })
          .catch((error) => {
            console.error('Error deleting debt credit:', error.response ? error.response.data : error.message);
          });
      }
    },
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
    cancelDebtCreditForm() {
      this.showInputForm = false;
    },
    cancelDebtCreditTypeSelection() {
      this.showDebtCreditTypeModal = false;
    },
  },
  mounted() {
    this.fetchDebtCredits();
  },
};
</script>


<style>
body {
  overflow: hidden; /* Ini mencegah halaman di-scroll ketika modal terbuka */
}

.modal {
  position: fixed;
  z-index: 9999; /* Pastikan modal muncul di atas semua elemen */
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}
@media screen and (min-width: 768px) {
  .modal-content {
    width: 60%; /* Perbesar modal pada layar besar */
  }
}

@media screen and (min-width: 1024px) {
  .modal-content {
    width: 40%; /* Lebih besar untuk layar desktop */
  }
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

.glass {
  background-color: rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px); /* Untuk Safari */
  border-radius: 10px; /* Sedikit radius untuk memperhalus tampilan */
}


button {
  display: block;
  width: 100%;
  padding: 10px;
  margin-top: 5px;
  background-color: #0066cc;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

button:hover {
  background-color: #3e8e41;
}

form {
  margin-top: 20px;
}

label {
  display: block;
  margin-bottom: 10px;
}

.input-form {
  background: linear-gradient(#00D2FF, #3A7BD5);
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 20px;
  max-width: 600px;
  margin: 0 auto;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.input-form h3 {
  margin-bottom: 20px;
  font-size: 1.5em;
  color: #0c0c0c;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
  color: #000000;
}

.form-group input[type="text"],
.form-group input[type="number"],
.form-group input[type="date"],
.form-group textarea,
.form-group select {
  width: 100%;
  padding: 8px;
  border: 1px solid #d8d3d3;
  border-radius: 4px;
}

.form-group textarea {
  resize: vertical;
  height: 100px;
  color: black;
}

.submit-button,
.cancel-button {
  background-color: #1000f3;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1em;
  margin-right: 10px;
}

.submit-button:hover,
.cancel-button:hover {
  background-color: #0013bb;
}

.cancel-button {
  background-color: #ff1e1e;
}

.cancel-button:hover {
  background-color: #ac0000;
}



.table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  background: linear-gradient(#fffdfd, #e0e0e0); /* Background ungu tua kehitaman */
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 8px rgba(240, 240, 240, 0.1);
}

.table thead tr {
  background-color: #f0f0f0;
}

.table td , .table th {
  padding: 15px;
  text-align: left;
  border-bottom: 1px solid #e0e0e0;
  
}
.table th{
  background: linear-gradient(#00D2FF, #3A7BD5); /* Background biru cerah ke biru tua */
  color: #000000; /* Text abu terang */
  font-weight: bold;
  text-transform: uppercase;
}
/* Responsif untuk layar kecil */
@media screen and (max-width: 600px) {
  .table td, .table th {
    font-size: 14px;
    padding: 8px;
  }
}

.action-button.edit {
  background-color: #ffc107;
}

.action-button.delete {
  background-color: #dc3545;
}

</style>
