import { Routes } from '@angular/router';
import { IndexUser } from './modules/user/index/index';
import { IndexFollowing } from './modules/following/index/index';
import { IndexLog } from './modules/log/index/index';

export const routes: Routes = [
    { path: "user", component: IndexUser },
    { path: "following", component: IndexFollowing },
    { path: "log", component: IndexLog },
    { path: '', redirectTo: 'user', pathMatch: 'full'},
    { path: '**', redirectTo: 'user'}
];
