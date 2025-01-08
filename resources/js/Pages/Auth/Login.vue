<script setup>
import { useForm } from "@inertiajs/vue3";
import Input from "@/Components/Input.vue";
import Button from "@/Components/Button.vue";

const form = useForm({
    username: "",
    password: "",
});

const submit = () => {
    form.post(route("login"));
};
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold text-gray-900">
                    Welcome Back
                </h1>
                <p class="mt-2 text-sm text-gray-600">
                    Please sign in to your account
                </p>
            </div>

            <form @submit.prevent="submit">
                <div class="space-y-6">
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
                            label="Password"
                            :error="form.errors.password"
                        />
                    </div>

                    <div>
                        <Button
                            class="w-full justify-center"
                            :disabled="form.processing"
                        >
                            Sign in
                        </Button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
