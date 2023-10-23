import { ref, computed } from 'vue';

const isAuthenticated = ref(false);
const user = ref(null);

const login = async (credentials) => {
    try {
      await axios.get('/sanctum/csrf-token');
      const response = await axios.post('/api/login', credentials);
      isAuthenticated.value = true;
      user.value = response.data;
      // Store the authentication token in a secure way (e.g., localStorage or cookies)
    } catch (error) {
      // Handle login error
      console.log(error.message);
    }
  };


  const register = async (userData) => {
    try {
      const response = await axios.post('/api/register', userData);
      isAuthenticated.value = true;
      user.value = response.data.user;
      // Store the authentication token
    } catch (error) {
      // Handle registration error
    }
  };

  const logout = async () => {
    try {
      await axios.post('/api/logout');
      isAuthenticated.value = false;
      user.value = null;
      // Remove the authentication token
    } catch (error) {
      // Handle logout error
    }
  };

  const auth = computed(() => ({
    isAuthenticated: isAuthenticated.value,
    user: user.value,
  }));


  export default function useAuth() {
    return {
      ...auth,
      login,
      register,
      logout,
    };
  }
