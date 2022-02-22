require("./bootstrap");

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { dragscrollNext } from "vue-dragscroll";
const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

var app = createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .directive("dragscroll", dragscrollNext)
            .mount(el);
    },
});
InertiaProgress.init({ color: "#172657" });
