<script setup lang="ts">
import { useForm, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Package, Trash2 } from 'lucide-vue-next'

import AppLayout from '@/layouts/AppLayout.vue'
import AppPageHeader from '@/components/app/AppPageHeader.vue'
import AppPageShell from '@/components/app/AppPageShell.vue'
import AppSectionCard from '@/components/app/AppSectionCard.vue'
import AppEditContextCard from '@/components/app/AppEditContextCard.vue'
import AppFormActions from '@/components/app/AppFormActions.vue'
import DeleteConfirmModal from '@/components/DeleteConfirmModal.vue'
import WebProductoForm from './WebProductoForm.vue'

import * as WebProductoController from '@/actions/App/Http/Controllers/Admin/WebProductoController'

const props = defineProps<{ producto: any }>()


const form = useForm({
    _method: 'PUT', 
    sku: props.producto.sku,
    nombre_comercial: props.producto.nombre_comercial,
    nombre_generico: props.producto.nombre_generico,
    descripcion: props.producto.descripcion,
    concentracion: props.producto.concentracion,
    forma_farmaceutica: props.producto.forma_farmaceutica,
    precio_web: props.producto.precio_web,
    requiere_receta: !!props.producto.requiere_receta,
    disponible: !!props.producto.disponible,
    imagen: null as File | null,
    imagen_url_actual: props.producto.imagen_url,
})


const mostrarModalEliminar = ref(false)
const eliminando = ref(false)

const confirmarEliminacion = () => {
    eliminando.value = true
    router.delete(WebProductoController.destroy.url(props.producto.id))
}

const submit = () => {
    form.post(WebProductoController.update.url(props.producto.sku), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppPageShell :title="'Editar: ' + producto.nombre_comercial" variant="wide">
        
        <AppPageHeader 
            title="Editar Publicación" 
            subtitle="Gestione los datos comerciales y multimedia del producto."
            :backUrl="WebProductoController.index.url()"
        >
            <template #actions>
                <button
                    type="button"
                    @click="mostrarModalEliminar = true"
                    class="bg-red-500/10 text-red-500 border border-red-500/20 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all flex items-center gap-2"
                >
                    <Trash2 class="size-3.5" /> Dar de Baja en Web
                </button>
            </template>
        </AppPageHeader>

        <AppSectionCard>

            <AppEditContextCard 
                title="Modificando Producto Vinculado"
                :subtitle="producto.nombre_comercial"
                :itemId="producto.sku"
                idLabel="SKU Central"
            />

            <form @submit.prevent="submit">

                <WebProductoForm :form="form" :maestros="[]" :isEditing="true">
                    
                    <template #actions>
                        <div class="pt-8 mt-8 border-t border-border/40">
                            <AppFormActions 
                                :backUrl="WebProductoController.index.url()" 
                                :processing="form.processing" 
                                submitLabel="Guardar Cambios"
                            />
                        </div>
                    </template>

                </WebProductoForm>
            </form>
        </AppSectionCard>


        <DeleteConfirmModal 
            :show="mostrarModalEliminar"
            :itemName="producto.nombre_comercial"
            type="publicación de la web"
            :processing="eliminando"
            @close="mostrarModalEliminar = false"
            @confirm="confirmarEliminacion"
        />

    </AppPageShell>
</template>