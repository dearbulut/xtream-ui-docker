<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";

const props = defineProps({
    user: Object,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    username: props.user.username,
    password: "",
    password_confirmation: "",
});

const deleteForm = useForm({
    password: "",
});

const updateProfile = () => {
    form.patch(route("profile.update"), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset("password", "password_confirmation");
        },
    });
};

const deleteAccount = () => {
    if (confirm("Are you sure you want to delete your account?")) {
        deleteForm.delete(route("profile.destroy"));
    }
};
</script>

<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Profile Information
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Update your account's profile information and email address.
                            </p>
                        </header>

                        <form @submit.prevent="updateProfile" class="mt-6 space-y-6">
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
                                    v-model="form.email"
                                    type="email"
                                    label="Email"
                                    :error="form.errors.email"
                                />
                            </div>

                            <div>
                                <Input
                                    v-model="form.username"
                                    type="text"
                                    label="Username"
                                    :error="form.errors.username"
                                />
                            </div>

                            <div>
                                <Input
                                    v-model="form.password"
                                    type="password"
                                    label="New Password"
                                    :error="form.errors.password"
                                />
                            </div>

                            <div>
                                <Input
                                    v-model="form.password_confirmation"
                                    type="password"
                                    label="Confirm Password"
                                    :error="form.errors.password_confirmation"
                                />
                            </div>

                            <div class="flex items-center gap-4">
                                <Button :disabled="form.processing">Save</Button>
                            </div>
                        </form>
                    </section>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section class="space-y-6">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Delete Account
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Once your account is deleted, all of its resources and data will be permanently deleted.
                            </p>
                        </header>

                        <form @submit.prevent="deleteAccount" class="space-y-6">
                            <div>
                                <Input
                                    v-model="deleteForm.password"
                                    type="password"
                                    label="Password"
                                    :error="deleteForm.errors.password"
                                />
                            </div>

                            <div class="flex items-center gap-4">
                                <Button variant="danger" :disabled="deleteForm.processing">
                                    Delete Account
                                </Button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
