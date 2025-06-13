export interface User {
  login: string;
  id: number;
  node_id: string;
  avatar_url: string;
  bio: string | null;
  blog: string;
  company: string | null;
  created_at: string;
  email: string | null;
  followers: number;
  following: number;
  html_url: string;
  location: string;
  name: string;
  public_gists: number;
  public_repos: number;
  twitter_username: string | null;
  updated_at: string
}
