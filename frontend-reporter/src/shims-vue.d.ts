// TypeScript-am norāda ka visi .vue faili ir vue componenti (tā lai nemet error-us)
declare module '*.vue' {
    import { DefineComponent } from 'vue';
    const component: DefineComponent<{}, {}, any>;
    export default component;
}
  