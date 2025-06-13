export interface FollowingItem {
  login: string;
  id: number;
  avatar_url: string;
  html_url: string;
  [key: string]: any; // Permite outros campos extras
}

export interface FollowingResponse {
  itens: FollowingItem[];
  total: number;
  page: number;
  per_page: number;
  total_pages: number;
  next_page: number;
  previous_page: number;
  has_previous_page: boolean;
  has_next_page: boolean;
}
