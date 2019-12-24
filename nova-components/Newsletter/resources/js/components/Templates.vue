<template>
    <div>
        <div>
            <div class="flex justify-between items-center mb-6">
                <heading class>Templates</heading>
                <div class="flex-no-shrink ml-auto">
                    <button
                        class="btn btn-default btn-primary"
                        @click="createNewTemplate()"
                    >Créer un nouveau template</button>
                </div>
            </div>

            <card class="bg-white flex flex-col mb-6">
                <table
                    class="table w-full flex-none"
                    cellpadding="0"
                    cellspacing="0"
                    data-testid="resource-table"
                >
                    <thead>
                        <tr>
                            <!-- Select Checkbox -->
                            <th class="w-8">&nbsp;</th>

                            <!-- Field Names -->
                            <th class="text-center">
                                <span>Id</span>
                            </th>
                            <th class="text-center">
                                <span>Name</span>
                            </th>

                            <!-- Actions, View, Edit, Delete -->
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(template, index) in templates"
                            :key="template"
                            class="layout-line"
                        >
                            <td class="w-8">&nbsp;</td>
                            <td class="text-center" @click="renderTemplate(template)">{{ index }}</td>
                            <td
                                class="text-center"
                                @click="renderTemplate(template)"
                            >{{ template.name }}</td>
                            <td class="buttons-list">
                                <button
                                    data-testid="users-items-0-delete-button"
                                    title="Delete"
                                    class="appearance-none cursor-pointer text-70 hover:text-primary mr-3"
                                    @click.prevent="deleteLayout(layout)"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 20 20"
                                        aria-labelledby="delete"
                                        role="presentation"
                                        class="fill-current"
                                    >
                                        <path
                                            fill-rule="nonzero"
                                            d="M6 4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6H1a1 1 0 1 1 0-2h5zM4 6v12h12V6H4zm8-2V2H8v2h4zM8 8a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1z"
                                        />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div
                    v-if="templates.length == 0"
                    class="flex justify-center items-center px-6 py-8"
                >
                    <div class="text-center">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="65"
                            height="51"
                            viewBox="0 0 65 51"
                            class="mb-3"
                        >
                            <path
                                fill="#A8B9C5"
                                d="M56 40h2c.552285 0 1 .447715 1 1s-.447715 1-1 1h-2v2c0 .552285-.447715 1-1 1s-1-.447715-1-1v-2h-2c-.552285 0-1-.447715-1-1s.447715-1 1-1h2v-2c0-.552285.447715-1 1-1s1 .447715 1 1v2zm-5.364125-8H38v8h7.049375c.350333-3.528515 2.534789-6.517471 5.5865-8zm-5.5865 10H6c-3.313708 0-6-2.686292-6-6V6c0-3.313708 2.686292-6 6-6h44c3.313708 0 6 2.686292 6 6v25.049375C61.053323 31.5511 65 35.814652 65 41c0 5.522847-4.477153 10-10 10-5.185348 0-9.4489-3.946677-9.950625-9zM20 30h16v-8H20v8zm0 2v8h16v-8H20zm34-2v-8H38v8h16zM2 30h16v-8H2v8zm0 2v4c0 2.209139 1.790861 4 4 4h12v-8H2zm18-12h16v-8H20v8zm34 0v-8H38v8h16zM2 20h16v-8H2v8zm52-10V6c0-2.209139-1.790861-4-4-4H6C3.790861 2 2 3.790861 2 6v4h52zm1 39c4.418278 0 8-3.581722 8-8s-3.581722-8-8-8-8 3.581722-8 8 3.581722 8 8 8z"
                            />
                        </svg>
                        <h3
                            class="text-base text-80 font-normal mb-6"
                        >Aucun template n'a été créé pour le moment.</h3>
                    </div>
                </div>
            </card>
        </div>

        <div ref="creationForm">
            <div v-if="creation">
                <heading class="mb-6">Nouveau template</heading>
                <card class="bg-white flex flex-col p-6 mb-6">
                    <div class="w-1/5 mb-2">
                        <label for="name" class="inline-block text-80 pt-2 leading-tight">
                            Nom :
                            <span class="text-danger text-sm">*</span>
                        </label>
                    </div>
                    <div class="w-1/2">
                        <input
                            id="name"
                            type="text"
                            placeholder="Name"
                            v-model="name"
                            class="w-full form-control form-input form-input-bordered"
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
                    <vue-editor
                        useCustomImageHandler
                        @image-added="handleImageAdded"
                        @image-removed="handeImageRemoved"
                        v-model="content"
                        :editorOptions="editorSettings"
                        class="pb-4"
                    ></vue-editor>
                    <div class="flex w-full flex-row-reverse">
                        <button
                            class="btn btn-default btn-primary"
                            @click="saveTemplate()"
                        >Créer le template</button>
                    </div>
                </card>
            </div>
            <div v-else>
                <heading class="mb-6">Template</heading>
                <card class="bg-white flex flex-col p-6 mb-6">
                    <div class="w-1/5 mb-2">
                        <label for="name" class="inline-block text-80 pt-2 leading-tight">
                            Nom :
                            <span class="text-danger text-sm">*</span>
                        </label>
                    </div>
                    <div class="w-1/2">
                        <input
                            id="name"
                            type="text"
                            placeholder="Name"
                            v-model="name"
                            class="w-full form-control form-input form-input-bordered"
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
                    <vue-editor
                        useCustomImageHandler
                        @image-added="handleImageAdded"
                        @image-removed="handeImageRemoved"
                        v-model="content"
                        :editorOptions="editorSettings"
                        class="pb-4"
                    ></vue-editor>
                    <div class="flex w-full flex-row-reverse">
                        <button
                            class="btn btn-default btn-primary"
                            @click="saveTemplate()"
                        >Sauvegarder le template</button>
                    </div>
                </card>
            </div>
        </div>
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
    data() {
        return {
            creation: true,
            templates: [],
            name: "",
            content: "",
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
            errors: {}
        };
    },
    created() {
        this.getTemplates();
    },
    methods: {
        getTemplates() {
            Nova.request()
                .get("/nova-vendor/newsletter/templates")
                .then(({ data }) => {
                    this.templates = data.templates;
                })
                .catch(error => global.console.error(error));
        },
        createNewTemplate() {
            this.creation = true;
            this.name = "";
            this.content = "";
            const element = this.$refs["creationForm"];
            window.scrollTo(0, element.offsetTop);
        },
        renderTemplate(template) {
            console.log(template);
            this.creation = false;
            this.name = template.name;
            this.content = template.html;
        },
        saveTemplate() {
            Nova.request()
                .post("/nova-vendor/newsletter/templates", {
                    name: this.name,
                    content: this.content
                })
                .then(({ data }) => {
                    this.$toasted.show("Le template à bien été sauvegardé.", {
                        type: "success"
                    });
                    this.layoutSaved = true;
                })
                .catch(error => {
                    if (error.response.data) {
                        this.errors = error.response.data.errors;
                    }
                });
        }
    }
};
</script>

<style>
/* Scoped Styles */
</style>
