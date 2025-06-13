import { ChangeDetectorRef, Component, inject, NgZone, OnInit } from '@angular/core';
import { FollowingResponse } from '../../../interfaces/following-response';
import { GitHubService } from '../../../../service/github.service';
import { ActivatedRoute, RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-following-index',
  imports: [CommonModule, RouterModule],
  templateUrl: './index.html',
  styleUrl: './index.css',
})
export class IndexFollowing implements OnInit {
  following: FollowingResponse = {
    itens: [],
    page: 1,
    total_pages: 1,
    has_next_page: false,
    has_previous_page: false,
    total: 0,
    per_page: 6,
    next_page: 0,
    previous_page: 0,
  };
  errorFollowing = '';
  userName = '';
  perPage = 6;
  followingPage = 1;

  private gitHubService = inject(GitHubService);
  private zone = inject(NgZone);
  private cdr = inject(ChangeDetectorRef);
  private route = inject(ActivatedRoute);

  ngOnInit(): void {
    this.route.paramMap.subscribe(params => {
      const userName = params.get('userName');
      if (userName) {
        this.userName = userName;
        this.fetchFollowing();
      }
    });
  }

  fetchFollowing() {
    this.errorFollowing = '';
    this.gitHubService.getFollowing(this.userName, this.perPage, this.followingPage).subscribe({
      next: data => {
        this.zone.run(() => {
          this.following = data;
          this.cdr.detectChanges();
        });
      },
      error: err => {
        this.zone.run(() => {
          this.errorFollowing =
            err?.error?.error ||
            err?.error?.message ||
            err.message ||
            'Erro desconhecido ao buscar dados.';
          this.cdr.detectChanges();
        });
      },
    });
  }

  changeFollowingPage(delta: number) {
    this.followingPage += delta;
    if (this.followingPage < 1) this.followingPage = 1;
    this.fetchFollowing();
  }
}
