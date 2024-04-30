import { defineStore } from 'pinia'
import { CUSTOMER_API, getRequest, postRequest, putRequest, deleteRequest } from '@/api'
import { Operation } from '@/enums/operation'
import { ref } from 'vue'
import { Customer } from '@/interfaces/customer'
import { SORT_BY_ID, SORT_DIRECTION_ASC } from '@/const'

export const useCustomerStore = defineStore('customer', () => {
  const page = ref(0);
  const count = ref(0)
  const customers = ref<Customer[]>([])
  const customer = ref<Customer>({} as Customer)
  const pagination = ref([])
  const search = ref('')
  const loading = ref(false)
  const errorMessage = ref('')
  const operation = ref(Operation.None)
  const modal = ref(false)
  const modalLoading = ref(false)
  const deleteLoading = ref(false)
  const deleteErrorMessage = ref('')
  const showDelete = ref(false)
  const sort = ref();
  const direction = ref();

  const fetchCustomers = async () => {
    loading.value = true

    const { data, error } = await getRequest(CUSTOMER_API, {
      name_search: search.value,
      page: page.value,
      sort: sort.value || SORT_BY_ID,
      direction: direction.value || SORT_DIRECTION_ASC,
    })

    count.value = data?.count
    customers.value = data?.data || []
    pagination.value = data?.meta?.links
    errorMessage.value = error
    loading.value = false
  }

  const editCustomer = async (id: Number) => {
    clearModal()

    modalLoading.value = true
    modal.value = true
    operation.value = Operation.Edit
    customer.value = {}

    const { data, error } = await getRequest(`${CUSTOMER_API}/${id}`)
    customer.value = data?.data
    errorMessage.value = error

    modalLoading.value = false
  }

  const addCustomer = async () => {
    clearModal()

    modal.value = true
    operation.value = Operation.Add
  }

  const deleteCustomer = async (id: number) => {
    operation.value = Operation.Delete

    console.log(id)
    operation.value = Operation.None
  }

  const clearModal = () => {
    customer.value = {}
    modalLoading.value = false
    operation.value = Operation.None
    errorMessage.value = ''
  }

  const handleCustomerForm = async () => {
    modalLoading.value = true
    errorMessage.value = ''

    const requestData = {
      name: customer.value?.name,
      email: customer.value?.email,
      status: customer.value?.status
    }

    if (operation.value === Operation.Edit) {
      const { data, error } = await putRequest(CUSTOMER_API, customer.value?.id, requestData)
      errorMessage.value = error
    } else {
      const { data, error } = await postRequest(CUSTOMER_API, requestData)
      errorMessage.value = error
    }

    modalLoading.value = false

    if (!errorMessage.value) {
      if (operation.value !== Operation.Edit) {
        modal.value = false
        // clearModal()
      }

      fetchCustomers()
    }
  }

  const handleDelete = async (id: number) => {
    deleteLoading.value = true

    const { data, error } = await deleteRequest(CUSTOMER_API, id)

    if (error) {
      deleteErrorMessage.value = error
    } else {
      showDelete.value = false
      fetchCustomers()
    }

    deleteLoading.value = false
  }

  return {
    addCustomer,
    clearModal,
    count,
    customer,
    customers,
    deleteErrorMessage,
    deleteCustomer,
    deleteLoading,
    direction,
    editCustomer,
    errorMessage,
    fetchCustomers,
    handleCustomerForm,
    handleDelete,
    loading,
    modal,
    modalLoading,
    operation,
    page,
    pagination,
    search,
    showDelete,
    sort,
  }
})
