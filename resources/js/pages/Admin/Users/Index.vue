<script setup lang="ts">
import { router, Link, Head } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import debounce from 'lodash/debounce'
import { 
    Search, UserPlus, Edit3, Trash2, 
    ShieldCheck, Mail, Calendar, Fingerprint 
} from 'lucide-vue-next'

import AppLayout from '@/layouts/AppLayout.vue'
import AppPageHeader from '@/components/app/AppPageHeader.vue'
import AppPageShell from '@/components/app/AppPageShell.vue'
import AppSectionCard from '@/components/app/AppSectionCard.vue'
import AppStatusBadge from '@/components/app/AppStatusBadge.vue'
import DeleteConfirmModal from '@/components/DeleteConfirmModal.vue'

import * as UserController from '@/actions/App/Http/Controllers/Admin/UserController'


defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Seguridad', href: '#' },
            { title: 'Operadores del Sistema', href: '#' },
        ],
    },
});

const props = defineProps<{
    users: any
    filters: { search?: string }
}>()


const search = ref(props.filters?.search ?? '')
const applyFilters = () => {
    router.get(UserController.index.url(), { search: search.value }, { preserveState: true, replace: true })
}
watch(search, debounce(() => applyFilters(), 400))


const mostrarModalEliminar = ref(false)
const usuarioSeleccionado = ref<any>(null)
const eliminando = ref(false)

const abrirModalEliminar = (u: any) => {
    usuarioSeleccionado.value = u
    mostrarModalEliminar.value = true
}

const confirmarEliminacion = () => {
    eliminando.value = true
    router.delete(UserController.destroy.url(usuarioSeleccionado.value.id), {
        onSuccess: () => mostrarModalEliminar.value = false,
        onFinish: () => eliminando.value = false
    })
}


const getRoleColor = (roleName: string) => {
    if (roleName === 'administrador') return 'bg-gold-500/10 text-gold-500 border-gold-500/20';
    return 'bg-primary/10 text-primary border-primary/20';
}
</script>

<template>
    <Head title="Gestión de Operadores" />

    <AppPageShell title="Seguridad y Accesos" variant="full">

        <AppPageHeader 
            title="Operadores del Sistema" 
            subtitle="Gestione las cuentas del personal administrativo y sus permisos de acceso."
        >
            <template #actions>
                <Link
                    :href="UserController.create.url()"
                    class="bg-primary text-primary-foreground px-6 py-2.5 rounded-xl font-black shadow-lg hover:opacity-90 transition flex items-center gap-2 text-xs uppercase tracking-widest"
                >
                    <UserPlus class="size-4" /> Nuevo Operador
                </Link>
            </template>
        </AppPageHeader>


        <AppSectionCard>
            <div class="relative max-w-xl">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground/50">
                    <Search class="size-4" />
                </span>
                <input
                    v-model="search"
                    type="text"
                    placeholder="Buscar por nombre o correo..."
                    class="w-full h-12 pl-12 pr-4 py-2 text-sm rounded-2xl border-border bg-background/50 text-foreground focus:ring-2 focus:ring-primary/40 outline-none transition"
                />
            </div>
        </AppSectionCard>


        <AppSectionCard fill noPadding title="Personal con Acceso a la Consola">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-border text-sm text-left border-collapse">
                    <thead class="bg-muted/40 text-muted-foreground font-black uppercase text-[10px] tracking-[0.2em] border-b border-border">
                        <tr>
                            <th class="px-8 py-5">Nombre / Usuario</th>
                            <th class="px-8 py-5">Rol de Sistema</th>
                            <th class="px-8 py-5">Fecha de Registro</th>
                            <th class="px-8 py-5 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50 text-foreground">
                        <tr v-for="u in users.data" :key="u.id" class="hover:bg-primary/2 transition-colors group">

                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="size-10 rounded-xl bg-navy-900 border border-white/5 flex items-center justify-center font-black text-primary uppercase shadow-inner">
                                        {{ u.name[0] }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-black text-foreground text-sm uppercase tracking-tighter">{{ u.name }}</span>
                                        <span class="text-[10px] text-muted-foreground flex items-center gap-1">
                                            <Mail class="size-3" /> {{ u.email }}
                                        </span>
                                    </div>
                                </div>
                            </td>


                            <td class="px-8 py-6">
                                <div class="flex flex-wrap gap-2">
                                    <span 
                                        v-for="role in u.roles" :key="role.id"
                                        :class="['px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase border tracking-widest', getRoleColor(role.name)]"
                                    >
                                        {{ role.name }}
                                    </span>
                                    <span v-if="u.roles.length === 0" class="text-[9px] text-muted-foreground uppercase italic">Sin rol asignado</span>
                                </div>
                            </td>


                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2 text-xs text-muted-foreground font-medium">
                                    <Calendar class="size-3" />
                                    {{ new Date(u.created_at).toLocaleDateString() }}
                                </div>
                            </td>


                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-4">
                                    <Link 
                                        :href="UserController.edit.url(u.id)"
                                        class="text-amber-500 font-black uppercase text-[10px] tracking-widest hover:underline flex items-center gap-1.5"
                                    >
                                        <Edit3 class="size-3.5" /> Editar
                                    </Link>
                                    
                                    
                                    <button 
                                        v-if="u.id !== ($page.props.auth.user?.id || 0)"
                                        @click="abrirModalEliminar(u)"
                                        class="text-red-500 font-black uppercase text-[10px] tracking-widest hover:underline flex items-center gap-1.5"
                                    >
                                        <Trash2 class="size-3.5" /> Quitar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </AppSectionCard>

        <DeleteConfirmModal 
            :show="mostrarModalEliminar"
            :itemName="usuarioSeleccionado?.name"
            type="operador del sistema"
            :processing="eliminando"
            @close="mostrarModalEliminar = false"
            @confirm="confirmarEliminacion"
        />

    </AppPageShell>
</template>