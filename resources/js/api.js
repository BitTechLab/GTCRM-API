// Object to store AbortController instances
let controllers = {}

async function fetchData(url) {
  const urlObject = new URL(url)
  const mainUrl = urlObject.origin + urlObject.pathname

  // Find and abort the previous controller associated with this main URL
  const prevController = controllers[mainUrl]
  if (prevController) {
    prevController.abort()
  }

  // Create a new AbortController for the current request
  const controller = new AbortController()
  controllers[mainUrl] = controller

  try {
    const response = await fetch(url, { signal: controller.signal })
    const data = await response.json()
    return data;
  } catch (error) {
    if (error.name === 'AbortError') {
      console.log('Previous request aborted')
    } else {
      console.error('Error:', error)
    }
  }
}

export const fetchCustomer = async (search) => {
  return await fetchData('http://localhost:8000/api/v1/customers?name_search=' + search);
}
