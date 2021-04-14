import { RouteProps } from 'react-router-dom';
import { Dashboard } from '../pages/Dashboard';
import CategoryList from '../pages/category/PageList';
import CategoryCreate from '../pages/category/PageForm';
import GenreList from '../pages/genre/PageList';
import GenreCreate from '../pages/genre/PageForm';
import CastMemberList from '../pages/member/PageList';
import CastMemberCreate from '../pages/member/PageForm';

export interface MyRouteProps extends RouteProps {
  name: string;
  label: string;
}

const routes: MyRouteProps[] = [
  {
    name: 'dashboard',
    label: 'Dashboard',
    path: '/',
    component: Dashboard,
    exact: true,
  },
  {
    name: 'categories.list',
    label: 'Listar categorias',
    path: '/categories',
    component: CategoryList,
    exact: true,
  },
  {
    name: 'categories.create',
    label: 'Criar categoria',
    path: '/categories/create',
    component: CategoryCreate,
    exact: true,
  },
  {
    name: 'genres.list',
    label: 'Listar gêneros',
    path: '/genres',
    component: GenreList,
    exact: true,
  },
  {
    name: 'genres.create',
    label: 'Criar gêneros',
    path: '/genres/create',
    component: GenreCreate,
    exact: true,
  },
  {
    name: 'members.list',
    label: 'Listar Membros',
    path: '/menbers',
    component: CastMemberList,
    exact: true,
  },
  {
    name: 'members.create',
    label: 'Criar membros de elencos',
    path: '/menbers/create',
    component: CastMemberCreate,
    exact: true,
  },

  {
    name: 'categories.edit',
    label: 'Editar Categoria',
    path: '/categories/:id/edit',
    component: CategoryList,
    exact: true,
  },
];

export default routes;
