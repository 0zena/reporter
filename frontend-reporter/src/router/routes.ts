import HomeView from '../views/HomeView.vue'
import VacanciesList from '../views/VacanciesList.vue'
import NotFound from "@/views/errors/NotFoundView.vue";

const routes = [ 
    { path: '/', name: 'home', component: HomeView },
    { path: '/about', name: 'about', component: () => import('../views/AboutView.vue') },
    { path: '/vacancies', name: 'vacancies', component:  VacanciesList },
    { path: '/:catchAll(.*)', name: 'NotFound', component: NotFound}
]

export default routes;