import Dashboard from '@/components/admin/Dashboard.vue';
import DashboardHome from '@/components/admin/DashboardHome.vue';
import DebtCredit from '@/components/admin/DebtCredit.vue';
import EventList from '@/components/admin/EventList.vue';
import Financials from '@/components/admin/Financials.vue';
import Settings from '@/components/admin/Settings.vue';
import Transactions from '@/components/admin/Transactions.vue';
import Login from '@/components/Login.vue';
import DaftarEvent from '@/components/user/DaftarEvent.vue';
import Dashboard_Home from '@/components/user/Dashboard_Home.vue';
import DashboardUser from '@/components/user/DashboarUser.vue';
import HpUser from '@/components/user/HpUser.vue';
import TransaksiEvent from '@/components/user/TransaksiEvent.vue';

import { createRouter, createWebHistory } from 'vue-router';

const routes = [
  
    { path: '/', name: 'login', component: Login },
    { 
      path: '/dashboard', 
      name: 'admin-home', 
      component: Dashboard, 
      meta: { requiresAuth: true } ,
  
    children: [
        {
          path: 'dashboardhome',
          name: 'DashboardHome',
          component: DashboardHome,
        },

        {
          path: 'eventlist',
          name: 'EventList',
          component: EventList,
        },

        {
          path: 'transactions',
          name: 'Transactions',
          component: Transactions,
        },
        {
          path: 'financials',
          name: 'Financials',
          component: Financials,
        },
        {
          path: 'debt-credit',
          name: 'DebtCredit',
          component: DebtCredit,
        },
        {
          path: 'settings',
          name: 'Settings',
          component: Settings,
        },
      ],
  },
  {
    path: '/dashboarduser',
    name: 'user-home',
    component: DashboardUser,
    meta: { requiresAuth: true, role: 'user' },
    children: [
      {
        path: 'dashboard_home',
          name: 'Dashboard_Home',
          component: Dashboard_Home,
        },
        {
          path: 'daftarevent',
            name: 'DaftarEvent',
            component: DaftarEvent,
          },
          {
            path: 'transaksievent',
              name: 'TransaksiEvent',
              component: TransaksiEvent,
            },
            {
              path: 'hpuser',
                name: 'HpUser',
                component: HpUser,
              },
      ],
  },
];

const Router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});


export default Router;
