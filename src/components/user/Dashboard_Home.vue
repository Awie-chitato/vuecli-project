<template>
  
    <div class="dashboard-content">
          <div class="glass-card">
            <h2>Event Mendatang</h2>
            <ul class="event-list">
              <li v-for="event in upcomingEvents" :key="event.id" class="event-item">
                <span class="event-name" style="color: green; margin-right: 10px;">{{ event.nama_event }}</span>
                <span class="event-date" style="color: green;">{{ event.tanggal_event }}</span>
              </li>
            </ul>
          </div>
          <div class="glass-card">
            <h2>Event Selesai</h2>
            <ul class="event-list">
              <li v-for="event in pastEvents" :key="event.id" class="event-item">
                <span class="event-name" style="color: red; margin-right: 10px;">{{ event.nama_event }}</span>
                <span class="event-date" style="color: red;">{{ event.tanggal_event }}</span>
              </li>
            </ul>
          </div>
          <div class="glass-card">
            <h2 style="text-align: center;">Jatuh Tempo Hutang Piutang Mendatang</h2>
            <ul class="HP-list">
              <li v-for="HP in upcomingHp" :key="HP.id" class="HP-item">
                <span class="HP-kategori" style="color: green; margin-right: 10px;">{{ HP.kategori }}</span>
                <span class="HP-date" style="color: green;">{{ HP.tanggal }}</span>
              </li>
            </ul>
          </div>
          <div class="glass-card">
            <h2 style="text-align: center;">Jatuh Tempo Hutang Piutang Selesai</h2>
            <ul class="HP-list">
              <li v-for="HP in pastHp" :key="HP.id" class="HP-item">
                <span class="HP-kategori" style="color: red; margin-right: 10px;">{{ HP.kategori }}</span>
                <span class="HP-date" style="color: red;">{{ HP.tanggal }}</span>
              </li>
            </ul>
          </div>
        
          <div class="glass-card">
            <h2>Sisa Saldo</h2>
            <p class="balance" :class="{ 'positive': totalSaldo > 0, 'negative': totalSaldo < 0 }">
              Rp {{ formatCurrency(totalSaldo) }}
            </p>
          </div>
        </div>
    
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'Dashboard_Home',
    data() {
      return {
        totalSaldo: 0,
        events: [],
        venues: [],
        upcomingEvents: [], // Event mendatang
        pastEvents: [], // Event yang sudah selesai
        hutang_piutang: [],
        upcomingHp: [],
        pastHp: [],
      }
    },
    methods: {
      fetchTotalSaldo() {
        axios.get('http://127.0.0.1:8000/api/show-total-saldo')
          .then(response => {
            this.totalSaldo = response.data.total_saldo;
          })
          .catch(error => {
            console.error('Error fetching total saldo:', error);
          });
      },
      formatCurrency(value) {
        return new Intl.NumberFormat('id-ID').format(value);
      },
      fetchEvents() {
        axios.get('http://127.0.0.1:8000/api/show-event-for-dashboard')
          .then(response => {
            if (response.data.success) {
              this.upcomingEvents = response.data.upcoming_events;
              this.pastEvents = response.data.past_events;
            } else {
              console.error('Gagal mengambil data event:', response.data.message);
            }
          })
          .catch(error => {
            console.error('Gagal mengambil data event:', error);
          });
      }
    ,
    fetchhutangpiutang() {
        axios.get('http://127.0.0.1:8000/api/show-hp-for-dashboard')
          .then(response => {
            if (response.data.success) {
              this.upcomingHp = response.data.upcoming_hps; // Pastikan variabel ini benar
              this.pastHp = response.data.past_hps;
            } else {
              console.error('Gagal mengambil data HP:', response.data.message);
            }
          })
          .catch(error => {
            console.error('Gagal mengambil data HP:', error);
          });
      }
    },
    mounted() {
      
      this.fetchTotalSaldo();
      this.fetchEvents();
      this.fetchhutangpiutang()
    }
    
  };
  </script>
  
  <style scoped>
  .dashboard-home {
    padding: 20px;
    background: linear-gradient(#1E1E2E, #1E1E2E, #1E1E2E); /* Background ungu tua kehitaman */
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2); /* Garis batas transparan */
    box-shadow: 0 8px 32px 0 rgba(0, 102, 204, 0.37); /* Bayangan lembut */
  }
  
  .dashboard-title {
    color: #EAEAEA; /* Text abu terang */
    text-align: center;
    margin-bottom: 30px;
    font-size: 2.5em;
    text-shadow: 2px 2px 4px rgba(0, 102, 204, 0.1);
  }
  
  .input-columns {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
  }
  
  .input-column {
    width: 30%;
    background: rgba(255, 255, 255, 0.3); /* Background putih transparan */
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 102, 204, 0.1); /* Bayangan lembut */
    text-align: center;
    transition: transform 0.3s ease;
  }
  
  .input-column:hover {
    transform: translateY(-5px);
  }
  
  .input-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 150px;
  }
  
  h3 {
    margin-bottom: 15px;
    color: #EAEAEA; /* Text abu terang */
    font-size: 1.5em;
  }
  
  p {
    margin-bottom: 15px;
    color: #EAEAEA; /* Text abu terang */
  }
  
  .add-button {
    background-color: #00D2FF; /* Background biru cerah */
    color: #EAEAEA; /* Text abu terang */
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .add-button:hover {
    background-color: #3A7BD5; /* Background biru tua */
  }
  
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
  
  .input-column {
    animation: fadeIn 0.5s ease-out;
  }
  .dashboard-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
  }
  
  .glass-card {
              width: 300px;
              
              background: rgba(255, 255, 255, 0.3); /* Background putih transparan */
              backdrop-filter: blur(20px); /* Efek blur */
              border-radius: 15px;
              padding: 20px;
              box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Bayangan lembut */
              border: 1px solid rgba(255, 255, 255, 0.2); /* Garis batas transparan */
              display: flex;
              flex-direction: column;
              align-items: center;
              justify-content: center;
          }
  
          .glass-card h2 {
              color: #000000; /* Text abu terang */
              font-size: 20px;
          }
  
          .glass-card p {
              color: #EAEAEA; /* Text abu terang */
              font-size: 16px;
              text-align: center;
          }
  
          .glass-card button {
              padding: 10px 20px;
              border: none;
              border-radius: 10px;
              background: rgba(255, 255, 255, 0.3); /* Background putih transparan */
              color: #EAEAEA; /* Text abu terang */
              font-size: 16px;
              cursor: pointer;
              transition: background 0.3s ease;
          }
  
  .card h2 {
    margin-bottom: 15px;
    color: #EAEAEA; /* Text abu terang */
  }
  
  .card ul {
    list-style-type: none;
    padding: 0;
  }
  
  .card li {
    margin-bottom: 10px;
  }
  
  .balance {
    font-size: 24px;
    font-weight: bold;
    color: #EAEAEA; /* Text abu terang */
  }
  
  .balance.positive {
    color: green;
  }
  
  .balance.negative {
    color: red;
  }
  
  @media (max-width: 768px) {
    .dashboard-content {
      grid-template-columns: 1fr;
      
    }
  }
  </style>