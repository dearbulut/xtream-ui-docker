<script setup>
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";

const props = defineProps({
    settings: Object,
});

const form = useForm({
    site_title: props.settings.site_title || 'Xtream Panel',
    site_logo: props.settings.site_logo || '',
    site_favicon: props.settings.site_favicon || '',
    site_theme: props.settings.site_theme || 'light',
    xtream_api_url: props.settings.xtream_api_url || '',
    xtream_username: props.settings.xtream_username || '',
    xtream_password: props.settings.xtream_password || '',
    epg_url: props.settings.epg_url || '',
    epg_update_interval: props.settings.epg_update_interval || 3600,
    api_token: props.settings.api_token || '',
    allowed_ips: props.settings.allowed_ips || '*',
    block_vpn: props.settings.block_vpn || false,
    max_connections: props.settings.max_connections || 1,
});

const themes = [
    { value: 'light', label: 'Light' },
    { value: 'dark', label: 'Dark' },
];

const submit = () => {
    form.post(route('settings.update'));
};
</script>

<template>
    <AppLayout>
        <Head title="Settings" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Settings
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Branding -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Branding</h3>
                                
                                <div>
                                    <Input
                                        v-model="form.site_title"
                                        type="text"
                                        label="Site Title"
                                        :error="form.errors.site_title"
                                    />
                                </div>

                                <div>
                                    <Input
                                        v-model="form.site_logo"
                                        type="text"
                                        label="Site Logo URL"
                                        :error="form.errors.site_logo"
                                    />
                                </div>

                                <div>
                                    <Input
                                        v-model="form.site_favicon"
                                        type="text"
                                        label="Site Favicon URL"
                                        :error="form.errors.site_favicon"
                                    />
                                </div>

                                <div>
                                    <Select
                                        v-model="form.site_theme"
                                        :options="themes"
                                        label="Site Theme"
                                        :error="form.errors.site_theme"
                                    />
                                </div>
                            </div>

                            <!-- Xtream API -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Xtream API</h3>

                                <div>
                                    <Input
                                        v-model="form.xtream_api_url"
                                        type="text"
                                        label="API URL"
                                        :error="form.errors.xtream_api_url"
                                    />
                                </div>

                                <div>
                                    <Input
                                        v-model="form.xtream_username"
                                        type="text"
                                        label="Username"
                                        :error="form.errors.xtream_username"
                                    />
                                </div>

                                <div>
                                    <Input
                                        v-model="form.xtream_password"
                                        type="password"
                                        label="Password"
                                        :error="form.errors.xtream_password"
                                    />
                                </div>
                            </div>

                            <!-- EPG Settings -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">EPG Settings</h3>

                                <div>
                                    <Input
                                        v-model="form.epg_url"
                                        type="text"
                                        label="EPG URL"
                                        :error="form.errors.epg_url"
                                    />
                                </div>

                                <div>
                                    <Input
                                        v-model="form.epg_update_interval"
                                        type="number"
                                        label="Update Interval (seconds)"
                                        :error="form.errors.epg_update_interval"
                                    />
                                </div>
                            </div>

                            <!-- Security -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Security</h3>

                                <div>
                                    <Input
                                        v-model="form.api_token"
                                        type="text"
                                        label="API Token"
                                        :error="form.errors.api_token"
                                    />
                                </div>

                                <div>
                                    <Input
                                        v-model="form.allowed_ips"
                                        type="text"
                                        label="Allowed IPs (comma separated, * for all)"
                                        :error="form.errors.allowed_ips"
                                    />
                                </div>

                                <div>
                                    <Input
                                        v-model="form.max_connections"
                                        type="number"
                                        label="Max Connections"
                                        :error="form.errors.max_connections"
                                    />
                                </div>

                                <div class="flex items-center">
                                    <input
                                        type="checkbox"
                                        v-model="form.block_vpn"
                                        class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded"
                                    />
                                    <label class="ml-2 block text-sm text-gray-900">
                                        Block VPN Connections
                                    </label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-end space-x-3">
                                <Button
                                    type="submit"
                                    :disabled="form.processing"
                                >
                                    Save Settings
                                </Button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>