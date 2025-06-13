import { ChangeDetectorRef, Component, inject, NgZone, OnInit } from '@angular/core';
import { GitHubService } from '../../../../service/github.service';
import { ActivatedRoute, RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-log-show',
  imports: [CommonModule, FormsModule, RouterModule],
  templateUrl: './index.html',
  styleUrl: './index.css',
})
export class ShowLog implements OnInit {
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  log: any = null;
  errorLog = '';

  private gitHubService = inject(GitHubService);
  private zone = inject(NgZone);
  private cdr = inject(ChangeDetectorRef);
  private route = inject(ActivatedRoute);

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.fetchLog(id);
    }
  }

  fetchLog(id: string) {
    this.errorLog = '';
    this.gitHubService.getLog(id).subscribe({
      next: data => {
        this.zone.run(() => {
          this.log = data;
          this.cdr.detectChanges();
        });
      },
      error: err =>
        err?.error?.error ||
        err?.error?.message ||
        err.message ||
        'Erro desconhecido ao buscar dados.',
    });
  }

  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  getKeys(obj: any): string[] {
    return obj ? Object.keys(obj) : [];
  }

  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  isUrl(value: any): boolean {
    return typeof value === 'string' && value.startsWith('http');
  }
}
