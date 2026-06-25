<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import AppPageHeader from '@/components/app/AppPageHeader.vue'
import AppPageShell from '@/components/app/AppPageShell.vue'
import AppSectionCard from '@/components/app/AppSectionCard.vue'
import AppEditContextCard from '@/components/app/AppEditContextCard.vue'
import AppFormActions from '@/components/app/AppFormActions.vue'
import UserForm from './UserForm.vue'
import * as UserController from '@/actions/App/Http/Controllers/Admin/UserController'

const props = defineProps<{ 
    user: any, 
    roles: any[] 
}>();


const currentRole = props.user.roles.length > 0 ? props.user.roles[0].name : '';

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    role: currentRole,
    password: '', 
    password_confirmation: '',
});

const submit = () => {

    form.put(UserController.update.url(props.user.id), {
        preserveScroll: true,
        onSuccess: () => form.reset('password', 'password_confirmation'),
    });
};

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Seguridad', href: '#' },
            { title: 'Operadores', href: UserController.index.url() },
            { title: 'Editar Acceso', href: '#' },
        ],
    },
});
</script>

<template>
    <AppPageShell :title="'Editar Operador: ' + user.name" variant="narrow">
        
        <AppPageHeader 
            title="Modificar Cuenta" 
            subtitle="Actualice los privilegios de acceso o credenciales del personal."
            :backUrl="UserController.index.url()"
        />

        <AppSectionCard>

            <AppEditContextCard 
                title="Editando Credenciales de Sistema"
                :subtitle="user.name"
                :itemId="user.id"
                idLabel="ID de Operador"
            />

            <form @submit.prevent="submit">

                <UserForm :form="form" :roles="roles" :is-editing="true">
                    
                    <template #actions>
                        <div class="pt-8 mt-8 border-t border-border/40">
                            <AppFormActions 
                                :backUrl="UserController.index.url()" 
                                :processing="form.processing" 
                                submitLabel="Actualizar Operador"
                            />
                        </div>
                    </template>

                </UserForm>
            </form>


            <div class="mt-6 p-4 bg-amber-500/5 border border-amber-500/10 rounded-xl">
                <p class="text-[10px] text-amber-600 dark:text-amber-400 font-medium leading-relaxed">
                    <span class="font-black uppercase mr-1 italic">Aviso:</span> 
                    Si deja los campos de contraseña en blanco, el usuario mantendrá su clave actual. 
                    Al cambiar el rol, los permisos se actualizarán en el próximo inicio de sesión del operador.
                </p>
            </div>
        </AppSectionCard>
    </AppPageShell>
</template>