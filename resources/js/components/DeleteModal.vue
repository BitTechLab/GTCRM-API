<script setup lang="ts">
import { onMounted, onUpdated } from 'vue'
import { Modal } from 'flowbite'
// import { Operation } from '@/enums/operation';
import LoadingEffect from '@/components/effect/LoadingEffect.vue';
import ErrorMessage from '@/components/ErrorMessage.vue';

// Define interface for props
interface DeleteProps {
  show: boolean;
  id: number;
  loading: boolean,
  errorMessage: string,
  handleDelete: any,
}

const props = defineProps<DeleteProps>();

let deleteModal: Modal|null = null;

onMounted(() => {
    const $modalElement = document.querySelector('#deleteModal');
    const $closeButton = document.querySelector('#deleteCloseButton');
    const $closeButtonX = document.querySelector('#deleteCloseButtonX');

    const modalOptions = {
        backdropClasses: 'bg-gray opacity-90 fixed inset-0 z-9999'
    }

    if ($modalElement) {
        deleteModal = new Modal($modalElement, modalOptions);
        $closeButton?.addEventListener('click', () => deleteModal?.hide());
        $closeButtonX?.addEventListener('click', () => deleteModal?.hide());
    }
})

onUpdated(() => {
    if (props.show && deleteModal) {
        deleteModal.show();
    }

    if (!props.show && deleteModal) {
        deleteModal.hide();
    }
})
</script>

<template>
    <div id="deleteModal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-999999 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <form @submit.prevent="handleDelete(props?.id)">
                    <input type="hidden" name="id" :value="props?.id" />
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between p-4 md:p-5 border-b border-gray dark:border-gray rounded-t ">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $t('action.delete') }}
                        </h3>
                        <button id="deleteCloseButtonX" type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <ErrorMessage :error="errorMessage" />

                    <LoadingEffect :loading="props?.loading" />

                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Delete the entity?
                                </label>
                            </div>
                            
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex p-6 space-x-2 border-t border-gray-200 rounded-b border-gray justify-between">
                        <button type="button" id="deleteCloseButton"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">{{
                                $t('action.cancel') }}</button>

                        <button type="submit" :disabled="props?.loading"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{
                                $t('action.delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
