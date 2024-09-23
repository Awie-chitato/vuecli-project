<template>
  <div class="container">
    <h1 class="title">Buku Besar</h1>
    <div class="button-group">
      <!-- Tombol untuk mendownload PDF -->
      <button @click="downloadPDF" class="btn">Download Transaksi</button>
      <button @click="downloadHutang" class="btn">Download Hutang Piutang</button>
      <button @click="downloadEventListPDF" class="btn">Download Event List</button>
    </div>
    <!-- Kode lainnya untuk menampilkan data transaksi -->
  </div>
</template>

<script>
import axios from 'axios';
import jsPDF from 'jspdf'; // Import jsPDF
import 'jspdf-autotable'; // Import jsPDF AutoTable
// Fungsi untuk mengonversi gambar menjadi Base64
function getBase64Image(url, callback) {
  const img = new Image();
  img.crossOrigin = 'Anonymous'; // Perbolehkan pengambilan gambar dari domain lain
  img.onload = function() {
    const canvas = document.createElement('canvas');
    canvas.width = this.width;
    canvas.height = this.height;
    const ctx = canvas.getContext('2d');
    ctx.drawImage(this, 0, 0);
    const dataURL = canvas.toDataURL('image/png');
    callback(dataURL);
  };
  img.onerror = function() {
    console.error('Failed to load image:', url);
  };
  img.src = url;
}


export default {
  name: 'Financials',
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
      events: [],
      combinedDebtCredits: [],
      eventlist: [],
      newEventList: {
      id: null,
      nama_event: '',
      tempat_event: '',
      tanggal_event: ''
    },
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
    fetchDebtCredits() {
      axios.get('http://127.0.0.1:8000/api/show-semua-hp')
        .then(response => {
          this.combinedDebtCredits = response.data.data;
        })
        .catch(error => {
          console.error('Error fetching debt credits:', error.response ? error.response.data : error.message);
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
    downloadPDF() {
      const doc = new jsPDF();
      
        // Path gambar logo
  const logoUrl = require('@/assets/fpti_indonesia.png');

// Mengonversi gambar ke format Base64 dan menambahkannya ke PDF
getBase64Image(logoUrl, (base64Image) => {
  const logoWidth = 40; // Lebar logo
  const logoHeight = 20; // Tinggi logo
  const logoX = 10; // Posisi X (jarak dari kiri)
  const logoY = 10; // Posisi Y (jarak dari atas)

  // Menambahkan logo ke dokumen PDF
  doc.addImage(base64Image, 'PNG', logoX, logoY, logoWidth, logoHeight);

      // Buat tabel menggunakan jsPDF-AutoTable
      doc.autoTable({
        head: [['ID', 'Nama Event', 'Nominal', 'Tanggal', 'Deskripsi', 'Metode Pembayaran', 'Status', 'Aksi']],
        body: this.combinedTransactions.map(transaction => [
          transaction.id,
          this.getEventName(transaction.event_id), // Ambil nama event menggunakan fungsi getEventName
          transaction.nominal,
          transaction.tanggal,
          transaction.deskripsi,
          transaction.metode_pembayaran,
          transaction.status,
          transaction.jenis_transaksi
        ]),
        margin: { top: logoY + logoHeight + 10 }
      });

      // Simpan dokumen PDF
      doc.save('transactions.pdf');
})
    },
    downloadHutang() {
      const doc = new jsPDF();

      // Path gambar logo
  const logoUrl = require('@/assets/fpti_indonesia.png');

// Mengonversi gambar ke format Base64 dan menambahkannya ke PDF
getBase64Image(logoUrl, (base64Image) => {
  const logoWidth = 40; // Lebar logo
  const logoHeight = 20; // Tinggi logo
  const logoX = 10; // Posisi X (jarak dari kiri)
  const logoY = 10; // Posisi Y (jarak dari atas)

  // Menambahkan logo ke dokumen PDF
  doc.addImage(base64Image, 'PNG', logoX, logoY, logoWidth, logoHeight);

      // Generate tabel dari data combinedDebtCredits
      doc.autoTable({
        head: [['Kategori', 'Nominal', 'Tanggal', 'Deskripsi', 'Pihak Kedua', 'Metode Pembayaran', 'Status']],
        body: this.combinedDebtCredits.map(debtCredit => [
          debtCredit.kategori,
          debtCredit.nominal,
          debtCredit.tanggal,
          debtCredit.deskripsi,
          debtCredit.pihak_kedua,
          debtCredit.metode_pembayaran,
          debtCredit.status,
        ]),
        margin: { top: logoY + logoHeight + 10 }
      });

      // Simpan dokumen PDF
      doc.save('debt_credits.pdf');
})
  },
    fetchEventList() {
      axios.get('http://127.0.0.1:8000/api/show-semua-event-fpti')
        .then(response => {
          this.eventlist = response.data.data;
        })
        .catch(error => {
          console.error('There was an error!', error);
        });
    },
    downloadEventListPDF() {
  const doc = new jsPDF();

  // Path gambar logo
  const logoUrl = require('@/assets/fpti_indonesia.png');

  // Mengonversi gambar ke format Base64 dan menambahkannya ke PDF
  getBase64Image(logoUrl, (base64Image) => {
    const logoWidth = 40; // Lebar logo
    const logoHeight = 20; // Tinggi logo
    const logoX = 10; // Posisi X (jarak dari kiri)
    const logoY = 10; // Posisi Y (jarak dari atas)

    // Menambahkan logo ke dokumen PDF
    doc.addImage(base64Image, 'PNG', logoX, logoY, logoWidth, logoHeight);

    // Buat tabel menggunakan jsPDF-AutoTable
    doc.autoTable({
      head: [['ID', 'Nama Event', 'Tempat', 'Tanggal']],
      body: this.eventlist.map(event => [
        event.id,
        event.nama_event,
        event.tempat_event,
        event.tanggal_event
      ]),
      margin: { top: logoY + logoHeight + 10 } // Menyesuaikan margin tabel setelah menambahkan logo
    });

    // Simpan dokumen PDF
    doc.save('event_list.pdf');
  });
}


  },
  mounted() {
    this.fetchTransactions();
    this.fetchEvents();
    this.fetchDebtCredits();
    this.fetchEventList();
  }
};
</script>

<style>
/* Tambahkan style sesuai kebutuhan */
</style>
<style scoped>
/* Tambahkan style sesuai kebutuhan */
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  font-family: Arial, sans-serif;
}

.title {
  font-size: 2rem;
  margin-bottom: 20px;
  color: #ebebeb;
  text-align: center;
}

.button-group {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin-bottom: 20px;
}

.btn {
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  padding: 10px 20px;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn:hover {
  background-color: #0056b3;
}

.btn:focus {
  outline: none;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

table th,
table td {
  border: 1px solid #ddd;
  padding: 8px;
}

table th {
  background-color: #f4f4f4;
  text-align: left;
}

table tr:nth-child(even) {
  background-color: #f9f9f9;
}
</style>
