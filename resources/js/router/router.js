import { createRouter, createWebHistory } from "vue-router";
import HomePage from "../components/ HomePage.vue"; // Component for home route
import PageEditor from "../components/PageEditor.vue"; // Component to create/edit pages

const routes = [
    { path: "/", component: HomePage, name: "home" },
    { path: "/page/:id/edit", component: PageEditor, name: "page-edit" },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
