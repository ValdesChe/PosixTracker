
import VueRouter from 'vue-router';
import LiveTrackingComponent from './components/LiveTrackingComponent.vue';
import HomeComponent from './components/HomeComponent.vue';
import StatisticsComponent from './components/StatisticsComponent.vue';
const routes = [
    { path: '/', component: HomeComponent },
    { path: '/live', component: LiveTrackingComponent },
    { path: '/stats', component: StatisticsComponent }
  ]
  export default router = new VueRouter({
    routes // raccourci pour `routes: routes`
  })
  