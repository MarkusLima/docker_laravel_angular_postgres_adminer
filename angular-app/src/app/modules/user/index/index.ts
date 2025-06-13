import { ChangeDetectorRef, Component, inject, NgZone, OnInit } from '@angular/core';
import { GitHubService } from '../../../../service/github.service';
import { ActivatedRoute, RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { User } from '../../../interfaces/user';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-user-index',
  standalone: true,
  imports: [RouterModule, FormsModule, CommonModule],
  templateUrl: './index.html',
  styleUrls: ['./index.css'],
})
export class IndexUser implements OnInit {
  userName = 'markuslima';
  user: User | null = null;
  errorUser = '';

  private gitHubService = inject(GitHubService);
  private zone = inject(NgZone);
  private cdr = inject(ChangeDetectorRef);
  private route = inject(ActivatedRoute);

  ngOnInit(): void {
    const userName = this.route.snapshot.paramMap.get('userName');
    if (userName) {
      this.userName = userName;
      this.fetchUser();
    }
  }

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
          this.errorUser =
            err?.error?.error ||
            err?.error?.message ||
            err.message ||
            'Erro desconhecido ao buscar dados.';
          this.cdr.detectChanges();
        });
      },
    });
  }
}
