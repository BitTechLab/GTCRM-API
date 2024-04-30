import axios from 'axios'
// import router from './router'

axios.defaults.withCredentials = true
axios.defaults.withXSRFToken = true

export const LOGIN_API: string = '/api/auth/login'
export const LOGOUT_API: string = '/api/auth/logout'
export const REGISTER_API: string = '/api/auth/register'
export const CUSTOMER_API: string = '/api/v1/customers'

// Object to store AbortController instances
// let controllers = {}

// async function fetchData(url) {
//   const urlObject = new URL(url)
//   const mainUrl = urlObject.origin + urlObject.pathname

//   // Find and abort the previous controller associated with this main URL
//   const prevController = controllers[mainUrl]
//   if (prevController) {
//     prevController.abort()
//   }

//   // Create a new AbortController for the current request
//   const controller = new AbortController()
//   controllers[mainUrl] = controller

//   try {
//     const response = await fetch(url, { signal: controller.signal })
//     const data = await response.json()
//     return data
//   } catch (error) {
//     if (error.name === 'AbortError') {
//       console.log('Previous request aborted')
//     } else {
//       console.error('Error:', error)
//     }
//   }
// }

export const getRequest = async (
  apiEndpoint: string,
  params: object = {},
  headers: object = {}
) => {
  try {
    const data = await axios.get(apiEndpoint, {
      params,
      headers
    })

    return { data: data?.data, error: null }
  } catch (error) {
    if (error.response?.status === 401) {
      location.reload()
    }

    return { error, data: null }
  }
}

export const postRequest = async (apiEndpoint: string, data: Object, headers: object = {}) => {
  try {
    const response = await axios.post(apiEndpoint, data, {
      headers
    })

    return { data: response?.data, error: null }
  } catch (error) {
    if (error.response?.status === 401) {
      location.reload()
    }

    return { error, data: null }
  }
}

export const putRequest = async (
  apiEndpoint: string,
  id: number,
  data: Object,
  headers: object = {}
) => {
  try {
    const response = await axios.put(`${apiEndpoint}/${id}`, data, {
      headers
    })

    return { data: response?.data, error: null }
  } catch (error) {
    if (error.response?.status === 401) {
      location.reload()
    }

    return { error, data: null }
  }
}

export const deleteRequest = async (
  apiEndpoint: string,
  id: number
) => {
  try {
    const response = await axios.delete(`${apiEndpoint}/${id}`)

    return { data: response?.data, error: null }
  } catch (error) {
    if (error.response?.status === 401) {
      location.reload()
    }

    return { error, data: null }
  }
}