import VacanciesList from '../views/VacanciesList.vue'
import LoginView from '../views/LoginView.vue';
import RegisterView from '../views/RegisterView.vue';
import ForgotPassword from '@/components/ForgotPassword.vue';
import NotFound from "@/views/errors/NotFoundView.vue";
import Exports from "@/views/Exports.vue";
import HomePage from "@/views/HomePage.vue";
import Admin from "@/views/Admin.vue";
import VacancyEditor from '@/views/VacancyEditor.vue';
import VacancyFullScreen from '../views/VacancyFullScreen.vue';
import FavoritesList from '@/views/FavoritesList.vue';
import UserGuide from '@/views/UserGuide.vue';
import AdminGuide from '@/views/AdminGuide.vue';
import CategoryEditorPage from '@/views/CategoryEditorPage.vue';

const routes = [
    { path: '/', name: 'home', component: HomePage },
    { path: '/vacancies', name: 'vacancies', component: VacanciesList },
    { path: '/login', name: 'login', component: LoginView },
    { path: '/forgot-password', name: 'forgot-password', component: ForgotPassword },
    { path: '/register', name: 'register', component: RegisterView },
    { path: '/exports', name: 'exports', component: Exports },
    { path: '/admin', name: 'admin', component: Admin },
    { path: '/editor', name: 'editor', component: VacancyEditor },
    { path: '/vacancy/fullscreen', name: 'vacancy-fullscreen', component: VacancyFullScreen },
    { path: '/favorites', name: 'favorites', component: FavoritesList },
    { path: '/user-guide', name: 'user-guide', component: UserGuide },
    { path: '/admin-guide', name: 'admin-guide', component: AdminGuide },
    { path: '/admin/add-category', name: 'category-editor', component: CategoryEditorPage },
    { path: '/:catchAll(.*)', name: 'NotFound', component: NotFound },
  ];
  
  export default routes;
  