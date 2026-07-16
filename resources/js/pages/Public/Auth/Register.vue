<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { UserPlus, ArrowRight, ShieldCheck } from 'lucide-vue-next';
import register from '@/routes/store/register'; 

const form = useForm({
    nombres: '',
    apellidos: '',
    dni: '',
    email: '',
    password: '',
    password_confirmation: '',
    telefono: '',
});

const submit = () => {

    form.post(register.attempt.url(), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Crear Cuenta PV" />

    <div class="max-w-xl mx-auto py-16 px-4">
        <div class="bg-white p-10 rounded-[2.5rem] border border-gray-100 shadow-sm">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-[#5790AB]/10 rounded-2xl text-[#5790AB] mb-4">
                    <UserPlus class="size-8" />
                </div>
                <h1 class="text-3xl font-black text-[#072D44] tracking-tight uppercase">PharmaVictoria</h1>
                <p class="text-gray-500 mt-2 font-medium">Crea tu identidad clínica y comercial.</p>
            </div>

            <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Nombres</label>
                    <input v-model="form.nombres" type="text" required class="h-12 bg-gray-50 border-none rounded-xl px-4 text-sm focus:ring-2 focus:ring-[#5790AB]/20 transition-all outline-none" />
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Apellidos</label>
                    <input v-model="form.apellidos" type="text" required class="h-12 bg-gray-50 border-none rounded-xl px-4 text-sm focus:ring-2 focus:ring-[#5790AB]/20 transition-all outline-none" />
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">DNI (8 Dígitos)</label>
                    <input v-model="form.dni" type="text" maxlength="8" required class="h-12 bg-gray-50 border-none rounded-xl px-4 text-sm font-mono outline-none" />
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Teléfono</label>
                    <input v-model="form.telefono" type="tel" class="h-12 bg-gray-50 border-none rounded-xl px-4 text-sm outline-none" />
                </div>

                <div class="md:col-span-2 flex flex-col gap-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Correo Electrónico</label>
                    <input v-model="form.email" type="email" required class="h-12 bg-gray-50 border-none rounded-xl px-4 text-sm outline-none" />
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Contraseña</label>
                    <input v-model="form.password" type="password" required class="h-12 bg-gray-50 border-none rounded-xl px-4 text-sm outline-none" />
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Confirmar</label>
                    <input v-model="form.password_confirmation" type="password" required class="h-12 bg-gray-50 border-none rounded-xl px-4 text-sm outline-none" />
                </div>

                <button type="submit" :disabled="form.processing"
                    class="md:col-span-2 h-14 bg-[#072D44] text-white rounded-2xl font-black flex items-center justify-center gap-3 hover:bg-[#5790AB] transition-all disabled:opacity-50 mt-4 tracking-widest">
                    <span>REGISTRAR MI CUENTA</span>
                    <ArrowRight class="size-5" />
                </button>
            </form>
        </div>
    </div>
</template>