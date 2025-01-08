const Ziggy = {"url":"http:\/\/localhost","port":null,"defaults":{},"routes":{"xtream.panel":{"uri":"xtream\/panel","methods":["GET","HEAD"]},"xtream.settings":{"uri":"xtream\/settings","methods":["GET","HEAD"]},"xtream.settings.update":{"uri":"xtream\/settings","methods":["POST"]},"xtream.cache-epg":{"uri":"xtream\/cache\/epg","methods":["POST"]},"xtream.sync-channels":{"uri":"xtream\/cache\/channels","methods":["POST"]},"xtream.cleanup-cache":{"uri":"xtream\/cache\/clear","methods":["POST"]},"storage.local":{"uri":"storage\/{path}","methods":["GET","HEAD"],"wheres":{"path":".*"},"parameters":["path"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
