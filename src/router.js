import Vue from "vue"
import VueRouter from "vue-router"

import Homepage from "./components/Homepage"
import jQuery from 'jquery'
window.jQuery = window.$ = jQuery

Vue.use(VueRouter)

const routes = [{
    path: '/',
    name: '/',
    component: Homepage,

}, ];
export const router = new VueRouter({
    mode: 'history',
    base: "/",


    routes
});