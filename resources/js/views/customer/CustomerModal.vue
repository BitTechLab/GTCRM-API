<script setup>
import { onMounted, onUpdated } from 'vue'
import { Modal } from 'flowbite'
import { useCustomerStore } from '@/stores/customer';
import { Operation } from '@/enums/operation';
import LoadingEffect from '@/components/effect/LoadingEffect.vue';
import { CustomerStatus } from '@/enums/customer';
import { storeToRefs } from 'pinia';
import ErrorMessage from '@/components/ErrorMessage.vue';

const store = useCustomerStore();
const { customer } = storeToRefs(store);

let modal = null;
onMounted(() => {
    // const $createButton = document.querySelector('#createCustomer');
    // const $editButton = document.querySelector('.editCustomer');
    const $modalElement = document.querySelector('#customerModal');
    const $closeButton = document.querySelector('#closeButton');
    const $closeButtonX = document.querySelector('#closeButtonX');

    const modalOptions = {
        backdropClasses: 'bg-gray opacity-90 fixed inset-0 z-9999'
    }

    if ($modalElement) {
        modal = new Modal($modalElement, modalOptions);
        // $createButton.addEventListener('click', () => modal.toggle());
        // $editButton.addEventListener('click', () => modal.toggle());
        $closeButton.addEventListener('click', () => modal.hide());
        $closeButtonX.addEventListener('click', () => modal.hide());

        // programmatically show
        // modal.show();

        // modal.updateOnHide(() => store.clearModal())
        // modal.updateOnShow(() => store.setModal(true))
    }
})

onUpdated(() => {
    if (store.modal && modal) {
        modal.show();
    }

    if (!store.modal && modal) {
        modal.hide();
    }
})
</script>

<template>
    <div id="customerModal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-999999 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <form @submit.prevent="store.handleCustomerForm">
                    <input type="hidden" name="modal_status" :value="store.modal" />
                    <input type="hidden" name="id" :value="customer?.id" />
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between p-4 md:p-5 border-b border-gray dark:border-gray rounded-t ">
                        <h3 v-if="store.operation === Operation.Add"
                            class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $t('action.createNewCustomer') }}
                        </h3>
                        <h3 v-if="store.operation === Operation.Edit"
                            class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $t('action.updateCustomer') }}
                        </h3>
                        <button id="closeButtonX" type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <ErrorMessage :error="store.errorMessage" />

                    <LoadingEffect :loading="store.modalLoading" />

                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{
                                        $t('label.name') }}</label>
                                <input type="text" name="name" id="name"
                                    class="bg-gray-50 border border-zinc-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    :placeholder="$t('label.name')" v-model="customer.name" required>
                            </div>
                            <div class="col-span-2">
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{
                                        $t('label.email') }}</label>
                                <input type="email" name="email" id="email"
                                    class="bg-gray-50 border border-zinc-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    :placeholder="$t('label.email')" v-model="customer.email" required>
                            </div>
                            <div class="col-span-2">
                                <label for="status"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{
                                        $t('label.status') }}</label>

                                <select name="status" id="status" v-model="customer.status"
                                    class="bg-gray-50 border border-zinc-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option value="">{{ $t('action.selectStatus') }}</option>

                                    <option v-for="status in CustomerStatus" :key="status" :value="status"
                                        :selected="customer.status == status">{{ status }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex p-6 space-x-2 border-t border-gray-200 rounded-b border-gray justify-between">
                        <button type="button" id="closeButton"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">{{
                                $t('action.cancel') }}</button>

                        <button v-if="store.operation === Operation.Add" type="submit" :disabled="store.modalLoading"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{
                                $t('action.create') }}</button>

                        <button v-if="store.operation === Operation.Edit" type="submit" :disabled="store.modalLoading"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{
                                $t('action.update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
