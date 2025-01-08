<script setup>
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";
import MultiSelect from "@/Components/MultiSelect.vue";
import DatePicker from "@/Components/DatePicker.vue";

const props = defineProps({
    playlist: {
        type: Object,
        default: () => ({
            name: "",
            description: "",
            is_active: true,
            expires_at: null,
            max_connections: 1,
            allowed_ips: [],
            notes: "",
            channels: [],
            movies: [],
            series: [],
            bouquets: [],
        }),
    },
    channels: Array,
    movies: Array,
    series: Array,
    bouquets: Array,
});

const form = useForm({
    name: props.playlist.name,
    description: props.playlist.description,
    is_active: props.playlist.is_active,
    expires_at: props.playlist.expires_at,
    max_connections: props.playlist.max_connections,
    allowed_ips: props.playlist.allowed_ips || [],
    notes: props.playlist.notes,
    channels: props.playlist.channels?.map(c => c.id) || [],
    movies: props.playlist.movies?.map(m => m.id) || [],
    series: props.playlist.series?.map(s => s.id) || [],
    bouquets: props.playlist.bouquets?.map(b => b.id) || [],
});

const newIp = ref("");

const addIp = () => {
    if (newIp.value && !form.allowed_ips.includes(newIp.value)) {
        form.allowed_ips.push(newIp.value);
        newIp.value = "";
    }
};

const removeIp = (ip) => {
    const index = form.allowed_ips.indexOf(ip);
    if (index !== -1) {
        form.allowed_ips.splice(index, 1);
    }
};

const submit = () => {
    if (props.playlist.id) {
        form.put(route("playlists.update", props.playlist.id));
    } else {
        form.post(route("playlists.store"));
    }
};
</script>

<template>
    <AppLayout>
        <Head :title="playlist.id ? 'Edit Playlist' : 'Add Playlist'" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ playlist.id ? 'Edit Playlist' : 'Add Playlist' }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Basic Info -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
                                
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
                                        v-model="form.description"
                                        type="textarea"
                                        label="Description"
                                        :error="form.errors.description"
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
                            </div>

                            <!-- Access Control -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Access Control</h3>
                                
                                <div>
                                    <DatePicker
                                        v-model="form.expires_at"
                                        label="Expiry Date"
                                        :error="form.errors.expires_at"
                                    />
                                </div>

                                <div>
                                    <Input
                                        v-model="form.max_connections"
                                        type="number"
                                        label="Max Connections"
                                        min="1"
                                        :error="form.errors.max_connections"
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Allowed IPs
                                    </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input
                                            type="text"
                                            v-model="newIp"
                                            class="focus:ring-primary-500 focus:border-primary-500 flex-1 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300"
                                            placeholder="Enter IP address"
                                            @keyup.enter="addIp"
                                        />
                                        <button
                                            type="button"
                                            class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500"
                                            @click="addIp"
                                        >
                                            Add
                                        </button>
                                    </div>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        <div
                                            v-for="ip in form.allowed_ips"
                                            :key="ip"
                                            class="inline-flex rounded-full items-center py-0.5 pl-2.5 pr-1 text-sm font-medium bg-primary-100 text-primary-700"
                                        >
                                            {{ ip }}
                                            <button
                                                type="button"
                                                class="flex-shrink-0 ml-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-primary-400 hover:bg-primary-200 hover:text-primary-500 focus:outline-none focus:bg-primary-500 focus:text-white"
                                                @click="removeIp(ip)"
                                            >
                                                <span class="sr-only">Remove IP</span>
                                                <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                                                    <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <p v-if="form.errors.allowed_ips" class="mt-2 text-sm text-red-600">
                                        {{ form.errors.allowed_ips }}
                                    </p>
                                </div>
                            </div>

                            <!-- Content Selection -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Content Selection</h3>
                                
                                <div>
                                    <MultiSelect
                                        v-model="form.channels"
                                        :options="channels"
                                        label="Channels"
                                        :error="form.errors.channels"
                                        valueKey="id"
                                        labelKey="name"
                                    />
                                </div>

                                <div>
                                    <MultiSelect
                                        v-model="form.movies"
                                        :options="movies"
                                        label="Movies"
                                        :error="form.errors.movies"
                                        valueKey="id"
                                        labelKey="name"
                                    />
                                </div>

                                <div>
                                    <MultiSelect
                                        v-model="form.series"
                                        :options="series"
                                        label="Series"
                                        :error="form.errors.series"
                                        valueKey="id"
                                        labelKey="name"
                                    />
                                </div>

                                <div>
                                    <MultiSelect
                                        v-model="form.bouquets"
                                        :options="bouquets"
                                        label="Bouquets"
                                        :error="form.errors.bouquets"
                                        valueKey="id"
                                        labelKey="name"
                                    />
                                </div>
                            </div>

                            <!-- Additional Notes -->
                            <div>
                                <Input
                                    v-model="form.notes"
                                    type="textarea"
                                    label="Notes"
                                    :error="form.errors.notes"
                                />
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-end space-x-3">
                                <Button
                                    href="/playlists"
                                    variant="secondary"
                                    :disabled="form.processing"
                                >
                                    Cancel
                                </Button>

                                <Button
                                    type="submit"
                                    :disabled="form.processing"
                                >
                                    {{ playlist.id ? 'Update' : 'Create' }}
                                </Button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>