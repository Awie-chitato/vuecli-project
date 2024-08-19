import { createRouter, createWebHistory } from 'vue-router';
import AdminPart1 from '../components/AdminPart1`.vue';
import Dashboard from '../components/Dashboard.vue';
import DashboardHome from '../components/DashboardHome.vue';
import DebtCredit from '../components/DebtCredit.vue';
import Financials from '../components/Financials.vue';
import Settings from '../components/Settings.vue';
import Transactions from '../components/Transactions.vue';

const routes = [
  {
    path: '/',
    name: 'AdminPart1',
    component: AdminPart1,
  },
  {
    path: '/dashboard',
    component: Dashboard,
    children: [
        {
          path: 'dashboardhome',
          name: 'DashboardHome',
          component: DashboardHome,
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
];

const Router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default Router;
