<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import AppPageHeader from '@/components/app/AppPageHeader.vue'
import AppPageShell from '@/components/app/AppPageShell.vue'
import AppSectionCard from '@/components/app/AppSectionCard.vue'
import AppCreateContextCard from '@/components/app/AppCreateContextCard.vue'
import AppFormActions from '@/components/app/AppFormActions.vue'
import UserForm from './UserForm.vue'
import * as UserController from '@/actions/App/Http/Controllers/Admin/UserController'

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Seguridad', href: '#' },
            { title: 'Operadores', href: UserController.index.url() },
            { title: 'Nuevo Operador', href: '#' },
        ],
    },
});

defineProps<{ roles: any[] }>();

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: '',
});

const submit = () => {
    form.post(UserController.store.url(), {
        onSuccess: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AppPageShell title="Registrar Operador" variant="narrow">
        
        <AppPageHeader 
            title="Nuevo Operador" 
            subtitle="Cree una cuenta para el personal administrativo y asigne su rol."
            :backUrl="UserController.index.url()"
        />

        <AppSectionCard>
            <AppCreateContextCard 
                title="Configuración de Acceso"
                :subtitle="form.name || 'Defina el nombre del usuario'"
            />

            <form @submit.prevent="submit">
                <UserForm :form="form" :roles="roles">
                    
                    <template #actions>
                        <div class="pt-8 mt-8 border-t border-border/40">
                            <AppFormActions 
                                :backUrl="UserController.index.url()" 
                                :processing="form.processing" 
                                submitLabel="Crear Cuenta"
                            />
                        </div>
                    </template>

                </UserForm>
            </form>
        </AppSectionCard>

    </AppPageShell>
</template>