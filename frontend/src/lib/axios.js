import Axios from 'axios'
import { useAuth } from '@/stores/auth'

const apiUrl = import.meta.env.VITE_CAR_PARKING_BACKEND_API

const axios = Axios.create({
  baseURL: `${apiUrl}/api/v1`,
  withCredentials: true,
  withXSRFToken: true,
  headers: {
    Accept: 'application/json',
    common: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  }
})

axios.interceptors.request.use(async (req) => {
  if (req.method === 'get') {
    return req
  }

  let xsrfToken = getBrowserCookieValue('XSRF-TOKEN')

  if (!xsrfToken) {
    await window.axios.get(`${apiUrl}/sanctum/csrf-cookie`)
  }

  return req
})

axios.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401 || error.response?.status === 419) {
      const auth = useAuth()
      auth.destroyTokenAndRedirectTo()
    }

    return Promise.reject(error)
  }
)

function getBrowserCookieValue(cname) {
  const name = cname + '='
  const decodedCookie = decodeURIComponent(document.cookie)
  const ca = decodedCookie.split(';')
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i]
    while (c.charAt(0) == ' ') {
      c = c.substring(1)
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length)
    }
  }

  return ''
}

export default axios
