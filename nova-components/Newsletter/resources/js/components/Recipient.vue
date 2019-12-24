<template>
    <div>
        <div>
            <div class="flex justify-between items-center mb-6">
                <heading class>Inscrit à la newsletter</heading>
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
                                <span>Email</span>
                            </th>
                            <th class="text-center">
                                <span>Date d'inscription</span>
                            </th>

                            <!-- Actions, View, Edit, Delete -->
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(recipient) in recipients"
                            :key="recipient"
                            class="layout-line"
                        >
                            <td class="w-8">&nbsp;</td>
                            <td class="text-center">{{ recipient.id }}</td>
                            <td class="text-center">{{ recipient.email }}</td>
                            <td class="text-center">{{ recipient.createdAt | moment("from", "now", true) }}</td>
                            <td class="buttons-list">
                                <button
                                    data-testid="users-items-0-delete-button"
                                    title="Delete"
                                    class="appearance-none cursor-pointer text-70 hover:text-primary mr-3"
                                    @click.prevent="removeRecipient(recipient)"
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
            </card>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        this.getRecipientList();
    },
    data() {
        return {
            recipients: [],
            errors: {}
        };
    },
    methods: {
        getRecipientList() {
            const listId = 2;
            Nova.request()
                .get(`/nova-vendor/newsletter/list/${listId}`)
                .then(({ data }) => {
                    console.log(data);
                    this.recipients = data;
                })
                .catch(error => global.console.error(error));
        },
        removeRecipient(recipient) {
            Nova.request()
                .put("/nova-vendor/newsletter/list/removeFromList", { email : recipient.email})
                .then(({ data }) => {
                    console.log(data)
                })
                .catch(error => global.console.error(error));
        }
    }
};
</script>
