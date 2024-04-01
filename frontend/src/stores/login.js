import { reactive, ref } from 'vue'
import { defineStore } from 'pinia'
import { useAuth } from '@/stores/auth'

export const useLogin = defineStore('login', () => {
  const auth = useAuth()
  const errors = reactive({})
  const loading = ref(false)
  const form = reactive({
    email: 'javazaq@mailinator.com',
    password: 'password',
    remember: false
  })

  function resetForm() {
    form.email = ''
    form.password = ''
    form.remember = false

    errors.value = {}
  }

  async function handleSubmit() {
    if (loading.value) return

    loading.value = true
    errors.value = {}

    await window.axios
      .post('auth/login', form)
      .then(() => {
        auth.login()
      })
      .catch((error) => {
        if (error.response?.status === 422) {
          errors.value = error.response.data.errors
        }
      })
      .finally(() => {
        form.password = ''
        loading.value = false
      })
  }

  return { form, errors, loading, resetForm, handleSubmit }
})
