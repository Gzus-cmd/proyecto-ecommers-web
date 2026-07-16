<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { UserPlus, ArrowRight, ShieldCheck, Mail, Lock, User, Smartphone, CreditCard } from 'lucide-vue-next';
import register from '@/routes/store/register'; 
import AuthSimpleLayout from '@/layouts/auth/AuthSimpleLayout.vue';

defineOptions({ 
    layout: AuthSimpleLayout
});

const form = useForm({
    nombres: '', apellidos: '', dni: '', email: '',
    password: '', password_confirmation: '', telefono: '',
});

const submit = () => {
    form.post(register.attempt.url(), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Crear Perfil de Paciente" />

    <div class="space-y-8">
        <div class="text-center lg:text-left">
            <h1 class="text-3xl font-black text-[#072D44] tracking-tighter uppercase italic">Crear Perfil</h1>
            <p class="text-sm text-muted-foreground font-medium">Únase a nuestra red de salud digital.</p>
        </div>

        <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div class="space-y-1">
                <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 italic ml-1">Nombres</label>
                <div class="relative">
                    <User class="absolute left-3 top-1/2 -translate-y-1/2 size-3.5 text-gray-300" />
                    <input v-model="form.nombres" type="text" required class="w-full h-11 bg-gray-50 border-none rounded-xl pl-10 text-xs outline-none focus:ring-2 focus:ring-[#5790AB]/20" />
                </div>
            </div>


            <div class="space-y-1">
                <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 italic ml-1">Apellidos</label>
                <input v-model="form.apellidos" type="text" required class="w-full h-11 bg-gray-50 border-none rounded-xl px-4 text-xs outline-none focus:ring-2 focus:ring-[#5790AB]/20" />
            </div>


            <div class="space-y-1">
                <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 italic ml-1">DNI (8 Dígitos)</label>
                <div class="relative">
                    <CreditCard class="absolute left-3 top-1/2 -translate-y-1/2 size-3.5 text-gray-300" />
                    <input v-model="form.dni" type="text" maxlength="8" required class="w-full h-11 bg-gray-50 border-none rounded-xl pl-10 text-xs font-mono outline-none" />
                </div>
            </div>


            <div class="space-y-1">
                <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 italic ml-1">Teléfono móvil</label>
                <div class="relative">
                    <Smartphone class="absolute left-3 top-1/2 -translate-y-1/2 size-3.5 text-gray-300" />
                    <input v-model="form.telefono" type="tel" class="w-full h-11 bg-gray-50 border-none rounded-xl pl-10 text-xs outline-none" />
                </div>
            </div>


            <div class="md:col-span-2 space-y-1">
                <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 italic ml-1">Correo Electrónico</label>
                <div class="relative">
                    <Mail class="absolute left-3 top-1/2 -translate-y-1/2 size-3.5 text-gray-300" />
                    <input v-model="form.email" type="email" required class="w-full h-11 bg-gray-50 border-none rounded-xl pl-10 text-xs outline-none" />
                </div>
            </div>


            <div class="space-y-1">
                <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 italic ml-1">Contraseña</label>
                <div class="relative">
                    <Lock class="absolute left-3 top-1/2 -translate-y-1/2 size-3.5 text-gray-300" />
                    <input v-model="form.password" type="password" required class="w-full h-11 bg-gray-50 border-none rounded-xl pl-10 text-xs outline-none" />
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 italic ml-1">Confirmar</label>
                <input v-model="form.password_confirmation" type="password" required class="w-full h-11 bg-gray-50 border-none rounded-xl px-4 text-xs outline-none" />
            </div>

            <button type="submit" :disabled="form.processing"
                class="md:col-span-2 h-14 bg-[#072D44] text-white rounded-2xl font-black flex items-center justify-center gap-3 hover:bg-[#5790AB] transition-all disabled:opacity-50 mt-4 tracking-widest text-xs uppercase italic">
                <span>Crear mi Perfil Comercial</span>
                <ArrowRight class="size-4" />
            </button>
        </form>

        <p class="text-center text-xs text-gray-400 font-medium">
            ¿Ya es parte de PharmaVictoria? 
            <Link href="/login" class="text-[#5790AB] font-black hover:underline uppercase ml-1">Ingresar</Link>
        </p>
    </div>
</template>