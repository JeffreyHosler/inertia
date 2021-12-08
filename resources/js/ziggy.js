const Ziggy = {"url":"http:\/\/inertia.local","port":null,"defaults":{},"routes":{"login":{"uri":"login","methods":["GET","HEAD"]},"home":{"uri":"\/","methods":["GET","HEAD"]},"admin.dashboard":{"uri":"admin","methods":["GET","HEAD"]},"admin.users":{"uri":"admin\/users","methods":["GET","HEAD"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
