import { Routes } from '@angular/router';
import { IndexUser } from './modules/user/index/index';
import { IndexFollowing } from './modules/following/index/index';
import { IndexLog } from './modules/log/index/index';
import { ShowLog } from './modules/log/show';

export const routes: Routes = [
    { path: "user", component: IndexUser },
    { path: "user/:userName", component: IndexUser }, 
    { path: "following/:userName", component: IndexFollowing },
    { path: "log", component: IndexLog },
    { path: "log/:id", component: ShowLog },
    { path: '', redirectTo: 'user', pathMatch: 'full'},
    { path: '**', redirectTo: 'user'}
];
