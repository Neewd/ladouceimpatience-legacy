<template>
    <div>
        <div class="flex justify-between items-center mb-6">
            <heading class>Campagne de newsletter</heading>
            <div class="flex-no-shrink ml-auto">
                <router-link
                    :to="{ name: 'campaign'}"
                    class="btn btn-default btn-primary"
                >Créer une nouvelle campagne</router-link>
            </div>
        </div>

        <card class="bg-white flex flex-col p-4 mb-6">
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
                            <span>Nom de la campagne</span>
                        </th>
                        <th class="text-center">
                            <span>Sender</span>
                        </th>
                        <th class="text-center">
                            <span>Date d'envoi</span>
                        </th>
                        <!-- Actions, View, Edit, Delete -->
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(campaign) in campaigns" :key="campaign" class="layout-line">
                        <td class="w-8">&nbsp;</td>
                        <td class="text-center" @click="searchInfo(campaign)">{{ campaign.id }}</td>
                        <td class="text-center" @click="searchInfo(campaign)">{{ campaign.name }}</td>
                        <td
                            class="text-center"
                            @click="searchInfo(campaign)"
                        >{{ campaign.sender.email }}</td>
                        <td class="text-center">
                            <span v-if="campaign.scheduledAt < Date.now()">
                                <button
                                    class="appearance-none cursor-pointer text-70"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        width="24"
                                        height="24"
                                        class="fill-current"
                                    >
                                        <path
                                            class="heroicon-ui"
                                            d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-8.41l2.54 2.53a1 1 0 0 1-1.42 1.42L11.3 12.7A1 1 0 0 1 11 12V8a1 1 0 0 1 2 0v3.59z"
                                        />
                                    </svg>
                                </button>
                            </span>
                            <span
                                v-if="campaign.scheduledAt !== ''"
                                :class="{'text-success' : campaignIsBeforeNow(campaign)}"
                            >{{ campaign.scheduledAt | moment("D-M-YYYY") }}</span>
                        </td>
                        <td class="flex">
                            <button
                                title="send"
                                class="appearance-none cursor-pointer text-70 hover:text-primary mr-3 flex"
                                @click.prevent="sendCampaign(campaign)"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    width="24"
                                    height="24"
                                    class="fill-current"
                                >
                                    <path
                                        class="heroicon-ui"
                                        d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2zm16 3.38V6H4v1.38l8 4 8-4zm0 2.24l-7.55 3.77a1 1 0 0 1-.9 0L4 9.62V18h16V9.62z"
                                    />
                                </svg>
                            </button>
                            <button
                                title="delete"
                                class="appearance-none cursor-pointer text-70 hover:text-primary flex"
                                v-if="campaign.scheduledAt === ''"
                                @click.prevent="deleteCampaign(campaign)"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    width="24"
                                    height="24"
                                    class="fill-current"
                                >
                                    <path
                                        class="heroicon-ui"
                                        d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"
                                    />
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </card>

        <div v-if="contacts.length > 0">
            <div class="flex justify-between items-center mb-6">
                <heading class>Liste des personnes recevant le mail</heading>
            </div>

            <card class="bg-white flex flex-col p-4 mb-6">
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
                                <span>Email</span>
                            </th>
                            <th class="text-center">
                                <span>Blacklisté</span>
                            </th>
                            <!-- Actions, View, Edit, Delete -->
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(contact) in contacts" :key="contact" class="layout-line">
                            <td class="w-8">&nbsp;</td>
                            <td class="text-center">{{ contact.id }}</td>
                            <td class="text-center">{{ contact.email }}</td>
                            <td class="text-center">
                                <div
                                    class="text-center text-center"
                                    v-if="!contact.emailBlacklisted"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        aria-labelledby="x-circle"
                                        role="presentation"
                                        class="fill-current text-danger"
                                    >
                                        <path
                                            d="M4.93 19.07A10 10 0 1 1 19.07 4.93 10 10 0 0 1 4.93 19.07zm1.41-1.41A8 8 0 1 0 17.66 6.34 8 8 0 0 0 6.34 17.66zM13.41 12l1.42 1.41a1 1 0 1 1-1.42 1.42L12 13.4l-1.41 1.42a1 1 0 1 1-1.42-1.42L10.6 12l-1.42-1.41a1 1 0 1 1 1.42-1.42L12 10.6l1.41-1.42a1 1 0 1 1 1.42 1.42L13.4 12z"
                                        />
                                    </svg>
                                </div>
                                <div class="text-center text-center" v-else>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        aria-labelledby="check-circle"
                                        role="presentation"
                                        class="fill-current text-success"
                                    >
                                        <path
                                            d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-2.3-8.7l1.3 1.29 3.3-3.3a1 1 0 0 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-2-2a1 1 0 0 1 1.4-1.42z"
                                        />
                                    </svg>
                                </div>
                            </td>
                            <td class="buttons-list"></td>
                        </tr>
                    </tbody>
                </table>
            </card>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            campaigns: [],
            contacts: []
        };
    },
    mounted() {
        Nova.request()
            .get("/nova-vendor/newsletter/campaigns")
            .then(({ data }) => {
                this.campaigns = data;
            })
            .catch(error => {
                if (error.response.data) {
                    this.errors = error.response.data.errors;
                }
            });
    },
    methods: {
        searchInfo(campaign) {
            this.contacts = [];
            for (let i = 0; i < campaign.recipients.lists.length; i++) {
                const element = campaign.recipients.lists[i];
                Nova.request()
                    .get(`/nova-vendor/newsletter/list/${element}`)
                    .then(({ data }) => {
                        this.contacts.push(...data);
                    })
                    .catch(error => {
                        if (error.response.data) {
                            this.errors = error.response.data.errors;
                        }
                    });
            }
        },
        sendCampaign(campaign) {
            Nova.request()
                .post(`/nova-vendor/newsletter/campaigns/send`, {
                    campaignId: campaign.id
                })
                .then(({ data }) => {
                    console.log(data);
                })
                .catch(error => {
                    if (error.response.data) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
        deleteCampaign(campaignToDelete) {
            Nova.request()
                .delete(
                    `/nova-vendor/newsletter/campaigns/${campaignToDelete.id}`
                )
                .then(({ data }) => {
                    this.$toasted.show("La campagne à bien été supprimée.", {
                        type: "success"
                    });
                    this.campaigns = this.campaigns.filter(
                        campaign => campaign.id !== campaignToDelete.id
                    );
                })
                .catch(error => {
                    if (error.response.data) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
        campaignIsBeforeNow(campaign) {
            const date = new Date(campaign.scheduledAt);
            return moment(date).isBefore(moment());
        }
    }
};
</script>