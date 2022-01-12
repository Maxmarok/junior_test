import Music from './components/Music.vue'

let url = process.env.MIX_APP_PATH;

export const routes = [
  { path: url + 'music', name: 'music', component: Music },
];
