import api from '../config/axios.config';

export interface IHttpClient {
  get<T>(url: string, config?: Record<string, unknown>): Promise<T>;
  post<T>(url: string, data?: unknown, config?: Record<string, unknown>): Promise<T>;
  put<T>(url: string, data?: unknown, config?: Record<string, unknown>): Promise<T>;
  delete<T>(url: string, config?: Record<string, unknown>): Promise<T>;
}

class HttpClient implements IHttpClient {
  async get<T>(url: string, config: Record<string, unknown> = {}): Promise<T> {
    return api.get<T>(url, config).then(response => response.data);
  }
  async post<T>(url: string, data?: unknown, config?: Record<string, unknown>): Promise<T> {
    return api.post<T>(url, data, config).then(response => response.data);
  }
  async put<T>(url: string, data?: unknown, config?: Record<string, unknown>): Promise<T> {
    return api.put<T>(url, data, config).then(response => response.data);
  }
  async delete<T>(url: string, config?: Record<string, unknown>): Promise<T> {
    return api.delete<T>(url, config).then(response => response.data);
  }
}

export default HttpClient;