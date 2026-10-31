import axios from 'axios';

// API client cấu hình an toàn, không hardcode credentials
const API_BASE_URL = process.env.REACT_APP_API_URL || 'http://localhost:5000/api';

const apiClient = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
  },
  timeout: 10000,
});

// Interceptor tự động thêm Bearer token vào Authorization header mà không lộ trong URL
apiClient.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('cookio_token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
);

// Interceptor xử lý lỗi bảo mật tập trung (401 tự động logout xóa token hết hạn)
apiClient.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response && error.response.status === 401) {
      localStorage.removeItem('cookio_token');
      localStorage.removeItem('cookio_user');
    }
    return Promise.reject(error);
  }
);

export const authAPI = {
  login: (credentials) => apiClient.post('/auth/login', credentials),
  register: (data) => apiClient.post('/auth/register', data),
  getProfile: () => apiClient.get('/auth/profile'),
};

export const recipeAPI = {
  getAll: (params) => apiClient.get('/recipes', { params }),
  getById: (id) => apiClient.get(`/recipes/${id}`),
  create: (data) => apiClient.post('/recipes', data),
  update: (id, data) => apiClient.put(`/recipes/${id}`, data),
  delete: (id) => apiClient.delete(`/recipes/${id}`),
  like: (id) => apiClient.post(`/recipes/${id}/like`),
};

export default apiClient;
