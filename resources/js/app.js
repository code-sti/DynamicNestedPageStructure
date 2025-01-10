import "bootstrap/dist/css/bootstrap.min.css";
import { createApp } from "vue";
import App from "./components/App.vue";
import router from "./router/router";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

const app = createApp(App);
app.use(router, Toast, {
    position: "top-right",
    timeout: 3000,
    closeOnClick: true,
    pauseOnHover: true,
});

app.mount("#app");
