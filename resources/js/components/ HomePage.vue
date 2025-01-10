<template>
    <div class="container mt-4">
        <h2 class="mb-4 text-center">Page Tree</h2>

        <div v-if="loading" class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div v-else>
            <ul class="list-group">
                <li
                    v-for="page in pages"
                    :key="page.id"
                    class="list-group-item d-flex justify-content-between align-items-center mb-2 border-0 shadow-sm"
                >
                    <span class="h5 text-muted">{{ page.title }}</span>
                    <div>
                        <button
                            class="btn btn-outline-warning btn-sm me-2"
                            @click="editPage(page.id)"
                        >
                            Edit
                        </button>
                        <button
                            class="btn btn-outline-danger btn-sm"
                            @click="deletePage(page.id)"
                        >
                            Delete
                        </button>
                    </div>

                    <!-- Nested pages (children) -->
                    <ul
                        v-if="page.children && page.children.length > 0"
                        class="list-group mt-3 ms-3"
                    >
                        <li
                            v-for="child in page.children"
                            :key="child.id"
                            class="list-group-item d-flex justify-content-between align-items-center border-0 shadow-sm"
                        >
                            <span class="text-muted">{{ child.title }}</span>
                            <div>
                                <button
                                    class="btn btn-outline-warning btn-sm me-2"
                                    @click="editPage(child.id)"
                                >
                                    Edit
                                </button>
                                <button
                                    class="btn btn-outline-danger btn-sm"
                                    @click="deletePage(child.id)"
                                >
                                    Delete
                                </button>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <button
            class="btn btn-success mt-4 d-block mx-auto"
            @click="createPage"
        >
            Create New Page
        </button>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

export default {
    setup() {
        const pages = ref([]);
        const loading = ref(true);
        const router = useRouter();

        const fetchPages = async () => {
            try {
                const response = await axios.get("/api/pages");
                pages.value = response.data;
            } catch (error) {
                console.error("Error fetching pages:", error);
            } finally {
                loading.value = false;
            }
        };

        const editPage = (id) => {
            router.push({ name: "page-edit", params: { id } });
        };

        const deletePage = async (id) => {
            try {
                await axios.delete(`/api/pages/${id}`);
                fetchPages(); // Re-fetch the pages after deletion
            } catch (error) {
                console.error("Error deleting page:", error);
            }
        };

        const createPage = () => {
            router.push({ name: "page-edit", params: { id: "new" } });
        };

        onMounted(() => {
            fetchPages();
        });

        return { pages, loading, editPage, deletePage, createPage };
    },
};
</script>

<style scoped>
/* Minimalistic custom styles for page tree */
.list-group-item {
    background-color: #f8f9fa;
    border-radius: 5px;
}

.list-group-item:hover {
    background-color: #f1f1f1;
}

h2 {
    color: #343a40;
}

button {
    font-size: 0.9rem;
}

button:hover {
    background-color: #f0f0f0;
}

.spinner-border {
    width: 3rem;
    height: 3rem;
}

.text-muted {
    color: #6c757d !important;
}

.mt-4 {
    margin-top: 2rem !important;
}
</style>
