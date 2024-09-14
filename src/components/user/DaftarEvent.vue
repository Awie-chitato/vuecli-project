<template>
    <div>
      <table class="eventlist-table">
        <thead>
          <tr>
            <th style="display: none;">ID</th>
            <th>Nama Event</th>
            <th>Nama Tempat</th>
            <th>Tanggal</th>
            
          </tr>
        </thead>
        <tbody>
          <tr v-for="(event, index) in eventlist" :key="index">
            <td style="display: none;">{{ event.id }}</td>
            <td>{{ event.nama_event }}</td>
            <td>{{ event.tempat_event }}</td>
            <td>{{ event.tanggal_event }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'DaftarEvent',
    data() {
      return {
        showInputForm: false,
        newEventList: {
          id: null,
          nama_event: '',
          tempat_event: '',
          tanggal_event: ''
        },
        eventlist: [] // Pastikan eventlist dideklarasikan di data
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
      },
      fetchEventList() {
        axios.get('http://127.0.0.1:8000/api/show-semua-event-fpti')
          .then(response => {
            // Memperbarui data eventlist dengan data dari server
            this.eventlist = response.data.data;
          })
          .catch(error => {
            console.error('Error fetching event list:', error);
          });
      },
      editItem(event) {
        // Implementasi edit item
      },
      deleteItem(event) {
        // Implementasi delete item
      }
    },
    mounted() {
      this.fetchEventList();
    }
  };
  </script>
  
  <style scoped>
  .eventlist-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: #1E1E2E; /* Background ungu tua kehitaman */
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }
  
  .eventlist-table th, .eventlist-table td {
    padding: 15px;
    border-bottom: 1px solid #e0e0e0;
  }
  
  .eventlist-table th {
    background: linear-gradient(#00D2FF, #3A7BD5); /* Background biru cerah ke biru tua */
    color: #EAEAEA; /* Text abu terang */
    font-weight: bold;
    text-transform: uppercase;
  }
  
  .eventlist-table tr:hover {
    background: #f1f1f1; /* Background hover */
    transition: background 0.3s ease;
  }
  
  .eventlist-table tr:nth-child(even) {
    background: #f4f7fc; /* Background baris genap */
  }
  
  .eventlist-table td {
    font-size: 14px;
    color: #333;
  }
  
  .eventlist-table th:first-child, .eventlist-table td:first-child {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
  }
  
  .eventlist-table th:last-child, .eventlist-table td:last-child {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
  }
  </style>
  