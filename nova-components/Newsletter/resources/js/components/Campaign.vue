<template>
    <div>
        <div class="flex justify-between items-center mb-6">
            <heading class>Campaign</heading>
        </div>

        <card class="bg-white flex flex-col p-6 mb-6" style="min-height: 300px">
            <div class="flex flex-col">
                <div class="flex border-b border-40">
                    <div class="w-1/5 px-8 py-6">
                        <label for="name" class="inline-block text-80 pt-2 leading-tight">
                            Name
                            <span class="text-danger text-sm">*</span>
                        </label>
                    </div>
                    <div class="py-6 px-8 w-1/2">
                        <input
                            id="name"
                            type="text"
                            v-model="campaign.name"
                            placeholder="Name"
                            class="w-full form-control form-input form-input-bordered"
                        />
                        <div
                            v-if="errors.name"
                            class="help-text help-text mt-2 text-danger"
                        >{{ errors.name[0] }}</div>
                    </div>
                </div>
                <div class="flex border-b border-40">
                    <div class="w-1/5 px-8 py-6">
                        <label for="name" class="inline-block text-80 pt-2 leading-tight">
                            Template
                            <span class="text-danger text-sm">*</span>
                        </label>
                    </div>
                    <div class="py-6 px-8 w-1/2">
                        <select
                            ref="select2_filter"
                            placeholder="Choose a template"
                            class="block w-full form-control-sm form-select"
                            v-model="campaign.template"
                        >
                            <option
                                :value="template.html"
                                v-for="(template) in templates"
                                :key="template"
                            >{{template.name}}</option>
                        </select>
                        <div
                            v-if="errors.template"
                            class="help-text help-text mt-2 text-danger"
                        >{{ errors.template[0] }}</div>
                    </div>
                </div>
                <div class="flex border-b border-40">
                    <div class="w-1/5 px-8 py-6">
                        <label for="name" class="inline-block text-80 pt-2 leading-tight">
                            Header
                            <span class="text-danger text-sm">*</span>
                        </label>
                    </div>
                    <div class="py-6 px-8 w-1/2">
                        <select
                            class="block w-full form-control-sm form-select"
                            v-model="campaign.header"
                            :placeholder="layouts.length > 0 ? 'Veuillez sélectionner un layout' : 'Aucun layout créé pour le moment'"
                        >
                            <option :value="null" disabled>Select Age</option>
                            <option
                                :value="layout.html"
                                v-for="(layout) in layouts"
                                :key="layout"
                            >{{layout.name}}</option>
                        </select>
                        <div
                            v-if="errors.template"
                            class="help-text help-text mt-2 text-danger"
                        >{{ errors.template[0] }}</div>
                    </div>
                </div>
                <div class="flex border-b border-40">
                    <div class="w-1/5 px-8 py-6">
                        <label for="name" class="inline-block text-80 pt-2 leading-tight">
                            Footer
                            <span class="text-danger text-sm">*</span>
                        </label>
                    </div>
                    <div class="py-6 px-8 w-1/2">
                        <select
                            placeholder="Choose a template"
                            class="block w-full form-control-sm form-select"
                            v-model="campaign.footer"
                        >
                            <option
                                :value="layout.html"
                                v-for="(layout) in layouts"
                                :key="layout"
                            >{{layout.name}}</option>
                        </select>
                        <div
                            v-if="errors.template"
                            class="help-text help-text mt-2 text-danger"
                        >{{ errors.template[0] }}</div>
                    </div>
                </div>

                <div class="flex border-b border-40 mb-6">
                    <div class="w-1/5 px-8 py-6">
                        <label for="name" class="inline-block text-80 pt-2 leading-tight">
                            Sender
                            <span class="text-danger text-sm">*</span>
                        </label>
                    </div>
                    <div class="py-6 px-8 w-1/2">
                        <input
                            id="sender"
                            type="text"
                            v-model="campaign.sender"
                            placeholder="Email"
                            class="w-full form-control form-input form-input-bordered"
                        />
                        <div
                            v-if="errors.sender"
                            class="help-text help-text mt-2 text-danger"
                        >{{ errors.sender[0] }}</div>
                    </div>
                </div>
                <div class="flex border-b border-40 mb-6">
                    <div class="w-1/5 px-8 py-6">
                        <label for="name" class="inline-block text-80 pt-2 leading-tight">
                            Description
                            <span class="text-danger text-sm">*</span>
                        </label>
                    </div>
                    <div class="py-6 px-8 w-1/2">
                        <input
                            id="description"
                            type="text"
                            v-model="campaign.subject"
                            placeholder="Description"
                            class="w-full form-control form-input form-input-bordered"
                        />
                        <div
                            v-if="errors.subject"
                            class="help-text help-text mt-2 text-danger"
                        >{{ errors.subject[0] }}</div>
                    </div>
                </div>
            </div>

            <div class="flex w-full flex-row-reverse">
                <button
                    class="btn btn-default btn-primary"
                    @click="createCampaign()"
                >Créer la campagne</button>
            </div>
        </card>
    </div>
</template>

<script>
export default {
    mounted() {
        Nova.request()
            .get("/nova-vendor/newsletter/templates")
            .then(({ data }) => {
                this.templates = data.templates;
            })
            .catch(error => {
                if (error.response.data) {
                    this.errors = error.response.data.errors;
                }
            });

        Nova.request()
            .get("/nova-vendor/newsletter/layouts")
            .then(({ data }) => {
                const regexBlade = /([a-zA-Z0-9]+\/){1,2}(([a-zA-Z0-9-_]+)\.blade\.php)/;
                let layoutNames = [];
                for (let i = 0; i < data.layouts.length; i++) {
                    let layout = {
                        name: data.layouts[i].name,
                        html: data.layouts[i].html
                    };
                    layoutNames.push(layout);
                }
                this.layouts = layoutNames;
            })
            .catch(error => global.console.error(error));
    },
    data() {
        return {
            templates: [],
            layouts: [],
            campaign: {
                name: "",
                template: null,
                header: null,
                footer: null,
                sender: "",
                subject: ""
            },
            errors: {}
        };
    },
    methods: {
        createCampaign() {
            Nova.request()
                .post("/nova-vendor/newsletter/campaigns", this.campaign)
                .then(({ data }) => {
                    this.$toasted.show("La campagne à bien été crééé.", {
                        type: "success"
                    });
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