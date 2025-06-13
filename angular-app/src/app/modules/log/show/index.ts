import { ChangeDetectorRef, Component, NgZone } from '@angular/core';
import { GitHubService } from '../../../../service/github.service';
import { ActivatedRoute, Router, RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'log-show',
  imports: [CommonModule, FormsModule, RouterModule],
  templateUrl: './index.html',
  styleUrl: './index.css'
})
export class ShowLog {

    log: any = null;
    errorLog = '';
  
    constructor(
      private gitHubService: GitHubService, 
      private zone: NgZone, 
      private cdr: ChangeDetectorRef,
      private router: Router,
      private route: ActivatedRoute
    ) {}
  
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
        error: err => err?.error?.error || err?.error?.message || err.message || 'Erro desconhecido ao buscar dados.'
      });
    }

    getKeys(obj: any): string[] {
      return obj ? Object.keys(obj) : [];
    }

    isUrl(value: any): boolean {
      return typeof value === 'string' && value.startsWith('http');
    }
    
}
