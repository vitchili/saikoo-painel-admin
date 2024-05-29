import axios from 'axios';

const axiosInstance = axios.create();

const headers = { 
    // Authorization: `Bearer ${token}`,
    'Content-Type': 'application/json'
};

export function get(endpoint) {
    return axiosInstance.get(endpoint, headers);
  }
  
  export function post(endpoint, data = {}) {
    return axiosInstance.post(endpoint, data, headers);
  }
  
  export function put(endpoint, data = {}) {
    return axiosInstance.put(endpoint, data, headers);
  }
  
  export function remove(endpoint) {
    return axiosInstance.delete(endpoint, headers);
  }