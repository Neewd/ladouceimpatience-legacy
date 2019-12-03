<template>
    <div>
        <div class="flex justify-between items-center mb-6">
            <heading class>Layouts</heading>
        </div>

        <card class="bg-white flex flex-col p-6 mb-6" style="min-height: 300px">
            <div class="flex flex-col">
                <div class="w-1/5 mb-2">
                    <label for="name" class="inline-block text-80 pt-2 leading-tight">
                        Nom du layout :
                        <span class="text-danger text-sm">*</span>
                    </label>
                </div>
                <div class="w-1/2">
                    <input
                        id="name"
                        type="text"
                        placeholder="Name"
                        class="w-full form-control form-input form-input-bordered"
                        v-model="name"
                    />
                    <div
                        v-if="errors.name"
                        class="help-text help-text mt-2 text-danger"
                    >{{ errors.name[0] }}</div>
                </div>
                <div class="w-1/5 mb-2">
                    <label for="name" class="inline-block text-80 pt-2 leading-tight">
                        Contenu :
                        <span class="text-danger text-sm">*</span>
                    </label>
                </div>
                <div class="mb-4">
                    <vue-editor
                        useCustomImageHandler
                        @image-added="handleImageAdded"
                        @image-removed="handeImageRemoved"
                        v-model="content"
                        :editorOptions="editorSettings"
                    ></vue-editor>
                    <div
                        v-if="errors.content"
                        class="help-text help-text mt-2 text-danger"
                    >{{ errors.content[0] }}</div>
                </div>
            </div>

            <div class="flex w-full flex-row-reverse">
                <button
                    class="btn btn-default btn-primary"
                    @click="saveLayout()"
                >Sauvegarder le layout</button>
            </div>
        </card>
    </div>
</template>

<script>
// Vue Editor
import { VueEditor, Quill } from "vue2-editor";
import ImageResize from "quill-image-resize-vue";
Quill.register("modules/imageResize", ImageResize);

export default {
    components: {
        VueEditor
    },
    props: ["name"],
    mounted() {
        if (this.name !== undefined && this.name !== '') {
            Nova.request()
                .get("/nova-vendor/templates/layouts/" + this.name)
                .then(({ data }) => {
                    this.content = data.layout.html
                })
                .catch(error => {
                    if (error.response.data) {
                        this.errors = error.response.data.errors;
                    }
                });
        }
    },
    data() {
        return {
            content: "",
            name: undefined,
            imagePaths: [],
            editorSettings: {
                modules: {
                    imageResize: {
                        displayStyles: {
                            backgroundColor: "black",
                            border: "none",
                            color: "white"
                        },
                        modules: [
                            "Resize",
                            "DisplaySize",
                            "Toolbar",
                            "Clipboard"
                        ]
                    }
                }
            },
            errors: {},
            layoutSaved: false
        };
    },
    methods: {
        saveLayout() {
            Nova.request()
                .post("/nova-vendor/templates/layouts", {
                    name: this.name,
                    content: this.content
                })
                .then(({ data }) => {
                    this.$toasted.show("Le layout à bien été sauvegardé.", {
                        type: "success"
                    });
                    this.layoutSaved = true;
                })
                .catch(error => {
                    if (error.response.data) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
        handleImageAdded(file, Editor, cursorLocation, resetUploader) {
            let formData = new FormData();
            formData.append("image", file);

            Nova.request()
                .post("/nova-vendor/templates/layouts/image", formData)
                .then(({ data }) => {
                    let url = data;
                    this.imagePaths.push(url);
                    this.$swal
                        .fire({
                            title: "Voulez vous y attacher un lien ?",
                            input: "text",
                            showCancelButton: true,
                            confirmButtonText: "Oui je veux !",
                            cancelButtonText: "Non merci c'est bon"
                        })
                        .then(response => {
                            if (response.dismiss) {
                                Editor.insertEmbed(
                                    cursorLocation,
                                    "image",
                                    url
                                );
                            }
                            if (response.value) {
                                let urlBehindTheImage = `<a href="${response.value}"><img src="${url}"></a>`;
                                let delta = Editor.clipboard.convert(
                                    urlBehindTheImage
                                );
                                Editor.setContents(delta, "silent");
                            }
                            resetUploader();
                        });
                })
                .catch(err => {
                    console.log(err);
                });
        },
        handeImageRemoved(file, Editor, cursorLocation) {
            Nova.request()
                .put("/nova-vendor/templates/layouts/delete-image", {
                    path: file
                })
                .then(({ data }) => {});
        },
        abendCreation() {
            if (this.imagePaths.length > 0) {
                Nova.request()
                    .put("/nova-vendor/templates/layouts/delete-images", {
                        paths: this.imagePaths
                    })
                    .then(({ data }) => {});
            }
        }
    },
    beforeRouteLeave(to, from, next) {
        if (!this.layoutSaved) {
            this.$swal
                .fire({
                    title: "Êtes vous vraiment sûr de vouloir quitter ?",
                    text: "Toutes les modifications seront perdues",
                    showCancelButton: true,
                    confirmButtonText: "Oui je suis sûr",
                    cancelButtonText: "Non je rigolais",
                    allowOutsideClick: () => !this.$swal.isLoading()
                })
                .then(result => {
                    if (result.value) {
                        this.abendCreation();
                        next();
                    }
                    if (result.dismiss) {
                        next(false);
                    }
                });
        } else {
            next();
        }
    }
};
</script>

<style>
/* Scoped Styles */
</style>
