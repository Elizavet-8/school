/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

import VueDragDrop from "vue-drag-drop";

Vue.use(VueDragDrop);

import VFileInput from 'v-file-input'

Vue.use(VFileInput)

// Пагинация
Vue.component("pagination", require("laravel-vue-pagination"));

import VueI18n from "vue-i18n"; //needed for calendar locale

Vue.use(VueI18n);

window.i18n = new VueI18n({
    locale: "ru",
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component(
    "percent-counter",
    require("./components/PercentCounter").default
);

Vue.component("line-progress", require("./components/LineProgress").default);

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);
Vue.component(
    "example-component-2",
    require("./components/ExampleComponent.vue").default
);

Vue.component("course", require("./components/Course.vue").default);
Vue.component("course-list", require("./components/CourseList.vue").default);

Vue.component(
    "user-personal-info-tab",
    require("./components/UserPersonalInfoTab.vue").default
);
Vue.component(
    "user-authorization-data-tab",
    require("./components/UserAuthorizationDataTab.vue").default
);
Vue.component("user-profile", require("./components/UserProfile.vue").default);

// Тест админ
Vue.component(
    "test-admin-component",
    require("./components/TestAdminComponent.vue").default
);

// Тестовый тест
Vue.component(
    "test-component",
    require("./components/TestComponent.vue").default
);

// Тесты продакшн
Vue.component("test", require("./components/TestWithQuestions.vue").default);

Vue.component("users", require("./components/Users.vue").default);

Vue.component(
    "build-programs",
    require("./components/BuildPrograms.vue").default
);
Vue.component("register", require("./components/Register.vue").default);
Vue.component(
    "call-form",
    require("./components/landing/CallForm.vue").default
);
// Комментарии
Vue.component('file-add', require('./components/FileAdd.vue').default);
Vue.component('practical-feedback', require('./components/PracticalFeedback.vue').default);
Vue.component('practical-correct', require('./components/PracticalCorrect.vue').default);
Vue.component('practical-status', require('./components/PracticalStatus.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 Vue.component(
    "calendar-component",
    require("./components/Calendar.vue").default
);

import SimpleVueValidation from "simple-vue-validator";
Vue.use(SimpleVueValidation);

import VueKonva from "vue-konva";
Vue.use(VueKonva);

import store from "../js/store";

const app = new Vue({
    store,
    el: "#app",
    i18n
});

$("#button_hide_profile_info").click(function() {
    $(this)
        .children("div")
        .toggleClass("profile_visibity");
});

$('button[id*="button_hide_course_info_"]').each(function(index) {
    $(this).on("click", function() {
        $(this)
            .children("div")
            .toggleClass("profile_visibity");
    });
});

$(document).ready(function() {
    $('div[id^="shadow-"]').each(function(index) {
        $(this).on("click", function() {
            let id = $(this).attr("id");
            id = id.replace("shadow", "video");
            //as noted in addendum, check for querystring exitence
            var symbol = $(`#${id}`)[0].src.indexOf("?") > -1 ? "&" : "?";
            //modify source to autoplay and start video
            $(`#${id}`)[0].src += symbol + "autoplay=1";
            $(`#${$(this).attr("id")}`).css("display", "none");
        });
    });
});

window.selectAllCourses = function() {
    const checkboxes = document.querySelectorAll(".courses-checkbox");

    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
};

window.deselectAllCourses = function() {
    const checkboxes = document.querySelectorAll(".courses-checkbox");

    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
};


function inNewWindow(block) {
    block.on('click', 'a:not([href^="#"])', function(evt) {
        evt.preventDefault();
        window.open(evt.target.href, '_blank');
    })
}

