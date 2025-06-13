import { ChangeDetectorRef, Component, inject, NgZone, OnInit } from '@angular/core';
import { LogResponse } from '../../../interfaces/log-response';
import { GitHubService } from '../../../../service/github.service';
import { RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { formatarData } from '../../../../utils/date-utils';

@Component({
  selector: 'app-log-index',
  imports: [CommonModule, FormsModule, RouterModule],
  templateUrl: './index.html',
  styleUrl: './index.css',
})
export class IndexLog implements OnInit {
  searchTerm = '';
  logs: LogResponse | null = null;
  logsPage = 1;
  perPage = 10;
  errorLogs = '';

  private gitHubService = inject(GitHubService);
  private zone = inject(NgZone);
  private cdr = inject(ChangeDetectorRef);

  ngOnInit(): void {
    this.fetchLogs();
  }

  fetchLogs() {
    this.errorLogs = '';
    this.gitHubService.getLogs(this.perPage, this.logsPage, this.searchTerm).subscribe({
      next: data => {
        this.zone.run(() => {
          this.logs = {
            ...data,
            itens: data.itens.map(item => ({ ...item, created_at: formatarData(item.created_at) })),
          };
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

  changeLogsPage(delta: number) {
    this.logsPage += delta;
    if (this.logsPage < 1) this.logsPage = 1;
    this.fetchLogs();
  }
}
