<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import AppPageHeader from '@/components/app/AppPageHeader.vue';
import AppPageShell from '@/components/app/AppPageShell.vue';
import AppSectionCard from '@/components/app/AppSectionCard.vue';
import AppCreateContextCard from '@/components/app/AppCreateContextCard.vue';
import AppFormActions from '@/components/app/AppFormActions.vue';
import WebProductoForm from './WebProductoForm.vue';
import * as WebProductoController from '@/actions/App/Http/Controllers/Admin/WebProductoController';


defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Tienda Online', href: '#' },
            { title: 'Catálogo Web', href: WebProductoController.index.url() },
            { title: 'Vincular Producto', href: '#' },
        ],
    },
});


const props = defineProps<{ 
    maestros: any[] 
}>();


const form = useForm({
    sku: '', 
    nombre_comercial: '', 
    nombre_generico: '', 
    descripcion: '',
    concentracion: '',
    forma_farmaceutica: '',
    precio_web: 0,
    requiere_receta: false,
    disponible: true,
    imagen: null as File | null,
});

// 4. Envío de datos
const submit = () => {
    form.post(WebProductoController.store.url(), {
        preserveScroll: true,
        forceFormData: true, 
    });
};
</script>

<template>
    <AppPageShell title="Publicar en Tienda" variant="wide">
        
        <AppPageHeader 
            title="Nuevo Producto Web" 
            subtitle="Cree un vínculo comercial a partir de un producto del Almacén Central."
            :backUrl="WebProductoController.index.url()"
        />

        <AppSectionCard>
           
            <AppCreateContextCard 
                title="Sincronización de Trazabilidad"
                :subtitle="form.nombre_comercial || 'Defina el nombre comercial'"
            />

            <form @submit.prevent="submit">
                <WebProductoForm :form="form" :maestros="maestros">
                    
                    
                    <template #actions>
                        <div class="pt-8 mt-8 border-t border-border/40">
                            <AppFormActions 
                                :backUrl="WebProductoController.index.url()" 
                                :processing="form.processing" 
                                submitLabel="Publicar en Tienda"
                            />
                        </div>
                    </template>

                </WebProductoForm>
            </form>
        </AppSectionCard>

    </AppPageShell>
</template>