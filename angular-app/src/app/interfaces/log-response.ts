export interface LogItem {
  id: number;
  method: string;
  path: string;
  status: number;
  ip: string;
  created_at: string;
}

export interface LogResponse {
  itens: LogItem[];
  total: number;
  page: number;
  per_page: number;
  total_pages: number;
  next_page: number | null;
  previous_page: number | null;
  has_previous_page: boolean;
  has_next_page: boolean;
}
