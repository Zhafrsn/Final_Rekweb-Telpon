<script setup>
import { ref, reactive } from "vue";
import Modal from "../../Components/Modal.vue";
import { router } from "@inertiajs/vue3";

const { data } = defineProps(["data"]);
const modalType = ref("");
const modalVisible = ref(false);
const telponEdit = ref(null);

const initialValue = {
    name: "",
    region: "",
    telpon: "",
    description: "active",
};

let formData = reactive({
    name: "",
    region: "",
    telpon: "",
    description: "active",
});

const openEditModal = (item) => {
    telponEdit.value = item.id;
    formData.name = item.name;
    formData.region = item.region;
    formData.telpon = item.telpon;
    formData.description = item.description;

    openModal("edit");
};

const openModal = (type) => {
    modalType.value = type;
    modalVisible.value = true;
};

const closeModal = () => {
    formData = { ...initialValue };
    modalType.value = "";
    modalVisible.value = false;
};

const createTelpon = () => {
    router.post("/telpon", formData);
    closeModal();
};

const updateTelpon = (id) => {
    formData.id = id;

    console.log(`Update item with id ${id}`);
    console.log("ID dari formData: ", formData.id);

    openModal("edit");
    router.put(`/telpon/${formData.id}`, formData);
    closeModal();
};

const deleteTelpon = (id) => {
    if (confirm("Are you sure you want to delete this telpon?")) {
        console.log(`Delete item with id ${id}`);
        router.delete(`/telpon/${id}`);
    }
};
</script>

<template>
    <div class="mx-10 mt-10">
        <h1 class="text-6xl font-extrabold font-serif mb-8">Telephone Book</h1>

        <div class="pb-4">
            <button
                class="bg-blue-500 hover:bg-blue-700 mb-4 text-white font-bold py-2 px-4 rounded"
                @click="openModal('create')"
            >
                Create New Contact
            </button>
        </div>

        <table class="min-w-full bg-white border border-gray-300">
            <thead class="bg-blue-300">
                <tr>
                    <th class="py-2 px-4 text-white border-b">Contact Name</th>
                    <th class="py-2 px-4 text-white border-b">Region</th>
                    <th class="py-2 px-4 text-white border-b">Telpon</th>
                    <th class="py-2 px-4 text-white border-b">Description</th>
                    <th class="py-2 px-4 text-white border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in data" :key="item.id" class="bg-gray-100">
                    <td class="py-2 px-4 border-b max-w-[150px] text-center">
                        {{ item.name }}
                    </td>
                    <td class="py-2 px-4 border-b max-w-[200px] break-words text-center">
                        {{ item.region }}
                    </td>
                    <td class="py-2 px-4 border-b text-center">
                        {{ item.telpon }}
                    </td>
                    <td class="py-2 px-4 border-b text-center">
                        {{ item.description === 'active' ? 'Active' : 'Inactive' }}
                    </td>
                    <td class="py-4 px-4 border-b">
                        <div
                            class="flex flex-wrap gap-5 items-center justify-center "
                        >
                            <button @click="openEditModal(item)">
                                <img
                                    width="30"
                                    height="30"
                                    src="https://cdn.icon-icons.com/icons2/3376/PNG/512/circle_edit_icon_212071.png"
                                    alt="create-new--v1"
                                />
                            </button >
                            <button @click="deleteTelpon(item.id)">
                                <img
                                    width="32"
                                    height="32"
                                    src="https://png.pngtree.com/png-vector/20220813/ourmid/pngtree-rounded-flat-vector-icon-of-a-red-trash-can-vector-png-image_19495792.png"
                                    alt="trash"
                                />
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <Modal :show="modalVisible" @close="closeModal">
            <div v-if="modalType === 'create'">
                <h1 class="text-2xl font-bold font-serif m-4">Create Telpon</h1>
                <form @submit.prevent="createTelpon">
                    <div class="m-5">
                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-700"
                            >Name:</label
                        >
                        <input
                            v-model="formData.name"
                            type="text"
                            id="title"
                            name="title"
                            class="mt-1 p-2 border rounded-md w-full"
                        />
                    </div>

                    <div class="m-5">
                        <label
                            for="region"
                            class="block text-sm font-medium text-gray-700"
                            >Region:</label
                        >
                        <input
                            v-model="formData.region"
                            id="region"
                            name="region"
                            class="mt-1 p-2 border rounded-md w-full"
                        />
                    </div>

                    <div class="m-5">
                        <label
                            for="telpon"
                            class="block text-sm font-medium text-gray-700"
                            >Telpon:</label
                        >
                        <input
                            v-model="formData.telpon"
                            type="text"
                            id="telpon"
                            name="telpon"
                            class="mt-1 p-2 border rounded-md w-full"
                        />
                    </div>

                    <div class="m-5">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                        <select v-model="formData.description" id="description" name="description" class="mt-1 p-2 border rounded-md w-full">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="bg-blue-500 text-white font-bold py-2 px-4 rounded m-5"
                        >
                            Save Telpon
                        </button>
                    </div>
                </form>
            </div>

            <div v-else-if="modalType === 'edit'">
                <h1 class="text-2xl font-bold font-serif m-5">Update Telpon</h1>
                <form @submit.prevent="updateTelpon(telponEdit)">
                    <div class="m-5">
                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-700"
                            >Name:</label
                        >
                        <input
                            v-model="formData.name"
                            type="text"
                            id="name"
                            name="name"
                            class="mt-1 p-2 border rounded-md w-full"
                        />
                    </div>

                    <div class="m-5">
                        <label
                            for="region"
                            class="block text-sm font-medium text-gray-700"
                            >Region:</label
                        >
                        <input
                            v-model="formData.region"
                            id="region"
                            name="region"
                            rows="3"
                            class="mt-1 p-2 border rounded-md w-full"
                        />
                    </div>

                    <div class="m-5">
                        <label
                            for="telpon"
                            class="block text-sm font-medium text-gray-700"
                            >Telpon:</label
                        >
                        <input
                            v-model="formData.telpon"
                            type="text"
                            id="telpon"
                            name="telpon"
                            class="mt-1 p-2 border rounded-md w-full"
                        />
                    </div>

                    <div class="m-5">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                        <select v-model="formData.description" id="description" name="description" class="mt-1 p-2 border rounded-md w-full">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                      <button
                          type="submit"
                          class="bg-blue-500 text-white font-bold py-2 px-4 rounded m-5"
                      >
                          Update Telpon
                      </button>
                  </div>
                </form>
            </div>
        </Modal>
    </div>
</template>
