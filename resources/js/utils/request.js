import axios from 'axios';
import { toastError } from './alert';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;

// Create axios instance
const request = axios.create({
  baseURL: process.env.MIX_BASE_API,
  timeout: 10000, // Request timeout
});

// Response interceptor
request.interceptors.response.use(
  response => {
    return response.data;
  },
  error => {
    const message = error.response.data.message;
    if (!document.querySelector('#login-page')) toastError(message);
    return Promise.reject(error);
  }
);

export default request;
