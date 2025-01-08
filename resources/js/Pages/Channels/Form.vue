<script setup>
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";

const props = defineProps({
    channel: {
        type: Object,
        default: () => ({
            name: "",
            stream_url: "",
            logo: "",
            category_id: null,
            stream_type: "live",
            is_active: true,
            epg_channel_id: null,
        }),
    },
    categories: {
        type: Array,
        default: () => [],
    },
    epgChannels: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    name: props.channel.name,
    stream_url: props.channel.stream_url,
    logo: props.channel.logo,
    category_id: props.channel.category_id,
    stream_type: props.channel.stream_type,
    is_active: props.channel.is_active,
    epg_channel_id: props.channel.epg_channel_id,
});

const streamTypes = [
    { value: "live", label: "Live" },
    { value: "movie", label: "Movie" },
    { value: "series", label: "Series" },
];

const submit = () => {
    if (props.channel.id) {
        form.put(route("channels.update", props.channel.id));
    } else {
        form.post(route("channels.store"));
    }
};
</script>

<template>
    <AppLayout>
        <Head :title="channel.id ? 'Edit Channel' : 'Add Channel'" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ channel.id ? 'Edit Channel' : 'Add Channel' }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <Input
                                    v-model="form.name"
                                    type="text"
                                    label="Name"
                                    :error="form.errors.name"
                                />
                            </div>

                            <div>
                                <Input
                                    v-model="form.stream_url"
                                    type="text"
                                    label="Stream URL"
                                    :error="form.errors.stream_url"
                                />
                            </div>

                            <div>
                                <Input
                                    v-model="form.logo"
                                    type="text"
                                    label="Logo URL"
                                    :error="form.errors.logo"
                                />
                            </div>

                            <div>
                                <Select
                                    v-model="form.category_id"
                                    :options="categories"
                                    label="Category"
                                    :error="form.errors.category_id"
                                    valueKey="id"
                                    labelKey="name"
                                />
                            </div>

                            <div>
                                <Select
                                    v-model="form.stream_type"
                                    :options="streamTypes"
                                    label="Stream Type"
                                    :error="form.errors.stream_type"
                                />
                            </div>

                            <div>
                                <Select
                                    v-model="form.epg_channel_id"
                                    :options="epgChannels"
                                    label="EPG Channel"
                                    :error="form.errors.epg_channel_id"
                                    valueKey="id"
                                    labelKey="name"
                                />
                            </div>

                            <div class="flex items-center">
                                <input
                                    type="checkbox"
                                    v-model="form.is_active"
                                    class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded"
                                />
                                <label class="ml-2 block text-sm text-gray-900">
                                    Active
                                </label>
                            </div>

                            <div class="flex items-center justify-end space-x-3">
                                <Button
                                    href="/channels"
                                    variant="secondary"
                                    :disabled="form.processing"
                                >
                                    Cancel
                                </Button>

                                <Button
                                    type="submit"
                                    :disabled="form.processing"
                                >
                                    {{ channel.id ? 'Update' : 'Create' }}
                                </Button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>