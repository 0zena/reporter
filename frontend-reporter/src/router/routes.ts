import VacanciesList from '../views/VacanciesList.vue'
import LoginView from '../views/LoginView.vue';
import RegisterView from '../views/RegisterView.vue';
import ForgotPassword from '@/components/ForgotPassword.vue';
import NotFound from "@/views/errors/NotFoundView.vue";
import Exports from "@/views/Exports.vue";
import HomePage from "@/views/HomePage.vue";
import Admin from "@/views/Admin.vue";
import VacancyEditor from '@/views/VacancyEditor.vue';

const routes = [ 
    { path: '/', name: 'home', component: HomePage },
    { path: '/about', name: 'about', component: () => import('../views/AboutView.vue') },
    { path: '/vacancies', name: 'vacancies', component:  VacanciesList },
    { path: '/login', name: 'login', component: LoginView },
    { path: '/forgot-password', name: 'forgot-password', component: ForgotPassword },
    { path: '/register', name: 'register', component: RegisterView },
    { path: '/exports', name: 'exports', component: Exports },
    { path: '/admin', name: 'admin', component: Admin },
    { path: '/editor', name: 'editor', component: VacancyEditor },
    { path: '/:catchAll(.*)', name: 'NotFound', component: NotFound}
]

export default routes;