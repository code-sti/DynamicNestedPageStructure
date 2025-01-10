<template>
    <div class="container mt-5">
        <h1 class="text-center mb-4">{{ isEdit ? "Edit" : "Create" }} Page</h1>

        <form
            @submit.prevent="handleSubmit"
            class="bg-light p-4 rounded shadow-sm"
        >
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input
                    type="text"
                    id="title"
                    v-model="form.title"
                    class="form-control"
                    :class="{ 'is-invalid': serverErrors.title }"
                    :disabled="loading"
                    required
                />
                <div class="invalid-feedback" v-if="serverErrors.title">
                    {{ serverErrors.title }}
                </div>
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input
                    type="text"
                    id="slug"
                    v-model="form.slug"
                    class="form-control"
                    :class="{ 'is-invalid': serverErrors.slug }"
                    :disabled="loading"
                    required
                />
                <div class="invalid-feedback" v-if="serverErrors.slug">
                    {{ serverErrors.slug }}
                </div>
            </div>

            <div class="mb-3">
                <label for="parent_id" class="form-label">Parent Page</label>
                <select
                    id="parent_id"
                    v-model="form.parent_id"
                    class="form-select"
                    :class="{ 'is-invalid': serverErrors.parent_id }"
                    :disabled="loading"
                >
                    <option value="">No Parent</option>
                    <option
                        v-for="page in pages"
                        :key="page.id"
                        :value="page.id"
                    >
                        {{ page.title }}
                    </option>
                </select>
                <div class="invalid-feedback" v-if="serverErrors.parent_id">
                    {{ serverErrors.parent_id }}
                </div>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea
                    id="content"
                    v-model="form.content"
                    class="form-control"
                    rows="4"
                    :class="{ 'is-invalid': serverErrors.content }"
                    :disabled="loading"
                    required
                ></textarea>
                <div class="invalid-feedback" v-if="serverErrors.content">
                    {{ serverErrors.content }}
                </div>
            </div>

            <div class="text-center">
                <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="loading"
                >
                    {{ isEdit ? "Update Page" : "Create Page" }}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import { useRoute, useRouter } from "vue-router";

export default {
    setup() {
        const form = ref({
            title: "",
            slug: "",
            content: "",
            parent_id: "",
        });
        const serverErrors = ref({});
        const pages = ref([]);
        const loading = ref(false);

        const route = useRoute();
        const router = useRouter();
        const isEdit = computed(
            () => !!route.params.id && route.params.id !== "new"
        );

        const fetchPages = async () => {
            try {
                const response = await axios.get("/api/pages");
                pages.value = response.data;
            } catch (error) {
                console.error("Error fetching pages:", error);
            }
        };

        const fetchPage = async () => {
            const id = route.params.id;
            try {
                const response = await axios.get(`/api/pages/${id}`);
                form.value = response.data;
            } catch (error) {
                console.error("Error fetching page:", error);
            }
        };

        const handleSubmit = async () => {
            serverErrors.value = {}; // Clear previous errors
            loading.value = true;

            const id = route.params.id;

            try {
                if (isEdit.value) {
                    // Update page
                    await axios.put(`/api/pages/${id}`, form.value);
                } else {
                    // Create new page
                    await axios.post("/api/pages", form.value);
                }
                router.push("/");
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    // Map validation errors from the server
                    serverErrors.value = error.response.data.errors;
                } else {
                    console.error("Error saving page:", error);
                }
            } finally {
                loading.value = false;
            }
        };

        onMounted(() => {
            fetchPages();
            if (isEdit.value) {
                fetchPage();
            }
        });

        return {
            form,
            serverErrors,
            pages,
            loading,
            handleSubmit,
            isEdit,
        };
    },
};
</script>

<style scoped>
/* Minimalistic form styling */
form {
    max-width: 600px;
    margin: auto;
    background-color: #f8f9fa;
    border-radius: 8px;
}

button {
    width: 100%;
    padding: 12px;
    font-size: 1rem;
}

input,
select,
textarea {
    font-size: 1rem;
}

h1 {
    font-size: 2rem;
    font-weight: 600;
}
</style>
