<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import AppPageHeader from '@/components/app/AppPageHeader.vue'
import AppPageShell from '@/components/app/AppPageShell.vue'
import AppSectionCard from '@/components/app/AppSectionCard.vue'
import AppEditContextCard from '@/components/app/AppEditContextCard.vue'
import AppFormActions from '@/components/app/AppFormActions.vue'
import WebClienteForm from './WebClienteForm.vue'
import * as WebClienteController from '@/actions/App/Http/Controllers/Admin/WebClienteController'

const props = defineProps<{ cliente: any }>()


const form = useForm({
    nombres: props.cliente.nombres,
    apellidos: props.cliente.apellidos,
    dni: props.cliente.dni,
    email: props.cliente.email,
    telefono: props.cliente.telefono,
    activo: !!props.cliente.activo,
})

const submit = () => {
    form.put(WebClienteController.update.url(props.cliente.id), {
        preserveScroll: true
    });
}

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Gestión Comercial', href: '#' },
            { title: 'Clientes', href: WebClienteController.index.url() },
            { title: 'Editar Perfil', href: '#' },
        ],
    },
});
</script>

<template>
    <AppPageShell :title="'Editar: ' + cliente.apellidos" variant="narrow">
        
        <AppPageHeader 
            title="Editar Perfil" 
            subtitle="Actualice la información de contacto o identidad legal del cliente."
            :backUrl="WebClienteController.index.url()"
        />

        <AppSectionCard>

            <AppEditContextCard 
                title="Modificando Usuario Registrado"
                :subtitle="cliente.nombres + ' ' + cliente.apellidos"
                :itemId="cliente.dni"
                idLabel="Documento DNI"
            />

                <form @submit.prevent="submit">
                    <WebClienteForm :form="form">
                        
                        <template #actions>
                            <div class="pt-8 mt-8 border-t border-border/40">
                                <AppFormActions 
                                    :backUrl="WebClienteController.index.url()" 
                                    :processing="form.processing" 
                                    submitLabel="Guardar Cambios"
                                />
                            </div>
                        </template>

                    </WebClienteForm>
                </form>
        </AppSectionCard>
    </AppPageShell>
</template>