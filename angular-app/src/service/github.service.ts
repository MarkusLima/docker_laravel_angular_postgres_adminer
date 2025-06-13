import { HttpClient, HttpParams } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { User } from '../app/interfaces/user';
import { FollowingResponse } from '../app/interfaces/following-response';
import { LogResponse } from '../app/interfaces/log-response';

@Injectable({
  providedIn: 'root',
})
export class GitHubService {
  private apiUrl = 'http://localhost/api'; // Ajuste para sua URL da API

  private http = inject(HttpClient);

  getUser(userName: string): Observable<User> {
    return this.http.get<User>(`${this.apiUrl}/user/${userName}`);
  }

  getFollowing(userName: string, per_page?: number, page?: number): Observable<FollowingResponse> {
    let params = new HttpParams();
    if (per_page) params = params.set('per_page', per_page.toString());
    if (page) params = params.set('page', page.toString());

    return this.http.get<FollowingResponse>(`${this.apiUrl}/following/${userName}`, { params });
  }

  getLogs(per_page?: number, page?: number, search?: string): Observable<LogResponse> {
    let params = new HttpParams();
    if (per_page) params = params.set('per_page', per_page.toString());
    if (page) params = params.set('page', page.toString());
    if (search) params = params.set('search', search);

    return this.http.get<LogResponse>(`${this.apiUrl}/logs`, { params });
  }

  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  getLog(id?: string): Observable<any> {
    return this.http.get<LogResponse>(`${this.apiUrl}/logs/${id}`);
  }
}
