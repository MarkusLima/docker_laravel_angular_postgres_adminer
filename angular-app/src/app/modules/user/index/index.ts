import { ChangeDetectorRef, Component, NgZone } from '@angular/core';
import { GitHubService } from '../../../../service/github.service';
import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { User } from '../../../interfaces/user';
import { CommonModule } from '@angular/common';
import { FollowingResponse } from '../../../interfaces/following-response';
import { LogResponse } from '../../../interfaces/log-response';

@Component({
  selector: 'app-index',
  standalone: true,
  imports: [
    RouterModule, FormsModule, CommonModule
  ],
  templateUrl: './index.html',
  styleUrls: ['./index.css']
})
export class IndexUser {
  
  userName = 'markus';
  searchTerm = '';
  user: User | null = null;
  following: FollowingResponse | null = null;
  logs: LogResponse | null = null;

  followingPage = 1;
  logsPage = 1;
  perPage = 1;

  errorUser = '';
  errorFollowing = '';
  errorLogs = '';

  constructor(private gitHubService: GitHubService, private zone: NgZone, private cdr: ChangeDetectorRef) {}

  fetchUser() {
    this.errorUser = '';
    this.gitHubService.getUser(this.userName).subscribe({
      next: data => {
        this.zone.run(() => {
          this.user = data;
          this.cdr.detectChanges();
        });
      },
      error: err => {
        this.zone.run(() => {
          this.errorUser = 'Erro ao buscar usuário.';
          this.cdr.detectChanges();
        });
      }
    });
  }

  fetchFollowing() {
    this.errorFollowing = '';
    this.gitHubService.getFollowing(this.userName, this.perPage, this.followingPage).subscribe({
      next: data => this.following = data,
      error: err => this.errorFollowing = 'Erro ao buscar followings.'
    });
  }

  changeFollowingPage(delta: number) {
    this.followingPage += delta;
    if (this.followingPage < 1) this.followingPage = 1;
    this.fetchFollowing();
  }

  fetchLogs() {
    this.errorLogs = '';
    this.gitHubService.getLogs(this.perPage, this.logsPage, this.searchTerm).subscribe({
      next: data => this.logs = data,
      error: err => this.errorLogs = 'Erro ao buscar logs.'
    });
  }

  changeLogsPage(delta: number) {
    this.logsPage += delta;
    if (this.logsPage < 1) this.logsPage = 1;
    this.fetchLogs();
  }
}
