/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import VueAxios from 'vue-axios';

// axios.defaults.withCredentials = true
axios.defaults.baseURL = 'http://localhost:8000/api/';

import LoginComponent from './components/LoginComponent.vue';
import DashboardComponent from './components/DashboardComponent.vue';
import TableComponent from './components/utils/TableComponent.vue';
import PaginationComponent from './components/utils/PaginationComponent.vue';
import TopStreamComponent from './components/stats/TopStreamComponent.vue';
import TopStreamsByViewerCountComponent from './components/stats/TopStreamsByViewerCountComponent.vue';
import StreamsByStartTimeComponent from './components/stats/StreamsByStartTimeComponent.vue';
import UserFollowingTopStreamsComponent from './components/stats/UserFollowingTopStreamsComponent.vue';
import UserSharingTagsWithTopStreamsComponent from './components/stats/UserSharingTagsWithTopStreamsComponent.vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

app.use(VueAxios);

app.component('login-component', LoginComponent);
app.component('dashboard-component', DashboardComponent);
app.component('table-component', TableComponent);
app.component('pagination-component', PaginationComponent);
app.component('top-stream-component', TopStreamComponent);
app.component('top-streams-by-viewer-count-component', TopStreamsByViewerCountComponent);
app.component('streams-by-start-time-component', StreamsByStartTimeComponent);
app.component('user-following-top-streams-component', UserFollowingTopStreamsComponent);
app.component('user-sharing-tags-with-top-streams-component', UserSharingTagsWithTopStreamsComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.globEager('./**/*.vue')).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
