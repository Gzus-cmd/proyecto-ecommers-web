import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\WebPedidoController::index
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/pedidos',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::index
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::index
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::index
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::create
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/admin/pedidos/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::create
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::create
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::create
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::store
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/pedidos',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::store
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::store
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::show
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos/{pedido}'
*/
export const show = (args: { pedido: string | number } | [pedido: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/admin/pedidos/{pedido}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::show
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos/{pedido}'
*/
show.url = (args: { pedido: string | number } | [pedido: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { pedido: args }
    }

    if (Array.isArray(args)) {
        args = {
            pedido: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        pedido: args.pedido,
    }

    return show.definition.url
            .replace('{pedido}', parsedArgs.pedido.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::show
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos/{pedido}'
*/
show.get = (args: { pedido: string | number } | [pedido: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::show
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos/{pedido}'
*/
show.head = (args: { pedido: string | number } | [pedido: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::edit
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos/{pedido}/edit'
*/
export const edit = (args: { pedido: string | number } | [pedido: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/admin/pedidos/{pedido}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::edit
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos/{pedido}/edit'
*/
edit.url = (args: { pedido: string | number } | [pedido: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { pedido: args }
    }

    if (Array.isArray(args)) {
        args = {
            pedido: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        pedido: args.pedido,
    }

    return edit.definition.url
            .replace('{pedido}', parsedArgs.pedido.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::edit
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos/{pedido}/edit'
*/
edit.get = (args: { pedido: string | number } | [pedido: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::edit
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos/{pedido}/edit'
*/
edit.head = (args: { pedido: string | number } | [pedido: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::update
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos/{pedido}'
*/
export const update = (args: { pedido: string | number } | [pedido: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/admin/pedidos/{pedido}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::update
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos/{pedido}'
*/
update.url = (args: { pedido: string | number } | [pedido: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { pedido: args }
    }

    if (Array.isArray(args)) {
        args = {
            pedido: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        pedido: args.pedido,
    }

    return update.definition.url
            .replace('{pedido}', parsedArgs.pedido.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::update
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos/{pedido}'
*/
update.put = (args: { pedido: string | number } | [pedido: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::update
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos/{pedido}'
*/
update.patch = (args: { pedido: string | number } | [pedido: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::destroy
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos/{pedido}'
*/
export const destroy = (args: { pedido: string | number } | [pedido: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/pedidos/{pedido}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::destroy
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos/{pedido}'
*/
destroy.url = (args: { pedido: string | number } | [pedido: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { pedido: args }
    }

    if (Array.isArray(args)) {
        args = {
            pedido: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        pedido: args.pedido,
    }

    return destroy.definition.url
            .replace('{pedido}', parsedArgs.pedido.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\WebPedidoController::destroy
* @see app/Http/Controllers/Admin/WebPedidoController.php:0
* @route '/admin/pedidos/{pedido}'
*/
destroy.delete = (args: { pedido: string | number } | [pedido: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const pedidos = {
    index: Object.assign(index, index),
    create: Object.assign(create, create),
    store: Object.assign(store, store),
    show: Object.assign(show, show),
    edit: Object.assign(edit, edit),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
}

export default pedidos