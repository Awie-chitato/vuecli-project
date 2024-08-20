<template>
  <div class="transactions">
    <h2 class="dashboard-title">Transaksi</h2>
    <div class="transaction-container">
      <div class="input-section">
        <div class="transaction-type">
          <button class="type-button active" @click="activeType = 'pemasukan'">Pemasukan</button>
          <button class="type-button" @click="activeType = 'pengeluaran'">Pengeluaran</button>
        </div>
        <h3 class="transaction-title">Input Transaksi {{ activeType === 'pemasukan' ? 'Pemasukan' : 'Pengeluaran' }}</h3>
        <div class="form-container">
          <form @submit.prevent="submitTransaction">
            <div class="form-group">
              <label for="amount">Jumlah:</label>
              <div class="input-wrapper">
                <input type="text" id="amount" v-model="newTransaction.amount" required>
              </div>
            </div>
            <div class="form-group">
              <label for="date">Tanggal:</label>
              <div class="input-wrapper">
                <input type="date" id="date" v-model="newTransaction.date" required>
              </div>
            </div>
            <div class="form-group">
              <label for="description">Deskripsi:</label>
              <div class="input-wrapper">
                <input type="text" id="description" v-model="newTransaction.description" required>
              </div>
            </div>
            <div class="form-group">
              <label for="paymentMethod">Metode Pembayaran:</label>
              <div class="input-wrapper">
                <select id="paymentMethod" v-model="newTransaction.paymentMethod" required>
                  <option value="dana">Dana</option>
                  <option value="bank">Transfer Bank</option>
                </select>
              </div>
            </div>
            <button type="submit" class="submit-button">Simpan Transaksi</button>
          </form>
        </div>
      </div>
      <div class="history-section">
        <h3 class="transaction-title">Riwayat Transaksi</h3>
        <table class="transaction-table">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Tipe</th>
              <th>Jumlah</th>
              <th>Deskripsi</th>
              <th>Metode Pembayaran</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(transaction, index) in transactions" :key="index">
              <td>{{ transaction.date }}</td>
              <td>{{ transaction.type }}</td>
              <td>{{ transaction.amount }}</td>
              <td>{{ transaction.description }}</td>
              <td>{{ transaction.paymentMethod }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Transactions',
  data() {
    return {
      activeType: 'pemasukan',
      newTransaction: {
        type: 'pemasukan',
        amount: '',
        date: '',
        description: '',
        paymentMethod: ''
      },
      transactions: []
    }
  },
  methods: {
    submitTransaction() {
      this.newTransaction.type = this.activeType;
      this.transactions.push({...this.newTransaction});
      // Reset form setelah submit
      this.newTransaction = {
        type: this.activeType,
        amount: '',
        date: '',
        description: '',
        paymentMethod: ''
      };
      alert('Transaksi berhasil disimpan!');
    }
  },
  watch: {
    activeType(newValue) {
      this.newTransaction.type = newValue;
    }
  }
};
</script>

<style scoped>
.transactions {
  padding: 20px;
  background: #ffffff;
  min-height: 100vh;
  position: relative;
}

.dashboard-title {
  font-size: 24px;
  color: #0066cc;
  margin-bottom: 20px;
}

.transaction-title {
  font-size: 20px;
  color: #0066cc;
  margin-bottom: 15px;
}

.transaction-container {
  display: flex;
  justify-content: space-between;
}

.input-section {
  width: 45%;
}

.history-section {
  width: 50%;
}

.transaction-type {
  display: flex;
  justify-content: flex-start;
  margin-bottom: 20px;
}

.type-button {
  margin-right: 10px;
  padding: 10px 20px;
  background-color: rgba(3, 169, 244, 0.1);
  border: none;
  border-radius: 5px;
  cursor: pointer;
  color: #000000;
  transition: all 0.3s ease;
  font-size: 14px;
}

.type-button.active {
  background-color: rgba(3, 169, 244, 0.3);
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
}

.form-container {
  background: rgba(3, 169, 244, 0.1);
  backdrop-filter: blur(10px);
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  color: #000000;
}

.input-wrapper {
  position: relative;
}

.form-group input, .form-group select {
  width: 100%;
  padding: 10px;
  border: 1px solid rgba(3, 169, 244, 0.3);
  border-radius: 5px;
  background-color: rgba(255, 255, 255, 0.8);
}

.submit-button {
  width: 100%;
  padding: 10px;
  background-color: rgba(3, 169, 244, 0.8);
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.submit-button:hover {
  background-color: rgba(3, 169, 244, 1);
}

.transaction-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.transaction-table th, .transaction-table td {
  border: 1px solid rgba(3, 169, 244, 0.3);
  padding: 10px;
  text-align: left;
}

.transaction-table th {
  background-color: rgba(3, 169, 244, 0.1);
  font-weight: bold;
}

.transaction-table tr:nth-child(even) {
  background-color: rgba(3, 169, 244, 0.05);
}
</style>