import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
import productos from './productos'
import pedidos from './pedidos'
import clientes from './clientes'
/**
* @see routes/web.php:33
* @route '/admin/dashboard'
*/
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ["get","head"],
    url: '/admin/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
* @see routes/web.php:33
* @route '/admin/dashboard'
*/
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
* @see routes/web.php:33
* @route '/admin/dashboard'
*/
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

/**
* @see routes/web.php:33
* @route '/admin/dashboard'
*/
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

const admin = {
    dashboard: Object.assign(dashboard, dashboard),
    productos: Object.assign(productos, productos),
    pedidos: Object.assign(pedidos, pedidos),
    clientes: Object.assign(clientes, clientes),
}

export default admin