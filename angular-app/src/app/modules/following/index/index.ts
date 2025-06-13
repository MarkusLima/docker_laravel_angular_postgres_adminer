import { ChangeDetectorRef, Component, NgZone } from '@angular/core';
import { FollowingResponse } from '../../../interfaces/following-response';
import { GitHubService } from '../../../../service/github.service';
import { ActivatedRoute, RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'following-index',
  imports: [CommonModule, RouterModule],
  templateUrl: './index.html',
  styleUrl: './index.css'
})
export class IndexFollowing {
  following: FollowingResponse | null = null;
  errorFollowing = '';
  userName = '';
  perPage = 6;
  followingPage = 1;

  constructor(
    private gitHubService: GitHubService, 
    private zone: NgZone, 
    private cdr: ChangeDetectorRef,
    private route: ActivatedRoute
  ) {}

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
          this.following = data,
          this.cdr.detectChanges();
        });
      },
      error: err => {
        this.zone.run(() => {
          this.errorFollowing = err?.error?.error || err?.error?.message || err.message || 'Erro desconhecido ao buscar dados.';
          this.cdr.detectChanges();
        });
      }
    });
  }

  changeFollowingPage(delta: number) {
    this.followingPage += delta;
    if (this.followingPage < 1) this.followingPage = 1;
    this.fetchFollowing();
  }

}
