<template>
  <div>
    <div class="modal fixed z-10 inset-0 overflow-y-auto">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
          <div class="bg-white px-2 pt-2 pb-2">
            <div class="sm:flex sm:items-start">
              <div class="w-full">
                <h3 class="text-lg border-b text-center px-5">
                  <slot name="title"></slot>
                </h3>
                <div class="mt-4">
                  <slot name="body"></slot>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <slot name="footer"></slot>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  computed: {},
  props: {
    title: String,
    urls: Object,
  },

  data() {
    return {
      modalDisplayed: false,
    }
  },
  methods: {
    showModal() {
      this.addBookModalDisplayed = true;
    },
    hideModal() {
      this.addBookModalDisplayed = false;
    },
  },
  mounted() {
    //
  },
};
</script>
