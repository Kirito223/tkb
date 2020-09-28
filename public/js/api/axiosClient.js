import {baseURl} from './api.js';

const axiosClient = axios.create({
    baseURL: baseURl,
    headers: {
        "content-type": "application/json",
        // "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),
    },
});
axiosClient.interceptors.response.use((response) => {
    if (response && response.data) {
      return response.data;
    }
  
    return response;
  }, (error) => {
    // Handle errors
    throw error;
  });
export default axiosClient;