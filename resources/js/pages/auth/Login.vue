<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { register } from '@/routes';
import { request } from '@/routes/password';
import AuthSimpleLayout from '@/layouts/auth/AuthSimpleLayout.vue';


defineOptions({
    layout: AuthSimpleLayout,
});


const props = defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>();


const form = useForm({
    email: '',
    password: '',
    remember: false,
});


const submit = () => {
    form.post('/login', {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>

    <Head title="Ingresar al Portal" />


    <div v-if="props.status" class="mb-6 p-4 rounded-xl bg-green-50 text-center text-xs font-bold text-green-600 border border-green-100">
        {{ props.status }}
    </div>


    <form @submit.prevent="submit" class="flex flex-col gap-6">
        <div class="grid gap-5">
            

            <div class="grid gap-2">
                <Label for="email" class="text-[10px] font-black uppercase tracking-widest text-gray-400 italic">Correo Electrónico</Label>
                <Input
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    autofocus
                    class="h-12 rounded-xl border-gray-100 bg-gray-50/50 focus:ring-[#5790AB]/20"
                    placeholder="ejemplo@pharmavictoria.com"
                />
                <InputError :message="form.errors.email" />
            </div>


            <div class="grid gap-2">
                <div class="flex items-center justify-between px-1">
                    <Label for="password" class="text-[10px] font-black uppercase tracking-widest text-gray-400 italic">Contraseña</Label>
                    <TextLink v-if="props.canResetPassword" :href="request()" class="text-[10px] font-black text-[#5790AB] uppercase hover:underline">
                        ¿Olvidó su clave?
                    </TextLink>
                </div>
                <PasswordInput
                    id="password"
                    v-model="form.password"
                    required
                    class="h-12 rounded-xl border-gray-100 bg-gray-50/50"
                    placeholder="Contraseña"
                />
                <InputError :message="form.errors.password" />
            </div>


            <div class="flex items-center justify-between px-1">
                <div class="flex items-center space-x-3 cursor-pointer group">
                    <Checkbox id="remember" v-model:checked="form.remember" class="rounded-md border-gray-300 text-[#072D44]" />
                    <Label for="remember" class="text-xs font-bold text-gray-400 group-hover:text-[#072D44] transition-colors cursor-pointer">
                        Recordar sesión
                    </Label>
                </div>
            </div>


            <Button
                type="submit"
                class="mt-4 h-12 rounded-xl bg-[#072D44] hover:bg-[#5790AB] text-white font-black uppercase tracking-widest transition-all shadow-lg shadow-[#072D44]/10"
                :disabled="form.processing"
            >
                <Spinner v-if="form.processing" class="mr-2" />
                Ingresar al Portal
            </Button>
        </div>


        <div class="relative my-4 text-center">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-100"></div></div>
            <span class="relative bg-white px-4 text-[10px] font-black text-gray-300 uppercase tracking-widest italic">¿No tiene cuenta?</span>
        </div>

        <Button
            v-if="props.canRegister"
            variant="outline"
            as-child
            class="h-12 rounded-xl border-[#5790AB] text-[#5790AB] font-black uppercase tracking-widest hover:bg-[#5790AB]/5"
        >
            <Link :href="register()">Crear Perfil de Paciente</Link>
        </Button>
    </form>
</template>