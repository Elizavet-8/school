<template>
    <div class="row col-lg-9 col-12 setting__fix">
        <form
            style="display: flex; flex-direction: column; justify-content: space-around"
            class="setting__block col-lg-8 setting__fix"
            v-on:submit.prevent="onSubmit"
        >
            <div class="row">
                <div style="margin-bottom: 0" class="form-group col-lg-8">
                    <label>ФИО</label>
                    <input
                        type="text"
                        class="form-control"
                        :class="{ 'is-invalid': nameError }"
                        v-model="editedUser.name"
                    />
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ nameError }}</strong>
                    </span>
                </div>
                <div class="form-group col-lg-4">
                    <label>Дата рождения</label>
                    <input
                        pattern="(^(((0[1-9]|1[0-9]|2[0-8])[\/](0[1-9]|1[012]))|((29|30|31)[\/](0[13578]|1[02]))|((29|30)[\/](0[4,6,9]|11)))[\/](19|[2-9][0-9])\d\d$)|(^29[\/]02[\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)"
                        style="background-image: none; padding-right: 12px"
                        type="date"
                        class="form-control"
                        v-model="editedUser.birth"
                        :class="{ 'is-invalid': dateError }"
                    />
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ dateError }}</strong>
                    </span>
                </div>
            </div>
            <div class="row">
                <div style="margin-bottom: 0" class="form-radio radio col-md-6">
                    <p>Пол</p>
                    <div style="margin-top: 28px">
                        <input
                            id="radio-1"
                            type="radio"
                            value="мужской"
                            name="radio"
                            v-model="editedUser.sex"
                        />
                        <label for="radio-1">Мужской</label>
                        <input
                            id="radio-2"
                            type="radio"
                            value="женский"
                            name="radio"
                            v-model="editedUser.sex"
                        />
                        <label for="radio-2">Женский</label>
                    </div>
                </div>
                <div style="margin-bottom: 0" class="form-group col-md-6">
                    <label>Город</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="editedUser.city"
                        :class="{ 'is-invalid': cityError }"
                    />
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ cityError }}</strong>
                    </span>
                </div>
            </div>
            <!-- <div class="row">
                <div style="margin-bottom: 0" class="form-group  col-md-12">
                    <label>Место учебы, класс</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="editedUser.place_of_work"
                        :class="{ 'is-invalid': placeOfWorkError }"
                    />
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ placeOfWorkError }}</strong>
                    </span>
                </div>
            </div> -->
        </form>

        <div style="padding-right: 0" class="setting__block col-lg-3">
            <div class="setting__img">
                <p>Фотография</p>
                <div class="setting__elem">
                    <img
                        :src="img_url ? img_url : 'images/default-avatar.jpg'"
                        alt="person"
                        class="user__image"
                    />
                    <div>
                        <input
                            @change="uploadFile"
                            id="fileUpload"
                            type="file"
                            style="display:none"
                        />
                        <button
                            @click="chooseFiles()"
                            class="download"
                            :disabled="file_loading"
                        >
                            <span
                                v-if="file_loading"
                                class="spinner-grow spinner-grow-sm"
                                role="status"
                                aria-hidden="true"
                            ></span>
                            {{ btnFileLoading }}
                        </button>
                        <button
                            @click="deleteImage()"
                            class="remove"
                            :disabled="file_deleting"
                        >
                            <span
                                v-if="file_deleting"
                                class="spinner-grow spinner-grow-sm"
                                role="status"
                                aria-hidden="true"
                            ></span>
                            {{ btnFileDeleting }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="setting__block col-xl-12">
            <div class="block__form-btn">
                <button
                    v-on:click="onSubmit"
                    class="form-btn"
                    type="button"
                    :disabled="loading"
                >
                    <span
                        v-if="loading"
                        class="spinner-grow spinner-grow-sm"
                        role="status"
                        aria-hidden="true"
                    ></span>
                    {{ btnText }}
                </button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    created() {
        this.editedUser = this.user;
        this.img_url = this.user.img_url;
    },
    props: ["user"],
    data() {
        return {
            loading: false,
            editedUser: null,
            btnText: "Сохранить",
            //errors
            nameError: null,
            dateError: null,
            cityError: null,
            //placeOfWorkError: null,
            // file
            image: "",
            img_url: "",
            file_loading: false,
            btnFileLoading: "Загрузить фото",
            file_deleting: false,
            btnFileDeleting: "Удалить фото"
        };
    },
    methods: {
        uploadFile() {
            this.file_loading = true;
            this.btnFileLoading = "Загрузка...";
            let selectedFile = event.target.files[0];
            this.image = selectedFile;
            let formData = new FormData();
            formData.append("image", this.image, this.image.name);
            axios
                .post("/user/image/upload/" + this.user.id, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(response => {
                    this.img_url = response.data.img_url;
                    this.file_loading = false;
                    this.btnFileLoading = "Загрузить фото";
                })
                .catch(error => {
                    const errors = error.response.data.errors;
                    this.file_loading = false;
                    this.btnFileLoading = "Загрузить фото";
                });
        },
        deleteImage() {
            this.file_deleting = true;
            this.btnFileDeleting = "Загрузка...";
            axios
                .post("/user/image/delete/" + this.user.id)
                .then(response => {
                    this.img_url = response.data.img_url;
                    this.file_deleting = false;
                    this.btnFileDeleting = "Удалить фото";
                })
                .catch(error => {
                    const errors = error.response.data.errors;
                    this.file_deleting = false;
                    this.btnFileDeleting = "Удалить фото";
                });
        },
        chooseFiles() {
            document.getElementById("fileUpload").click();
        },
        onSubmit: function() {
            this.loading = true;
            this.btnText = "Загрузка...";
            axios
                .patch("/user/profile/" + this.user.id, this.editedUser)
                .then(() => {
                    this.nameError = null;
                    this.dateError = null;
                    this.cityError = null;
                    //this.placeOfWorkError = null;
                    this.loading = false;
                    this.btnText = "Сохранить";
                })
                .catch(error => {
                    const errors = error.response.data.errors;

                    this.nameError = null;
                    this.dateError = null;
                    this.cityError = null;
                    //this.placeOfWorkError = null;

                    if (errors.hasOwnProperty("name")) {
                        this.nameError = errors.name[0];
                    }

                    if (errors.hasOwnProperty("birth")) {
                        this.dateError = errors.birth[0];
                    }

                    if (errors.hasOwnProperty("city")) {
                        this.cityError = errors.city[0];
                    }

                    /*if (errors.hasOwnProperty("place_of_work")) {
                        this.placeOfWorkError = errors.place_of_work[0];
                    }*/

                    this.loading = false;
                    this.btnText = "Сохранить";
                });
        }
    }
};
</script>
